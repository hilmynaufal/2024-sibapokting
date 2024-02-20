<?php

namespace App\Models\Referensi;
use App\Models\Wilayah\RefDesa;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefKabupaten;
use App\Models\Wilayah\RefProvinsi;
use App\Models\Referensi\RefDistributor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;

use Auth;

class RefPupuk extends Model
{
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 'ref_siba_pupuk';
    protected $primaryKey = 'id';
    
    public $incrementing = true;
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
    
    protected static $logName = 'Pupuk';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }


    public function toDesa()
    {
        return $this->hasOne(RefDesa::class, 'id', 'desa');
    }

    public function toKecamatan()
    {
        return $this->hasOne(RefKecamatan::class, 'id','kecamatan');
    }

    public function toKabupaten()
    {
        return $this->hasOne(RefKabupaten::class, 'id','kabupaten');
    }

    public function toProvinsi()
    {
        return $this->hasOne(RefProvinsi::class, 'id','provinsi');
    }

    public function toDistributor()
    {
        return $this->hasOne(RefDistributor::class, 'id','id_distributor');
    }
}
