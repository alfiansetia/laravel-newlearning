<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'email',
        'password',
        'gender',
        'role',
        'dob',
        'phone',
        'status',
        'email_verified_at',
        'point',
        'image'
    ];

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
        'password' => 'hashed',
    ];

    public function upgrade()
    {
        return $this->hasOne(UpgradeUser::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function keys()
    {
        return $this->hasMany(Key::class);
    }

    public function available_keys()
    {
        return $this->hasMany(Key::class)->where('status', 'available');
    }

    public function getImageAttribute($value)
    {
        if ($value && file_exists(public_path('/images/user/' . $value))) {
            return url('/images/user/' . $value);
        } else {
            return url('/images/default-user.jpg');
        }
    }

    public function courses()
    {
        return $this->hasManyThrough(
            TransactionDetail::class, // Model tujuan
            Transaction::class,       // Model perantara
            // 'user_id',                // Foreign key di tabel transactions
            // 'transaction_id',         // Foreign key di tabel transaction_details
            // 'id',                     // Kunci lokal di tabel users
            // 'user_id'                      // Kunci asing di tabel transactions
        );
    }
}
