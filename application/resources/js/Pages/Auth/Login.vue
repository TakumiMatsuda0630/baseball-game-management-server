<script lang="ts">
// レイアウト指定
// TODO 非ログイン時に利用する画面が増える場合は、app.jsで制御できるようにしたい
import GuestLayout from '../../layout/GuestLayout.vue';
export default {
    layout: GuestLayout,
};
</script>

<script setup lang="ts">

import { router } from '@inertiajs/vue3';
import { ref, Ref } from 'vue';

const valid: Ref<boolean> = ref(false);
const email: Ref<string> = ref('');
const emailRules = [
    value => {
        if (value) return true
        return 'メールアドレスを入力してください。'
    },
];

const password: Ref<string> = ref('');
const passwordRule = [
    value => {
        if (value) return true
        return 'パスワードを入力してください。'
    },
];

const showPassword = ref(false);

const submit = (): void => {
    router.post('/admin/login/auth/', {
        email: email.value,
        password: password.value
    })
}

</script>

<template>
    <div class="text-display-small">
        ログイン
    </div>

    <v-form v-model="valid" @submit.prevent="submit">
        <v-container>
            <v-text-field
                v-model="email"
                :rules="emailRules"
                label="メールアドレス"
                required
            ></v-text-field>

            <v-text-field
                v-model="password"
                :rules="passwordRule"
                label="パスワード"
                :type="showPassword ? 'text' : 'password'"
                :append-inner-icon="showPassword ? 'mdi-eye' : 'mdi-eye-off'"
                @click:append-inner="showPassword = !showPassword"
            />

            <div class="mt-10 d-flex justify-space-between">
                <v-btn class="w-25" type="submit" color="primary" :disabled="!valid">
                    ログイン
                </v-btn>
            </div>
        </v-container>
    </v-form>
</template>
