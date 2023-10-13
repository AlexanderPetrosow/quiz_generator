<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'surname',
        'company_name',
        'phone',
        'email',
        'password',
        'status',
        'is_admin',
    ];



    public function questions()
{
    return $this->hasMany(Question::class);
}
    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function rules($id = null)
{
    return [
        'name' => 'required|string|max:255',
        'surname' => 'required|string|max:255',
        'company_name' => 'nullable|string|max:255',
        'phone' => 'required_without:email|unique:users,phone,' . $id,
        'email' => 'required_without:phone|unique:users,email,' . $id,
        'password' => 'required|string|min:6',
    ];
}
}
