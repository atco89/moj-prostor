<?php

use App\Models\Space;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(table: 'space_reviews', callback: function (Blueprint $table): void {
            $table->id();
            $table->uuid(column: 'uid')
                ->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(model: User::class)
                ->constrained(table: 'users')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->foreignIdFor(model: Space::class)
                ->constrained(table: 'spaces')
                ->cascadeOnUpdate()
                ->restrictOnDelete();

            $table->integer(column: 'rate');
            $table->longText(column: 'description')
                ->nullable();

            $table->unique(columns: ['user_id', 'space_id']);

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'space_reviews');
    }
};
