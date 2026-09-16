<script setup lang="ts">
import { router, usePage } from '@inertiajs/vue3';

type Team = {
    id: string;
    team_name: string;
}

const teams = usePage().props.teams as Team[];
const headers = [
    { title: 'ID', value: 'id' },
    { title: 'チーム名', value: 'team_name' },
    { title: '', value: 'actions' },
];

const goToRegister = (): void => router.visit('/admin/team/regist');
const edit = (id: string): void => router.visit('/admin/team/edit/' + id);
</script>

<template>
    <v-typography variant="h4" class="mb-4">チーム一覧</v-typography>
    <div class="d-flex justify-end mb-2">
        <v-btn color="primary" @click="goToRegister">登録</v-btn>
    </div>
    <v-data-table :items="teams" :headers="headers">
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
