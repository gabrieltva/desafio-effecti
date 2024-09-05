<script setup>
import {
  AlertDialog,
  AlertDialogAction,
  AlertDialogCancel,
  AlertDialogContent,
  AlertDialogDescription,
  AlertDialogFooter,
  AlertDialogHeader,
  AlertDialogTitle,
} from '@/components/ui/alert-dialog'
import { SymbolIcon } from '@radix-icons/vue';
import { ref } from 'vue';

const emit = defineEmits(['cancel', 'continue'])

const isLoading = ref(false)

const onContinue = () => {
  isLoading.value = true
  emit('continue')
}
</script>

<template>
  <AlertDialog :open="true">
    <slot />
    <AlertDialogContent>
      <AlertDialogHeader>
        <AlertDialogTitle>Tem certeza que deseja remover esse usuário</AlertDialogTitle>
        <AlertDialogDescription>
          Você está prestes a remover um usuário. Essa ação é irreversível.
        </AlertDialogDescription>
      </AlertDialogHeader>
      <AlertDialogFooter>
        <AlertDialogCancel @click="emit('cancel')">Cancelar</AlertDialogCancel>
        <AlertDialogAction @click="onContinue" :disabled="isLoading">
          <SymbolIcon v-if="isLoading" class="w-4 h-4 mr-2 animate-spin text-white" />
          Continuar
        </AlertDialogAction>
      </AlertDialogFooter>
    </AlertDialogContent>
  </AlertDialog>
</template>