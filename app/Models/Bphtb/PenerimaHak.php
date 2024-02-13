<?php

namespace App\Models\Bphtb;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class PenerimaHak extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_bphtb_penerima_hak';
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
    
    protected static $logName = 'Penerima Hak';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }



    public function pembayaranPajak()
    {
        return $this->hasOne(pembayaranPajak::class,'id_bphtb','id_bphtb');
    }

    public function objekPajak()
    {
        return $this->hasOne(objekPajak::class,'id_bphtb','id_bphtb');
    }
}
