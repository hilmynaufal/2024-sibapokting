<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class DisposisiMasuk extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_disposisi_detail';
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
    
    protected static $logName = 'Disposisi Masuk';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }
    
    public function jabatans()
    {
        return $this->belongsToMany(Jabatan::class, 't_verifikasi', 'surat_id', 'jabatan_id');
    }
    
    public function suratMasuk()
    {
        return $this->belongsTo(SuratMasuk::class, 'surat_id', 'id');
    }
    
    public function disposisiUtama()
    {
        return $this->belongsTo(Disposisi::class, 'disposisi_id', 'id');
    }    
    
    public function jabatanPenerima()
    {
        return $this->belongsToMany(Jabatan::class, 't_disposisi_detail', 'jabatan_penerima_id', 'id');
    }
    
}
