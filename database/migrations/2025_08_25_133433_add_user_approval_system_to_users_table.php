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
            $table->boolean('is_approved')->default(false)->after('password');
            $table->boolean('is_super_user')->default(false)->after('is_approved');
            $table->timestamp('approved_at')->nullable()->after('is_super_user');
            $table->unsignedBigInteger('approved_by')->nullable()->after('approved_at');
            $table->text('registration_note')->nullable()->after('approved_by');
            
            $table->foreign('approved_by')->references('id')->on('users')->onDelete('set null');
            $table->index(['is_approved', 'is_super_user']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['approved_by']);
            $table->dropIndex(['is_approved', 'is_super_user']);
            $table->dropColumn([
                'is_approved', 
                'is_super_user', 
                'approved_at', 
                'approved_by',
                'registration_note'
            ]);
        });
    }
};