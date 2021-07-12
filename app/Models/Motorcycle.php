<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use DateTime;

class Motorcycle extends Model
{
    use SoftDeletes;
    protected $fillable = array('name','code','price','avatar');
    protected $appends = array('stock','price','avatar_url');

    public function stock_entries()
    {
        return $this->hasMany('App\Models\Motorcycle_Stock', 'motorcycle_id', 'id')->orderBy('created_at', 'DESC');
    }

    public function getPriceAttribute()
    {
        return currency_format($this->attributes['price']);
    }

    public function getStockAttribute()
    {
        $quantity = (
            $this->stock_entries()->where('operation', 1)->sum('quantity')
                -
            $this->stock_entries()->where('operation', 2)->sum('quantity')
        );
        return $quantity;
    }

    public function getAvatarUrlAttribute()
    {
        return url()->previous() . "/storage/" . $this->attributes['avatar'];
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
