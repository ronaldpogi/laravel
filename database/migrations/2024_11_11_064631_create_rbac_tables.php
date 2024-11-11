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
        // ROLES
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });

        // PERMISSION GROUPS
        Schema::create('permission_groups', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->timestamps();
            $table->softDeletes();
        });

        // PERMISSIONS
        Schema::create('permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_group_id')->cascadeOnUpdate();
            $table->string('name', 100);
            $table->text('description')->nullable();
            $table->string('slug');
            $table->string('route');
            $table->timestamps();
            $table->softDeletes();
        });

        // ROLE_PERMISSIONS
        Schema::create('role_permissions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('permission_id')->cascadeOnUpdate();
            $table->foreignId('role_id')->onDelete('set null');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permission_groups');
        Schema::dropIfExists('permissions');
        Schema::dropIfExists('role_permissions');
    }
};
