<?php

namespace App\Models\Bphtb;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Support\Facades\Auth;

class PelepasHak extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 't_bphtb_pelepas_hak';
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
    
    protected static $logName = 'Pelepas Hak';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }

    public function toDesa()
    {
        return $this->hasOne(RefDesa::class, 'id', 'id_kelurahan');
    }

    public function toKecamatan()
    {
        return $this->hasOne(RefKecamatan::class, 'id','id_kecamatan');
    }

    public function toKabupaten()
    {
        return $this->hasOne(RefKabupaten::class, 'id','id_kota_kab');
    }

    public function toProvinsi()
    {
        return $this->hasOne(RefProvinsi::class, 'id','id_provinsi');
    }
}
