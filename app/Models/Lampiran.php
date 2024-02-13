<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;
use Storage;

class Lampiran extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_lampiran';
    protected $primaryKey = 'token';
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
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
    
    // public static function booted() : void{
        //     self::deleted(function (Lampiran $customerDocument) {
            //         Storage::disk('public')->delete($customerDocument->file_lampiran_url);
            //     });
            // }
            
            protected static $logName = 'Lampiran';
            protected static $logOnlyDirty = true;
            protected static $logFillable = true;
            public function getDescriptionForEvent(string $eventName): string
            {
                return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
            }
        }
        