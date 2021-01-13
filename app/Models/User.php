<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Role;
use Laratrust\Traits\LaratrustUserTrait;

class User extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image', 'name', 'email', 'position', 'password',
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
        // 'social' => 'array',
    ];  

    // public function roles()
    // {
    //     return $this->belongsToMany(Role::class);
    // }

    // public function permissions()
	// {
	// 	return $this->belongsToMany(Permission::class);
	// }
    
    public function adminlte_image()
    {
        $images = $this->image;
        
        if($images === null || $images === 'null' || $images === ''){
            return 'img/default-photo.png';
        } else {
            return 'img/admin/'. $images;
        }
    }
    
    public function adminlte_desc()
    {
        return $this->position;
    }
}
