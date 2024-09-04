<script setup lang="ts">
import { h, ref } from 'vue'
import { useForm } from 'vee-validate'
import { toTypedSchema } from '@vee-validate/zod'
import * as z from 'zod'

import { Button } from '@/components/ui/button'
import {
  Form,
  FormControl,
  FormDescription,
  FormField,
  FormItem,
  FormLabel,
  FormMessage,
} from '@/components/ui/form'
import { Input } from '@/components/ui/input'
import { toast } from '@/components/ui/toast'

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
</script>

<template>
  <Form class="p-10 bg-zinc-800 shadow lg:w-1/2 space-y-4 mx-auto" @submit="onSubmit">
    <h1 class="text-white text-3xl font-bold tracking-tight">
      Novo usuário
    </h1>

    <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
      <FormField v-slot="{ componentField }" name="name">
        <FormItem class="col-span-4">
          <FormLabel>Nome</FormLabel>
          <FormControl>
            <Input type="text" placeholder="Sofia D'ávila Sobrinho" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="cpf">
        <FormItem class="col-span-2">
          <FormLabel>CPF</FormLabel>
          <FormControl>
            <Input type="text" placeholder="613.048.009-11" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="birth_date">
        <FormItem class="col-span-2">
          <FormLabel>Data de nascimento</FormLabel>
          <FormControl>
            <Input type="text" placeholder="1998-06-11" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="email">
        <FormItem class="col-span-2">
          <FormLabel>E-mail</FormLabel>
          <FormControl>
            <Input type="text" placeholder="rodolfo.matos@gil.com.br" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="phone">
        <FormItem class="col-span-2">
          <FormLabel>Telefone</FormLabel>
          <FormControl>
            <Input type="text" placeholder="(49) 98923-9978" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="cep">
        <FormItem>
          <FormLabel>CEP</FormLabel>
          <FormControl>
            <Input type="text" placeholder="70585-807" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="state">
        <FormItem>
          <FormLabel>State</FormLabel>
          <FormControl>
            <Input type="text" placeholder="AP" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="city">
        <FormItem>
          <FormLabel>City</FormLabel>
          <FormControl>
            <Input type="text" placeholder="Irene d'Oeste" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="neighborhood">
        <FormItem>
          <FormLabel>Neighborhood</FormLabel>
          <FormControl>
            <Input type="text" placeholder="do Norte" v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
      <FormField v-slot="{ componentField }" name="address">
        <FormItem>
          <FormLabel>Address</FormLabel>
          <FormControl>
            <Input type="text" placeholder="94291-749, Avenida Isadora Amaral, 82\nMatias do Leste - ES"
              v-bind="componentField" />
          </FormControl>
          <FormMessage />
        </FormItem>
      </FormField>
    </div>
    <Button type="submit">
      Submit
    </Button>
  </Form>
</template>