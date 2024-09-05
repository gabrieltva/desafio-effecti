<script setup lang="ts">
import { RouterLink } from 'vue-router';
import Button from '@/components/ui/button/Button.vue';
import { PersonIcon, PlusIcon } from '@radix-icons/vue';
</script>

<template>
  <nav class="flex justify-end items-center gap-4 flex-1">
    <RouterLink to="/" class="flex gap-1 items-center">
      <PersonIcon class="w-4 h-4" />
      Usuários
    </RouterLink>
    <RouterLink to="/new">
      <Button class="bg-green-600 hover:bg-green-800 text-white gap-1">
        <PlusIcon class="w-4 h-4" />
        Novo usuário
      </Button>
    </RouterLink>
  </nav>
</template>