<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class SuperUserSeeder extends Seeder
{
    /**
     * Run the database seeder.
     */
    public function run(): void
    {
        // Create super user if it doesn't exist
        $superUser = User::where('email', 'admin@admin.com')->first();
        
        if (!$superUser) {
            User::create([
                'name' => 'Super Admin',
                'email' => 'admin@admin.com',
                'password' => Hash::make('admin123'),
                'is_approved' => true,
                'is_super_user' => true,
                'approved_at' => now(),
                'email_verified_at' => now(),
            ]);
            
            $this->command->info('Super user created successfully!');
            $this->command->info('Email: admin@admin.com');
            $this->command->info('Password: admin123');
        } else {
            // Update existing user to be super user if not already
            if (!$superUser->isSuperUser()) {
                $superUser->update([
                    'is_super_user' => true,
                    'is_approved' => true,
                    'approved_at' => now(),
                ]);
                $this->command->info('Existing user updated to super user!');
            } else {
                $this->command->info('Super user already exists.');
            }
        }
    }
}