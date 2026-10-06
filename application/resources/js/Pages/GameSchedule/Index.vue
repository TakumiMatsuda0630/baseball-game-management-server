<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import { computed, ref } from 'vue';

type Schedule = {
    id: number;
    game_date: string;
    scheduled_start_time: string;
    stadium_id: number;
    stadium_name: string;
    first_base_team_name: string;
    third_base_team_name: string;
};
type Filters = {
    game_dates: string[];
    scheduled_start_times: string[];
    team_ids: string[];
    stadium_ids: number[];
};

const props = defineProps<{
    schedules: { data: Schedule[]; current_page: number; last_page: number; total: number };
    filters: Filters;
    teams: { id: string; team_name: string }[];
    stadiums: { id: number; stadium_name: string }[];
}>();

const gameDates = ref([...props.filters.game_dates]);
const startTimes = ref([...props.filters.scheduled_start_times]);
const teamIds = ref([...props.filters.team_ids]);
const stadiumIds = ref([...props.filters.stadium_ids]);
const dateInput = ref('');
const timeInput = ref('');

const addDate = (): void => {
    if (dateInput.value && !gameDates.value.includes(dateInput.value)) gameDates.value.push(dateInput.value);
    dateInput.value = '';
};
const addTime = (): void => {
    if (timeInput.value && !startTimes.value.includes(timeInput.value)) startTimes.value.push(timeInput.value);
    timeInput.value = '';
};
const params = (page = 1): Record<string, string[] | number[] | number> => ({
    game_dates: gameDates.value,
    scheduled_start_times: startTimes.value,
    team_ids: teamIds.value,
    stadium_ids: stadiumIds.value,
    page,
});
const search = (): void => router.get('/admin/game-schedule', params(), { preserveState: true });
const clear = (): void => {
    gameDates.value = [];
    startTimes.value = [];
    teamIds.value = [];
    stadiumIds.value = [];
    router.get('/admin/game-schedule');
};
const goToPage = (page: number): void => router.get('/admin/game-schedule', params(page), { preserveState: true });

const groups = computed(() => {
    const grouped = new Map<string, { gameDate: string; stadiumName: string; items: Schedule[] }>();
    for (const schedule of props.schedules.data) {
        const key = `${schedule.game_date}|${schedule.stadium_id}`;
        if (!grouped.has(key)) {
            grouped.set(key, { gameDate: schedule.game_date, stadiumName: schedule.stadium_name, items: [] });
        }
        grouped.get(key)!.items.push(schedule);
    }
    return [...grouped.values()];
});
</script>

<template>
    <div class="d-flex justify-space-between align-center mb-5">
        <h1 class="text-h4">試合予定一覧</h1>
        <v-btn color="primary" href="/admin/game-schedule/regist">登録</v-btn>
    </div>

    <v-card class="pa-4 mb-6" variant="outlined">
        <h2 class="text-h6 mb-4">検索</h2>
        <div class="d-flex ga-2 align-center">
            <v-text-field v-model="dateInput" type="date" label="試合日" hide-details />
            <v-btn @click="addDate" :disabled="!dateInput">追加</v-btn>
        </div>
        <v-chip v-for="date in gameDates" :key="date" closable class="ma-1"
            @click:close="gameDates = gameDates.filter(item => item !== date)">{{ date }}</v-chip>
        <div class="d-flex ga-2 align-center mt-4">
            <v-text-field v-model="timeInput" type="time" label="試合開始予定時間" hide-details />
            <v-btn @click="addTime" :disabled="!timeInput">追加</v-btn>
        </div>
        <v-chip v-for="time in startTimes" :key="time" closable class="ma-1"
            @click:close="startTimes = startTimes.filter(item => item !== time)">{{ time }}</v-chip>
        <v-select v-model="teamIds" :items="teams" item-title="team_name" item-value="id"
            label="チーム（1塁側・3塁側）" multiple chips closable-chips class="mt-4" />
        <v-select v-model="stadiumIds" :items="stadiums" item-title="stadium_name" item-value="id"
            label="球場" multiple chips closable-chips />
        <div class="d-flex justify-end ga-2">
            <v-btn @click="clear">クリア</v-btn>
            <v-btn color="primary" @click="search">検索</v-btn>
        </div>
    </v-card>

    <p class="mb-4">{{ schedules.total }} 件</p>
    <v-alert v-if="!schedules.data.length" type="info">該当する試合予定はありません。</v-alert>
    <v-card v-for="group in groups" :key="`${group.gameDate}-${group.stadiumName}`" class="mb-4" variant="outlined">
        <v-card-title>{{ group.gameDate }}　{{ group.stadiumName }}</v-card-title>
        <v-list>
            <v-list-item v-for="schedule in group.items" :key="schedule.id"
                :title="`${schedule.scheduled_start_time.slice(0, 5)}　${schedule.first_base_team_name}（1塁側） vs ${schedule.third_base_team_name}（3塁側）`"
                @click="router.visit(`/admin/game-schedule/edit/${schedule.id}`)" link>
                <template #append><v-icon icon="mdi-pencil" /></template>
            </v-list-item>
        </v-list>
    </v-card>
    <v-pagination v-if="schedules.last_page > 1" :model-value="schedules.current_page"
        :length="schedules.last_page" @update:model-value="goToPage" />
</template>
