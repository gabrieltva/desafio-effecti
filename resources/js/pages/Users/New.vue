<script setup lang="ts">
import { h, ref } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'

import { Button } from '@/components/ui/button'
import {
  Form,
  FormControl,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { toast } from '@/components/ui/toast'
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue, SelectGroup } from '@/components/ui/select'

const statesField = [
  "AC",
  "AL",
  "AP",
  "AM",
  "BA",
  "CE",
  "DF",
  "ES",
  "GO",
  "MA",
  "MT",
  "MS",
  "MG",
  "PA",
  "PB",
  "PR",
  "PE",
  "PI",
  "RJ",
  "RN",
  "RS",
  "RO",
  "RR",
  "SC",
  "SP",
  "SE",
  "TO"
]

const formSchema = toTypedSchema(z.object({
  name: z.string().min(2).max(50),
  cpf: z.string().regex(/^\d{3}\.\d{3}\.\d{3}-\d{2}$/),
  birth_date: z.string().regex(/^\d{4}-\d{2}-\d{2}$/),
  email: z.string().email(),
  phone: z.string().regex(/^\(\d{2}\) \d{5}-\d{4}$/),
  cep: z.string().regex(/^\d{5}-\d{3}$/),
  state: z.string().length(2),
  city: z.string().min(2).max(50),
  neighborhood: z.string().min(2).max(50),
  address: z.string().min(2).max(100),
  status: z.number().min(0).max(1),
}))

const { handleSubmit } = useForm({
  validationSchema: formSchema,
})

const onSubmit = handleSubmit((values) => {
  toast({
    title: 'You submitted the following values:',
    description: h('pre', { class: 'mt-2 w-[340px] rounded-md bg-slate-950 p-4' }, h('code', { class: 'text-white' }, JSON.stringify(values, null, 2))),
  })
})

const createMask = (value: string, mask: string): string => {
  value = value.replace(/\D/g, '')
  
  let maskedValue = ''
  let valueIndex = 0

  for (let i = 0; i < mask.length; i++) {
    if (mask[i] === '#') {
      if (value[valueIndex]) {
        maskedValue += value[valueIndex++]
      } else {
        break
      }
    } else {
      maskedValue += mask[i]
    }
  }

  return maskedValue
}

</script>

<template>
  <Form class="p-10 bg-zinc-800 shadow lg:w-1/2 space-y-4 mx-auto" @submit="onSubmit">
    <h1 class="text-white text-3xl font-bold tracking-tight">
      Novo usuário
    </h1>

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6 pb-4">
      <FormField v-slot="{ componentField }" name="name">
        <FormItem class="col-span-4">
          <FormLabel class="text-white">Nome</FormLabel>
          <FormControl>
            <Input type="text" placeholder="Insira o nome" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="cpf">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">CPF</FormLabel>
          <FormControl>
            <Input type="text" placeholder="000.000.000-00" v-bind="componentField"
              @input="componentField.value = createMask(componentField.value, '###.###.###-##')" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="birth_date">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">Data de nascimento</FormLabel>
          <FormControl>
            <Input type="text" placeholder="00/00/0000" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="email">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">E-mail</FormLabel>
          <FormControl>
            <Input type="text" placeholder="Insira o e-mail" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="phone">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">Telefone</FormLabel>
          <FormControl>
            <Input type="text" placeholder="(00) 00000-0000" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="cep">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">CEP</FormLabel>
          <FormControl>
            <Input type="text" placeholder="00000-000" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="state">
        <FormItem class="col-span-1">
          <FormLabel class="text-white">Estado</FormLabel>
          <FormControl>

            <Select v-bind="componentField">
              <SelectTrigger>
                <SelectValue placeholder="__" />
              </SelectTrigger>
              <SelectContent>
                <SelectGroup>
                  <SelectItem v-for="state in statesField" :value="state">
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
        <FormItem class="col-span-3">
          <FormLabel class="text-white">Cidade</FormLabel>
          <FormControl>
            <Input type="text" placeholder="" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="neighborhood">
        <FormItem class="col-span-2">
          <FormLabel class="text-white">Bairro</FormLabel>
          <FormControl>
            <Input type="text" placeholder="" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="address">
        <FormItem class="col-span-4">
          <FormLabel class="text-white">Endereço</FormLabel>
          <FormControl>
            <Input type="text" placeholder="" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
    </div>
    <div class="space-x-4">
      <Button variant="destructive" size="lg">
        <router-link to="/">
          Cancelar
        </router-link>
      </Button>
      <Button type="submit" size="lg">
        Cadastrar
      </Button>
    </div>
  </Form>
</template>