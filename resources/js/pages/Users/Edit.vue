<script setup>
import { onMounted, ref } from 'vue';
import FormUser from '@/components/form-user/FormUser.vue';
import { useToast } from '@/components/ui/toast/use-toast';
import { getUser } from '@/services/api';
import { SymbolIcon } from '@radix-icons/vue';
import { useRoute, useRouter } from 'vue-router';

const route = useRoute();
const router = useRouter();
const { toast } = useToast();
const isLoading = ref(true);
const userData = ref(null);

const onExecute = () => {
  toast({
    title: 'Usuário atualizado',
    description: 'O usuário foi atualizado com sucesso',
    variant: 'success'
  });
};

const onError = () => {
  toast({
    title: 'Erro ao atualizar usuário',
    description: 'Ocorreu um erro ao atualizar o usuário, tente novamente',
    variant: 'destructive'
  });
};

const getUserData = async () => {
  try {
    const data = await getUser(route.params.id);
    userData.value = data;
    console.log(userData.value.name);
  } catch (error) {
    toast({
      title: 'Usuário não encontrado',
      description: 'O usuário não foi encontrado, tente novamente',
      variant: 'destructive'
    });

    router.push({ name: 'list' });
  } finally {
    isLoading.value = false;
  }
};

onMounted(() => {
  document.title = `${import.meta.env.VITE_APP_NAME} - Atualizar usuário`;
  getUserData();
});
</script>

<template>
  <div v-if="isLoading" class="p-10 bg-zinc-800 shadow lg:w-1/2 space-x-3 mx-auto flex items-center">
    <h1 class="text-2xl text-white font-bold">Carregando usuário</h1>
    <SymbolIcon class="w-6 h-6 animate-spin text-white" />
  </div>
  <FormUser v-else-if="userData" :data="userData" type="edit" @onExecute="onExecute" @onError="onError">
    <h1 class="text-2xl text-white font-bold">Atualizar usuário: {{ userData.name }}</h1>
  </FormUser>
</template>