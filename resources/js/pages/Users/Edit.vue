<script setup>
import { ref } from 'vue';

const name = ref('');
const email = ref('');

const submitForm = () => {
  // Handle form submission here
  // You can access the updated user data using name.value and email.value
};
</script>

<template>
  <div>
    <h1>Edit User</h1>
    <form @submit="submitForm">
      <label for="name">Name:</label>
      <input type="text" id="name" v-model="name" required>

      <label for="email">Email:</label>
      <input type="email" id="email" v-model="email" required>

      <button type="submit">Save</button>
    </form>
  </div>
</template>