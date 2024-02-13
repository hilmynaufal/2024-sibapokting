<?php

namespace App\Models\Pajak;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;

use Auth;

class RefTarifNpoptkp extends Model
{
    use HasFactory;
    protected $connection = 'pgsql';
    protected $table = 'ref_bphtb_tarif_npoptkp';
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
    public function jenisPerolehan()
    {
        return $this->belongsTo(RefJenisTransaksi::class,'jenis_transaksi_id');
    }
}
