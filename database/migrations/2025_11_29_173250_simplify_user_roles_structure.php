<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Add role column to users table if it doesn't exist
        if (!Schema::hasColumn('users', 'role')) {
            Schema::table('users', function (Blueprint $table) {
                $table->enum('role', ['admin', 'karang_taruna'])->default('karang_taruna')->after('email');
            });
        }

        // Migrate existing role data from roles table to users table
        if (Schema::hasTable('roles')) {
            DB::statement("
                UPDATE users
                SET role = CASE
                    WHEN role_id IN (SELECT id FROM roles WHERE nama_role = 'Admin') THEN 'admin'
                    ELSE 'karang_taruna'
                END
                WHERE role_id IS NOT NULL
            ");
        }

        // Remove duplicate fields from karang_taruna table
        if (Schema::hasColumn('karang_taruna', 'nama_lengkap')) {
            Schema::table('karang_taruna', function (Blueprint $table) {
                $table->dropColumn('nama_lengkap');
            });
        }
        if (Schema::hasColumn('karang_taruna', 'no_telp')) {
            Schema::table('karang_taruna', function (Blueprint $table) {
                $table->dropColumn('no_telp');
            });
        }

        // Drop role_id column from users table if it exists (without foreign key check)
        if (Schema::hasColumn('users', 'role_id')) {
            // Use raw SQL to drop foreign key constraint first
            DB::statement('SET FOREIGN_KEY_CHECKS=0');
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('role_id');
            });
            DB::statement('SET FOREIGN_KEY_CHECKS=1');
        }

        // Drop roles table
        Schema::dropIfExists('roles');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Recreate roles table
        Schema::create('roles', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        // Add back role_id to users table
        Schema::table('users', function (Blueprint $table) {
            $table->foreignId('role_id')->nullable()->constrained('roles')->after('email');
        });

        // Add back duplicate fields to karang_taruna table
        Schema::table('karang_taruna', function (Blueprint $table) {
            $table->string('nama_lengkap', 255)->nullable()->after('nama_karang_taruna');
            $table->string('no_telp', 20)->nullable()->after('nama_lengkap');
        });

        // Migrate role data back to roles table
        DB::statement("
            INSERT INTO roles (name, created_at, updated_at)
            SELECT DISTINCT role, NOW(), NOW()
            FROM users
            WHERE role IS NOT NULL
        ");

        DB::statement("
            UPDATE users
            SET role_id = (SELECT id FROM roles WHERE name = users.role)
            WHERE role IS NOT NULL
        ");

        // Remove role column from users table
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('role');
        });
    }
};
