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
            $table->boolean('must_change_password')->default(false)->after('registration_note');
            $table->timestamp('password_changed_at')->nullable()->after('must_change_password');
            $table->unsignedBigInteger('password_reset_by')->nullable()->after('password_changed_at');
            $table->text('password_reset_reason')->nullable()->after('password_reset_by');
            
            $table->foreign('password_reset_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['must_change_password']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['password_reset_by']);
            $table->dropIndex(['must_change_password']);
            $table->dropColumn([
                'must_change_password',
                'password_changed_at', 
                'password_reset_by',
                'password_reset_reason'
            ]);
        });
    }
};