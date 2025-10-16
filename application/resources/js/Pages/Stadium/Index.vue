<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';

const { stadiums } = usePage().props;

const headers = [
    { title: 'ID', value: 'id' },
    { title: '球場名', value: 'stadium_name' },
    { title: '', value: 'actions' },
]

const goToRegist = (): void => {
    router.visit('/admin/stadium/regist');
}

const edit = (id: number): void => {
    router.visit('/admin/stadium/edit/' + id);
}

</script>


<template>
    <v-typography variant="h4" class="mb-4">球場一覧</v-typography>

    <div class="d-flex justify-end mb-2">
        <v-btn color="primary" @click="goToRegist">
            登録
        </v-btn>
    </div>
    

    <v-data-table
        :items="stadiums"
        :headers="headers"
    >
        <template v-slot:item.actions="{ item }">
            <div class="d-flex ga-2 justify-end">
                <v-icon
                    color="medium-emphasis"
                    icon="mdi-pencil"
                    size="small"
                    @click="edit(item.id)"
                ></v-icon>
            </div>
        </template>
    </v-data-table>
</template>