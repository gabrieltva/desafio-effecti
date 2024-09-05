<script setup>
import { h, onMounted, ref } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'

import {
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Button } from '@/components/ui/button'
import { Input } from '@/components/ui/input'
import { useToast } from '@/components/ui/toast/use-toast'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, SelectGroup } from '@/components/ui/select'
import { fillAddressDataByCEP, statesField } from '@/utils/form'
import { registerUser } from '@/services/api'
import { SymbolIcon } from '@radix-icons/vue'

onMounted(() => {
  document.title = `${import.meta.env.VITE_APP_NAME} - Novo usuário`
})

const isLoading = ref(false)
const isLoadingCep = ref(false)
const { toast } = useToast()

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2).max(50),
  cpf: z.string().regex(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/),
  birth_date: z.string().regex(/^\d{2}\/\d{2}\/\d{4}$/),
  email: z.string().email(),
  phone: z.string().regex(/^\(?\d{2}\)?[\s-]?\d{4,5}[\s-]?\d{4}$/),
  cep: z.string().regex(/^\d{5}-\d{3}$/),
  state: z.string().length(2),
  city: z.string().min(2).max(50),
  neighborhood: z.string().min(2).max(50),
  address: z.string().min(2).max(100)
}))

const { handleSubmit, resetForm, setValues, values } = useForm({
  validationSchema: formSchema,
})

const onSubmit = handleSubmit(async (values) => {
  isLoading.value = true

  try {
    await registerUser(values)
  }
  catch (error) {
    toast({
      title: 'Erro ao cadastrar usuário',
      description: 'Ocorreu um erro ao cadastrar o usuário, tente novamente',
      variant: 'destructive'
    })

    return
  }
  finally {
    isLoading.value = false
  }

  // Reset form
  resetForm()

  toast({
    title: 'Usuário cadastrado com sucesso',
    description: 'O usuário foi cadastrado com sucesso',
    variant: 'success'
  })
})


const getCepData = async (cep) => {
  const data = await fillAddressDataByCEP(cep.modelValue, isLoadingCep)

  if (data) {
    setValues({
      state: data.uf ? data.uf : values.state,
      city: data.localidade ? data.localidade : values.city,
      neighborhood: data.bairro,
      address: data.logradouro
    })
  }
}

</script>

<template>
  <form class="p-10 bg-zinc-800 shadow lg:w-1/2 space-y-4 mx-auto" @submit="onSubmit">
    <h1 class="text-2xl text-white font-bold">Novo usuário</h1>

    <fieldset :disabled="isLoading">
      <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-4 sm:grid-cols-6 pb-4">
        <FormField v-slot="{ componentField }" name="name">
          <FormItem class="lg:col-span-4">
            <FormLabel class="text-white">Nome</FormLabel>
            <FormControl>
              <Input type="text" placeholder="Insira o nome" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="cpf">
          <FormItem class="lg:col-span-2">
            <FormLabel class="text-white">CPF</FormLabel>
            <FormControl>
              <Input type="text" placeholder="000.000.000-00" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="birth_date">
          <FormItem class="lg:col-span-2">
            <FormLabel class="text-white">Data de nascimento</FormLabel>
            <FormControl>
              <Input type="text" placeholder="00/00/0000" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="email">
          <FormItem class="lg:col-span-2">
            <FormLabel class="text-white">E-mail</FormLabel>
            <FormControl>
              <Input type="text" placeholder="Insira o e-mail" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="phone">
          <FormItem class="lg:col-span-2">
            <FormLabel class="text-white">Telefone</FormLabel>
            <FormControl>
              <Input type="text" placeholder="(00)00000-0000" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>


        <FormField v-slot="{ componentField }" name="cep">
          <FormItem class="lg:col-span-2 relative">
            <FormLabel class="text-white">CEP</FormLabel>
            <FormControl>
              <Input type="text" placeholder="00000-000" v-bind="componentField" @input="getCepData(componentField)"
                :disabled="isLoadingCep" />

              <SymbolIcon v-if="isLoadingCep" class="w-4 h-4 mr-2 animate-spin text-white absolute top-0 end-0" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="state">
          <FormItem class="lg:col-span-1">
            <FormLabel class="text-white">Estado</FormLabel>
            <FormControl>

              <Select v-bind="componentField">
                <SelectTrigger>
                  <SelectValue placeholder="__" />
                </SelectTrigger>
                <SelectContent>
                  <SelectGroup>
                    <SelectItem v-for="state in statesField" :value="state" :selected="componentField.value === state">
                      {{ state }}
                    </SelectItem>
                  </SelectGroup>
                </SelectContent>
              </Select>

            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="city">
          <FormItem class="lg:col-span-3">
            <FormLabel class="text-white">Cidade</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="neighborhood">
          <FormItem class="lg:col-span-2">
            <FormLabel class="text-white">Bairro</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
        <FormField v-slot="{ componentField }" name="address">
          <FormItem class="lg:col-span-4">
            <FormLabel class="text-white">Endereço</FormLabel>
            <FormControl>
              <Input type="text" placeholder="" v-bind="componentField" />
            </FormControl>
            <FormMessage />
          </FormItem>
        </FormField>
      </div>
      <div class="space-x-4 flex justify-end">
        <router-link to="/">
          <Button type="button" variant="destructive" size="lg">
            Cancelar
          </Button>
        </router-link>
        <Button type="submit" size="lg">
          <SymbolIcon v-if="isLoading" class="w-4 h-4 mr-2 animate-spin text-zinc-950" />
          Cadastrar
        </Button>
      </div>
    </fieldset>
  </form>
</template>