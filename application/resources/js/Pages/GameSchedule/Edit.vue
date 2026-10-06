<script setup lang="ts">
import { router } from '@inertiajs/vue3';
import ScheduleForm from './ScheduleForm.vue';

defineProps<{
    schedule: {
        id: number;
        first_base_team_id: string;
        third_base_team_id: string;
        stadium_id: number;
        game_date: string;
        scheduled_start_time: string;
    };
    teams: { id: string; team_name: string }[];
    stadiums: { id: number; stadium_name: string }[];
}>();

const remove = (id: number): void => {
    if (window.confirm('この試合予定を削除しますか？')) {
        router.delete(`/admin/game-schedule/delete/${id}`);
    }
};
</script>

<template>
    <h1 class="text-h4 mb-6">試合予定編集</h1>
    <ScheduleForm :schedule="schedule" :teams="teams" :stadiums="stadiums" />
    <div class="d-flex justify-end mt-6">
        <v-btn color="error" variant="outlined" @click="remove(schedule.id)">削除</v-btn>
    </div>
</template>
