<script setup lang="ts">
import ScheduleForm from './ScheduleForm.vue';

defineProps<{
    teams: { id: string; team_name: string }[];
    stadiums: { id: number; stadium_name: string }[];
}>();
</script>

<template>
    <h1 class="text-h4 mb-6">試合予定登録</h1>
    <ScheduleForm :teams="teams" :stadiums="stadiums" />
</template>
