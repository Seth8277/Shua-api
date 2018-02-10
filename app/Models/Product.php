<?php

namespace App\Models;


use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'introduction', 'price', 'category_id', 'required_params'];

    public function category()
    {
        return $this->belongsTo(Product::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function setPriceAttribute($price)
    {
        if (strpos((string)$price, '.') !== false)
            $price *= 100;

        $this->attributes['price'] = $price;
    }

    public function setRequiredParamsAttribute($value)
    {
        if ($value instanceof Jsonable) $value = $value->toJson();

        if (is_array($value)) $value = json_encode($value);

        $this->attributes['required_params'] = $value;
    }

    public function getRequiredParamsAttribute()
    {
        return json_decode($this->attributes['required_params']);
    }
}