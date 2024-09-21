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
            $table->foreignId('organizational_unit_id')->nullable()->constrained('organizational_units')->onDelete('set null');
            $table->foreignId('position_id')->nullable()->constrained('positions')->onDelete('set null');
            $table->string('central_phone')->nullable();
            $table->string('extension')->nullable();
            $table->string('photo')->nullable();
            $table->string('role')->default('user');
            $table->boolean('status')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'organizational_unit_id')) {
                $table->dropForeign(['organizational_unit_id']);
                $table->dropColumn('organizational_unit_id');
            }

            if (Schema::hasColumn('users', 'position_id')) {
                $table->dropForeign(['position_id']);
                $table->dropColumn('position_id');
            }

            if (Schema::hasColumn('users', 'central_phone')) {
                $table->dropColumn('central_phone');
            }

            if (Schema::hasColumn('users', 'extension')) {
                $table->dropColumn('extension');
            }

            if (Schema::hasColumn('users', 'photo')) {
                $table->dropColumn('photo');
            }

            if (Schema::hasColumn('users', 'role')) {
                $table->dropColumn('role');
            }

            if (Schema::hasColumn('users', 'status')) {
                $table->dropColumn('status');
            }
        });
    }
};
