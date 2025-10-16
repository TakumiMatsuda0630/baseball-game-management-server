<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { Ref, ref } from 'vue';

const valid: Ref<boolean> = ref(false);

// 球場名(バリデーションルール)
const stadiumName: Ref<string> = ref('');
const stadiumNameRules = [
    value => {
        if (value) return true
        return '球場名は必須です。'
    },
    value => {
        if (value?.length <= 100) return true
        return '球場名は100文字以内で入力してください。'
    },
];

const submit = (): void => {
    router.post('/admin/stadium/store', {
        stadium_name: stadiumName.value,
    })
}

const goBack = (): void => {
    router.visit('/admin/stadium');
}
</script>


<template>
    <v-typography variant="h4" class="mb-4">球場登録</v-typography>

    <v-form v-model="valid" @submit.prevent="submit">
        <v-container>
            <v-text-field
                v-model="stadiumName"
                :counter="100"
                :rules="stadiumNameRules"
                label="球場名"
                required
            ></v-text-field>

            <div class="mt-10 d-flex justify-space-between">
                <v-btn class="w-25" type="button" @click="goBack">
                    戻る
                </v-btn>
                <v-btn class="w-25" type="submit" color="primary" :disabled="!valid">
                    登録
                </v-btn>
            </div>
        </v-container>
    </v-form>
</template>