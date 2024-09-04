<script setup lang="ts">
import { Skeleton } from '@/components/ui/skeleton';
</script>

<template>
  <div class="flex space-x-3 mt-10">
    <Skeleton class="h-[50px] w-[50px] rounded-full" />
    <div class="space-y-3 flex flex-col flex-1">
      <Skeleton class="h-4 w-[100%]" />
      <Skeleton class="h-4 w-[70%]" />
    </div>
    <div class="space-y-3 flex flex-col">
      <Skeleton class="h-4 w-[80px]" />
      <Skeleton class="h-4 w-[65px]" />
    </div>
  </div>
</template>