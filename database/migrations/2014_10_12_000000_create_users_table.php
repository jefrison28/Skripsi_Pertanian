<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['admin', 'pemilik_lahan', 'petani'])->default('petani');  
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    User::create([
        'name' => 'admin',
        'email' => 'admin@mail.com',
        'role' => 'admin',
        'password' => Hash::make('12345678')
    ]);
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }

};
