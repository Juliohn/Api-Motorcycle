<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class Motorcycle_Stock extends Model
{
    use SoftDeletes;

    protected $table = 'motorcycle_stock';
    protected $fillable = array('motorcycle_id','quantity','operation');
    protected $appends = array('operation_show','date');


    public function getOperationShowAttribute()
    {
        return $this->attributes['operation'] == 1 ? 'In':'Out';
    }

    public function getDateAttribute()
    {
        return  date('d/m/Y', strtotime($this->attributes['created_at']));
    }


    public static function boot()
    {
        parent::boot();

        static::updating(function ($table) {
            $table->updated_at = new DateTime();
        });

        static::creating(function ($table) {
            $table->created_at = new DateTime();
        });
    }
}
