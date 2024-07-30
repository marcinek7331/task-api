<?php

use App\Constants\TaskStatus;
use App\Models\Task;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(Task::TABLE, function (Blueprint $table) {
            $table->id();
            $table->integer(Task::SIZE);
            $table->json(Task::RESULT)->nullable();
            $table->string(Task::STATUS)->default(TaskStatus::PENDING);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(Task::TABLE);
    }
};
