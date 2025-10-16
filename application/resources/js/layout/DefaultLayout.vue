<script setup lang="ts">

</script>


<template>
    <v-app class="d-flex flex-column"とstyle="min-height: 100vh;">
        <!-- ヘッダ -->
        <v-app-bar color="primary">
            <template v-slot:prepend>
                <!-- FIXME アイコンが表示されないので要修正-->
                <v-app-bar-nav-icon></v-app-bar-nav-icon>
            </template>
            <v-app-bar-title>試合予定管理アプリ</v-app-bar-title>
        </v-app-bar>
        
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