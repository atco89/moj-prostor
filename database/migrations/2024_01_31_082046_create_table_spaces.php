<?php

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
        Schema::create(table: 'spaces', callback: function (Blueprint $table): void {
            $table->id();
            $table->uuid(column: 'uid')
                  ->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->foreignIdFor(model: User::class)
                  ->constrained(table: 'users')
                  ->cascadeOnUpdate()
                  ->restrictOnDelete();
            $table->string(column: 'name', length: 45);
            $table->longText(column: 'description');
            $table->decimal(column: 'longitude', total: 10, places: 6);
            $table->decimal(column: 'latitude', total: 10, places: 6);
            $table->integer(column: 'number_of_reviews');
            $table->integer(column: 'score');
            $table->decimal(column: 'average', total: 5);

            $table->engine = 'InnoDB';
            $table->charset = 'utf8mb4';
            $table->collation = 'utf8mb4_unicode_ci';
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'spaces');
    }
};
