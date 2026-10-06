<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';

type Team = { id: string; team_name: string };
type Stadium = { id: number; stadium_name: string };
type Schedule = {
    first_base_team_id: string;
    third_base_team_id: string;
    stadium_id: number | null;
    game_date: string;
    scheduled_start_time: string;
};

const props = defineProps<{
    teams: Team[];
    stadiums: Stadium[];
    schedule?: Schedule & { id: number };
}>();

const form = useForm({
    first_base_team_id: props.schedule?.first_base_team_id ?? '',
    third_base_team_id: props.schedule?.third_base_team_id ?? '',
    stadium_id: props.schedule?.stadium_id ?? null,
    game_date: props.schedule?.game_date?.slice(0, 10) ?? '',
    scheduled_start_time: props.schedule?.scheduled_start_time?.slice(0, 5) ?? '',
});

const submit = (): void => {
    if (props.schedule) {
        form.put(`/admin/game-schedule/update/${props.schedule.id}`);
    } else {
        form.post('/admin/game-schedule/store');
    }
};
</script>

<template>
    <v-form @submit.prevent="submit">
        <v-select v-model="form.first_base_team_id" :items="teams" item-title="team_name" item-value="id"
            label="1塁側チーム" :error-messages="form.errors.first_base_team_id" required />
        <v-select v-model="form.third_base_team_id" :items="teams" item-title="team_name" item-value="id"
            label="3塁側チーム" :error-messages="form.errors.third_base_team_id" required />
        <v-alert v-if="form.first_base_team_id && form.first_base_team_id === form.third_base_team_id"
            type="warning" class="mb-4">異なるチームを選択してください。</v-alert>
        <v-select v-model="form.stadium_id" :items="stadiums" item-title="stadium_name" item-value="id"
            label="実施球場" :error-messages="form.errors.stadium_id" required />
        <v-text-field v-model="form.game_date" type="date" label="試合日"
            :error-messages="form.errors.game_date" required />
        <v-text-field v-model="form.scheduled_start_time" type="time" label="試合開始予定時間"
            :error-messages="form.errors.scheduled_start_time" required />
        <div class="d-flex justify-space-between mt-6">
            <v-btn href="/admin/game-schedule">戻る</v-btn>
            <v-btn color="primary" type="submit" :loading="form.processing"
                :disabled="!form.first_base_team_id || !form.third_base_team_id ||
                    form.first_base_team_id === form.third_base_team_id || !form.stadium_id ||
                    !form.game_date || !form.scheduled_start_time">
                {{ schedule ? '更新' : '登録' }}
            </v-btn>
        </div>
    </v-form>
</template>
