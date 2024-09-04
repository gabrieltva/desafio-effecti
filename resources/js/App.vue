<script setup>
import Header from '@/components/ui/header/Header.vue'
</script>

<template>
  <div class="bg-zinc-900 min-h-dvh dark">
    <Header></Header>
    <div class="flex-1 space-y-4 p-8 pt-6">
      <router-view />
    </div>
  </div>
</template>