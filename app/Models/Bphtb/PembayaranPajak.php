<?php

namespace App\Models\Bphtb;
use App\Models\Pajak\RefJenisTransaksi;
use App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class PembayaranPajak extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_bphtb_pembayaran';
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
    
    protected static $logName = 'Pembayaran Pajak';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }
    
    public function jenisPerolehan()
    {
        return $this->hasOne(RefJenisTransaksi::class,'id','jenis_transaksi_id');
    }
    
    public function notaris()
    {
        return $this->belongsTo(User::class,'created_id');
    }

    public function penerimaHak()
    {
        return $this->hasOne(PenerimaHak::class,'id_bphtb','id_bphtb');
    }

    public function pelepasHak()
    {
        return $this->hasOne(PelepasHak::class,'id_bphtb','id_bphtb');
    }

    public function objekPajak()
    {
        return $this->hasOne(objekPajak::class,'id_bphtb','id_bphtb');
    }
}
