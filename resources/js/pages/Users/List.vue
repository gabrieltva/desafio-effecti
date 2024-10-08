<script setup>
import { onMounted, ref } from 'vue';
import { getAllUser, deleteUser } from '@/services/api';
import SkeletonUserList from '@/components/ui/skeleton-user-list/SkeletonUserList.vue';
import { Table, TableBody, TableCell, TableHead, TableHeader, TableRow } from '@/components/ui/table';
import Button from '@/components/ui/button/Button.vue';
import { FileTextIcon, Pencil2Icon, PersonIcon, TrashIcon } from '@radix-icons/vue';
import { Input } from '@/components/ui/input';
import RemoveDialog from '@/components/ui/remove-dialog/RemoveDialog.vue';
import { toast } from '@/components/ui/toast';
import { exportToCsv } from '@/utils/export';

const content = ref([]);
const contentFiltered = ref([]);

const isLoading = ref(true);
const filterInput = ref('');

const userToRemove = ref(null);

const columns = [
  "ID",
  "Nome",
  "E-mail",
  "Telefone",
  "CEP",
  "Ações"
];

const columnsDb = [
  "id",
  "name",
  "email",
  "phone",
  "cep",
  "actions"
];

onMounted(() => {
  document.title = `${import.meta.env.VITE_APP_NAME} - Lista de usuários`;

  getData();
});

const getData = async () => {
  isLoading.value = true;
  try {
    const data = await getAllUser();
    content.value = data;
    contentFiltered.value = data;
  }
  catch (error) {
    console.error(error);
  }
  finally {
    isLoading.value = false;
  }
};

const filterData = (search) => {
  contentFiltered.value = content.value.filter((user) => {
    return user.name.toLowerCase().includes(search.toLowerCase()) ||
      user.email.toLowerCase().includes(search.toLowerCase()) ||
      user.city.toLowerCase().includes(search.toLowerCase()) ||
      user.state.toLowerCase().includes(search.toLowerCase()) ||
      user.birth_date.toLowerCase().includes(search.toLowerCase()) ||
      user.cep.toLowerCase().includes(search.toLowerCase()) ||
      user.phone.toLowerCase().includes(search.toLowerCase());
  });
};

const cancelRemove = () => {
  userToRemove.value = null;
};

const continueRemove = async () => {
  try {
    await deleteUser(userToRemove.value);
  }
  catch (error) {
    toast({
      title: 'Erro ao remover usuário',
      description: 'Ocorreu um erro ao remover o usuário, tente novamente',
      variant: 'destructive'
    });
    return;
  }
  finally {
    userToRemove.value = null;
  }

  toast({
    title: 'Usuário removido',
    description: 'O usuário foi removido com sucesso',
    variant: 'success'
  });
  await getData();
};


</script>

<template>
  <h1 class="text-white text-3xl font-bold tracking-tight flex items-center gap-2">
    <PersonIcon class="w-8 h-8" /> Lista de usuários
  </h1>

  <div class="flex justify-between space-x-2 lg:flex-row space-y-2">
    <Input class="max-w-64 w-full" placeholder="Filtro" v-model="filterInput" @input="filterData(filterInput, content, contentFiltered)" />
    <Button :disabled="contentFiltered.length === 0" @click="() => exportToCsv(contentFiltered)">
      <FileTextIcon class="w-4 h-4 me-1" />
      Exportar usuários
    </Button>
  </div>

  <div class="space-y-8 flex flex-col">
    <SkeletonUserList v-if="isLoading" v-for="index in 4" :key="index" />
  </div>

  <div v-if="!isLoading" class="space-y-8 flex flex-col text-white">
    <div class="rounded-md border">
      <Table>
        <TableHeader>
          <TableRow>
            <TableHead v-for="header in columns" :key="header.id">
              {{ header }}
            </TableHead>
          </TableRow>
        </TableHeader>

        <TableBody>
          <TableRow v-if="contentFiltered.length > 0" v-for="user in contentFiltered" :data-state="'selected'">
            <TableCell v-for="header, index in columnsDb" :key="`${header}-${index}`">
              <template v-if="header !== 'actions'">{{ user[header.toLowerCase()] }}</template>
              <div v-else class="space-x-2">
                <router-link :to="`/user/${user.id}`">
                  <Button title="editar usuário" variant="none" class="bg-blue-700 text-white">
                    <Pencil2Icon class="w-4 h-5" />
                  </Button>
                </router-link>
                <Button @click="() => { userToRemove = user.id }" title="deletar usuário" variant="none"
                  class="bg-red-700 text-white">
                  <TrashIcon class="w-5 h-5" />
                </Button>
              </div>
            </TableCell>
          </TableRow>

          <TableRow v-else>
            <TableCell :colspan="columnsDb.length" class="h-24 text-center">
              Nenhum usuário encontrado.
            </TableCell>
          </TableRow>
        </TableBody>
      </Table>
    </div>
  </div>

  <RemoveDialog v-if="userToRemove !== null" @cancel="cancelRemove" @continue="continueRemove" />
</template>