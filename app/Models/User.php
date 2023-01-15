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
  ];

  public function roles()
  {
    return $this->belongsToMany(Role::class);
  }

  public function hasAnyRoles($roles)
  {
    return null !== $this->roles()->whereIn('name', $roles)->first();
  }

  public function hasAnyRole($role)
  {
    return null !== $this->roles()->where('name', $role)->first();
  }

  public function icon()
  {
    if ($this->avatar) return $this->avatar;
    if ($this->roles()->whereIn('name', 'superadmin')->first()) return 'https://upload.wikimedia.org/wikipedia/commons/5/55/User-admin-gear.svg';
    if ($this->roles()->whereIn('name', 'admin')->first()) return 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_1.svg';
    if ($this->roles()->whereIn('name', 'socialuser')->first()) return 'https://upload.wikimedia.org/wikipedia/commons/0/04/User_icon_2.svg';
    if ($this->roles()->whereIn('name', 'blockeduser')->first()) return 'https://upload.wikimedia.org/wikipedia/commons/0/0a/Gnome-stock_person.svg';
    return 'https://upload.wikimedia.org/wikipedia/commons/a/aa/Blank_user.svg';
  }
}
