<script setup lang="ts">
import { FormControl, FormField, FormItem, FormLabel, FormMessage } from '@/components/ui/form';
import { Input } from '@/components/ui/input';
import { createMask } from '@/utils/form';

const props = defineProps({
  name: { type: String, required: true },
  colspan: { type: String, required: true, default: "4" },
  label: { type: [String, undefined], required: false },
  placeholder: { type: String, required: false },
  type: { type: String, required: false, default: 'text' },
  value: { type: [String, Number], required: false },
  required: { type: Boolean, required: false, default: false },
  mask: { type: String, required: false },
});
</script>


<template>
  <FormField v-slot="{ props }" :name=props.name>
    <FormItem class="lg:col-span-4">
      <FormLabel class="text-white">{{ props.label }}</FormLabel>
      <FormControl>
        <Input v-if="props.mask === undefined" :type="props.type" :placeholder="props.placeholder"
          :required="props.required" v-bind="props" />
        <Input v-else :type="props.type" :placeholder="props.placeholder" :required="props.required" v-bind="props"
          @input="props.value = createMask(props.value, props.mask)" />
      </FormControl>
      <FormMessage />
    </FormItem>
  </FormField>
</template>