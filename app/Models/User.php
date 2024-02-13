<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    
    protected $connection = 'pgsql';
    protected $table = 'ref_users';
    protected $primaryKey = 'id';
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
    /**
    * The attributes that are mass assignable.
    *
    * @var array<int, string>
    */
    // protected $fillable = [
        //     'name',
        //     'email',
        //     'password',
        // ];
        
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
        
        protected static function boot()
        {
            parent::boot();
            
            static::creating(function ($model) {
                try {
                    $model->token =  Generator::uuid4()->toString();
                } catch (UnsatisfiedDependencyException $e) {
                    abort(500, $e->getMessage());
                }
            });
        }
        
        public function roles()
        {
            return $this->belongsTo(RefRole::class,'role_id');
        }
    }
    