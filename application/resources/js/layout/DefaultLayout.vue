<script setup lang="ts">
import { ref } from 'vue';
import { router } from '@inertiajs/vue3';

// ナビゲーション表示制御
const isDraw = ref(false);
const changeIsDraw = (): void => {
    isDraw.value = !isDraw.value;
};

// 画面遷移処理
const movePage = (path: string): void => {
    router.visit(path);
};

</script>


<template>
    <v-app class="d-flex flex-column" style="min-height: 100vh;">
        <!-- ヘッダ -->
        <v-app-bar color="primary">
            <template v-slot:prepend>
                <!-- FIXME アイコンが表示されないので要修正-->
                <v-app-bar-nav-icon @click="changeIsDraw"></v-app-bar-nav-icon>
            </template>
            <v-app-bar-title>試合予定管理アプリ</v-app-bar-title>
        </v-app-bar>

        <!-- ナビゲーション -->
        <!-- アイコン検索ページ https://pictogrammers.com/library/mdi/ -->
        <v-navigation-drawer v-model="isDraw" color="primary">
            <v-list color="transparent">
                <div @click="movePage('/admin/home')">
                    <v-list-item link prepend-icon="mdi-home" title="ホーム"></v-list-item>
                </div>
                <div @click="movePage('/admin/stadium')">
                    <v-list-item link prepend-icon="mdi-baseball-diamond" title="球場一覧"></v-list-item>
                </div>
            </v-list>

            <template v-slot:append>
                <div class="pa-2" @click="movePage('/admin/logout')">
                    <v-btn block>
                        ログアウト
                    </v-btn>
                </div>
            </template>
        </v-navigation-drawer>

        <!-- メインコンテンツ -->
        <v-main>
            <v-container class="py-4">
                <slot />
            </v-container>
        </v-main>

        <!-- フッタ -->
        <v-footer class="mt-auto">
            <div class="flex-1-0-100 text-center mt-2">
                {{ new Date().getFullYear() }} — <strong>Game plan management app.</strong>
            </div>
        </v-footer>
    </v-app>
</template>
