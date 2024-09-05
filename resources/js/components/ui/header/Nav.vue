<script setup lang="ts">
import { RouterLink } from 'vue-router';
import Button from '@/components/ui/button/Button.vue';
</script>

<template>
  <nav class="flex justify-end items-center gap-4 flex-1">
    <RouterLink to="/">
      Usuários
    </RouterLink>
    <RouterLink to="/new">
      <Button variant="secondary">
        Novo usuário
      </Button>
    </RouterLink>
  </nav>
</template>