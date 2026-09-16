<script setup lang="ts">
import { router, useForm, usePage } from '@inertiajs/vue3';
import { ComputedRef, Ref, computed, ref } from 'vue';

type Team = {
    id: string;
    team_name: string;
}

const team = computed(() => usePage().props.team) as ComputedRef<Team>;
const valid: Ref<boolean> = ref(false);
const form = useForm({ team_name: team.value.team_name });
const teamNameRules = [
    (value: string) => Boolean(value) || 'チーム名は必須です。',
    (value: string) => value?.length <= 100 || 'チーム名は100文字以内で入力してください。',
];

const submit = (): void => form.put('/admin/team/update/' + team.value.id);
const remove = (): void => router.delete('/admin/team/delete/' + team.value.id);
const goBack = (): void => router.visit('/admin/team');
</script>

<template>
    <v-typography variant="h4" class="mb-4">チーム詳細</v-typography>
    <v-form v-model="valid" @submit.prevent="submit">
        <v-container>
            <v-text-field
                v-model="form.team_name"
                :counter="100"
                :rules="teamNameRules"
                :error-messages="form.errors.team_name"
                label="チーム名"
                required
            ></v-text-field>
            <div class="mt-10 d-flex justify-space-between">
                <v-btn class="w-25" type="button" @click="goBack">戻る</v-btn>
                <v-btn class="w-25" type="button" color="secondary" @click="remove">削除</v-btn>
                <v-btn class="w-25" type="submit" color="primary" :disabled="!valid || form.processing">
                    更新
                </v-btn>
            </div>
        </v-container>
    </v-form>
</template>
