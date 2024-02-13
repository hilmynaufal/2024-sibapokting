<?php

namespace App\Models\Pajak;
use App\Models\Wilayah\RefKecamatan;
use App\Models\Wilayah\RefDesa;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;

use Auth;

class RefNilaiPasar extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'ref_bphtb_nilai_pasar';
    protected $primaryKey = 'id';
    
    public $incrementing = false;
    protected $keyType = 'string';
    protected $guarded = [];
    
    protected static function boot()
    {
        parent::boot();
        
        // static::creating(function ($model) {
        //     try {
        //         $model->id =  Generator::uuid4()->toString();
        //     } catch (UnsatisfiedDependencyException $e) {
        //         abort(500, $e->getMessage());
        //     }
        // });
    }
    
    protected static $logName = 'Tarif NPOPTKP';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }
    public function desa()
    {
        return $this->belongsTo(RefDesa::class,'kode_desa');
    }
    public function kecamatan()
    {
        return $this->belongsTo(RefKecamatan::class,'kode_kecamatan');
    }
}
