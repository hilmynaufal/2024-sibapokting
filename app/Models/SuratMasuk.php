<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class SuratMasuk extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_surat_masuk';
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
    
    protected static $logName = 'Surat Masuk';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }
    
    public function tujuan()
    {
        return $this->belongsTo(RefJabatan::class,'tujuan_surat_token','token');
    }
    
    public function verifikasi()
    {
        return $this->hasMany(Disposisi::class,'surat_id','id');
    }
}
