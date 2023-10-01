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
        Schema::create('project_roles', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('project_id');
            $table->unsignedBigInteger('role_id');
            $table->integer('nop')->default(0);
            $table->foreign('project_id')->references('id')->on('projects');
            $table->foreign('role_id')->references('id')->on('roles');
            $table->timestamps();
            $table->unique(['project_id', 'role_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('project_roles');
    }
};
