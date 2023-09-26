<?php

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
        Schema::table('users', function (Blueprint $table) {
            $table->string('user_type',3)->default("NUT")->change();
            $table->boolean('approved')->default(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->integer('user_type')
                ->nullable(false)
                ->default(null)
                ->change();
            $table->boolean('approved')
                ->nullable(false)
                ->default(null)
                ->change();
        });
    }
};
