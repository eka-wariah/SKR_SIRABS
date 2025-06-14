<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable,  HasRoles;
    protected $table = 'users';
    protected $primaryKey = 'usr_id';
    protected $guarded = [];


    public function treasurer()
    {
        return $this->hasOne(treasurer::class, 'trs_name_id');
    }
    public function areaScope()
    {
        return $this->belongsTo(area_scope::class, 'usr_scope_id', 'asc_id');
    }

    // public function treasurer()
    // {
    //     return $this->hasOne(treasurer::class, 'trs_name_id');
    // }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'usr_scope_id',
        'password',
        'gender',
        'phone',
        'address',
        'profile_photo',
        'usr_scope_id',
        'village',
        'subdistrict',
        'regency',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
