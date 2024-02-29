<?php

namespace App\Models\Transaksi;

use App\Models\Referensi\RefPasar;
use App\Models\Referensi\RefBarang;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Illuminate\Support\Facades\Auth;

class Barang extends Model
{
    protected $connection = 'pgsql';
    protected $table = 't_siba_stok';
    protected $primaryKey = 'id';
    
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
    
    protected static $logName = 'Barang';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }

    public function toPasar(){
        return $this->hasOne(RefPasar::class, 'id', 'pasar_id');
    } 
    public function toBarang(){
        return $this->hasOne(RefBarang::class, 'id', 'barang_id');
    }
    
}
