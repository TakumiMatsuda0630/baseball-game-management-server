<script setup lang="ts">
import { usePage, router } from '@inertiajs/vue3';
import { computed, ref, Ref, ComputedRef } from 'vue';

type Stadium = {
    id: number;
    stadium_name: string;
}

const page = usePage();
const stadium = computed(() => page.props.stadium) as ComputedRef<Stadium>;

const valid: Ref<boolean> = ref(false);
const stadiumName: Ref<string> = ref(stadium.value.stadium_name);
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
    router.put('/admin/stadium/update/' + stadium.value.id, {
        stadium_name: stadiumName.value,
    })
}

const remove = (): void => {
    router.delete('/admin/stadium/delete/' + stadium.value.id);
}

const goBack = (): void => {
    router.visit('/admin/stadium');
}
</script>


<template>
    <v-typography variant="h4" class="mb-4">球場詳細</v-typography>

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

                <v-btn class="w-25" type="button" color="secondory" @click="remove">
                    削除
                </v-btn>
                <v-btn class="w-25" type="submit" color="primary" :disabled="!valid">
                    更新
                </v-btn>
            </div>
        </v-container>
    </v-form>
</template>