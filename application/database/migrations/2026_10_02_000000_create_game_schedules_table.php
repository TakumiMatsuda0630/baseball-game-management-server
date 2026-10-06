<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('game_schedules', function (Blueprint $table): void {
            $table->id();
            $table->foreignUuid('first_base_team_id')->constrained('teams')->restrictOnDelete();
            $table->foreignUuid('third_base_team_id')->constrained('teams')->restrictOnDelete();
            $table->foreignId('stadium_id')->constrained('stadiums')->restrictOnDelete();
            $table->date('game_date');
            $table->time('scheduled_start_time');
            $table->timestamps();
            $table->index(['game_date', 'stadium_id', 'scheduled_start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('game_schedules');
    }
};
