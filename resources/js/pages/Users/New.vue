<script setup>
import { onMounted } from 'vue';
import FormUser from '@/components/form-user/FormUser.vue';
import { useToast } from '@/components/ui/toast/use-toast'

onMounted(() => {
  document.title = `${import.meta.env.VITE_APP_NAME} - Novo usuário`
})

const { toast } = useToast()

const onExecute = () => {
  toast({
    title: 'Usuário cadastrado com sucesso',
    description: 'O usuário foi cadastrado com sucesso',
    variant: 'success'
  })
}

const onError = (message) => {
  toast({
    title: 'Erro ao cadastrar usuário',
    description: message,
    variant: 'destructive'
  })
}
</script>

<template>
  <FormUser type="new" @onExecute="onExecute" @onError="onError">
    <h1 class="text-2xl text-white font-bold">Novo usuário</h1>
  </FormUser>
</template>