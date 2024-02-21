<?php

namespace App\Models\Website;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Ramsey\Uuid\Uuid as Generator;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

use Auth;

class RefArticles extends Model implements HasMedia
{
    use InteractsWithMedia;
    use HasFactory;
    
    protected $connection = 'pgsql';
    protected $table = 'web_siba_articles';
    protected $primaryKey = 'id';
    
    public $incrementing = true;
    protected $keyType = 'string';
    protected $guarded = [];
    /**
     * Register the media collections
     */
    // public function registerMediaCollections(): void
    // {
    //     $this->addMediaCollection('multi_gambar')
    //         // ->singleFile()
    //         ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);

    //     $this->addMediaCollection('gambar')
    //         ->singleFile()
    //         ->acceptsMimeTypes(['image/jpg', 'image/jpeg', 'image/png', 'image/gif']);
    // }
    
    
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
    
    protected static $logName = 'Articles';
    protected static $logOnlyDirty = true;
    protected static $logFillable = true;
    public function getDescriptionForEvent(string $eventName): string
    {
        return $this->nama . " {$eventName} Oleh: " . Auth::user()->nama;
    }

    public function toKategori(){
        return $this->hasOne(RefKategori::class, 'id','kategori');
    }
}
