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
        Schema::table(table: 'users', callback: function (Blueprint $table): void {
            $table
                ->uuid(column: 'uid')
                ->after(column: 'id')
                ->unique();

            $table
                ->softDeletes()
                ->after(column: 'updated_at');

            $table
                ->jsonb(column: 'roles')
                ->after(column: 'remember_token');
        });
    }

    /**
     * @return void
     */
    public function down(): void
    {
        Schema::table(table: 'users', callback: function (Blueprint $table): void {
            $table->dropColumn(columns: 'uid');
        });
    }
};
