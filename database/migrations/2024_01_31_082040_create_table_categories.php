<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {

    /**
     * @return void
     */
    public function up(): void
    {
        Schema::create(table: 'categories', callback: function (Blueprint $table): void {
            $table->id();
            $table->uuid(column: 'uid')
                ->unique();
            $table->timestamps();
            $table->softDeletes();

            $table->string(column: 'name', length: 45);

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
        Schema::dropIfExists(table: 'categories');
    }
};
