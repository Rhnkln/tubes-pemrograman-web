<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Password default yang digunakan oleh factory
     */
    protected static ?string $password;

    /**
     * Define state default model User
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Nama pengguna random
            'name' => fake()->name(),

            // Email unik
            'email' => fake()->unique()->safeEmail(),

            // Waktu verifikasi email
            'email_verified_at' => now(),

            // Password default, di-hash
            'password' => static::$password ??= Hash::make('password'),

            // Token untuk "remember me"
            'remember_token' => Str::random(10),
        ];
    }

    /**
     * Tandai email sebagai belum diverifikasi
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
