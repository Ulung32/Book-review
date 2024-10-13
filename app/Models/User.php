<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The abilities that admin has.
     *
     * @var array
     */
    protected $adminAbilities = [
        'books.create', 
        'books.update', 
        'books.delete', 
        'books.view', 
        'reviews.create', 
        'reviews.update', 
        'reviews.delete', 
        'reviews.view'
    ];

    /**
     * The abilities that basic user has.
     *
     * @var array
     */
    protected $userAbilities = [
        'books.view', 
        'reviews.create', 
        'reviews.update', 
        'reviews.delete', 
        'reviews.view'
    ];

    public function reviews() {
        return $this->hasMany(Review::class, 'user_id');
    }

    /**
     * Creating token for user base on abilities.
     *
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function createTokenBaseOnAbilities()
    {
        if ($this->isAdmin()){
            return $this->createToken('admin-token', $this->adminAbilities);
        }else {
            return $this->createToken('user-token', $this->userAbilities);
        }
    }

    /**
     * return true if this user has admin role
     *
     * @return bool
     */
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
}
