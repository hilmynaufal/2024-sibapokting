<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class SuratKeluar extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_surat_keluar';
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
    
    protected static $logName = 'Surat Keluar';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }
    
    public function pengirim()
    {
        return $this->belongsTo(RefJabatan::class,'pembuat_surat_token','token');
    }
    
    public function tujuan()
    {
        return $this->belongsTo(RefJabatan::class,'tujuan_surat_token','token');
    }
    
    public function tujuanEksternal()
    {
        return $this->belongsTo(RefInstansi::class,'tujuan_surat_token','token');
    }    
    
    public function sifat()
    {
        return $this->belongsTo(RefSifatSurat::class,'sifat_surat_id','id');
    }
    
    public function jenis()
    {
        return $this->belongsTo(RefJenisSurat::class,'jenis_surat_id','id');
    }
    
    public function verifikasi()
    {
        return $this->hasMany(Disposisi::class,'surat_id','id');
    }
}
