<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $guarded = [];
    /**
     * Indicates if the model's timestamps should be managed automatically.
     *
     * @var bool
     */
    public $timestamps = true;

    // Cart model
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function product() 
    {
        return $this->belongsTo(Product::class);
    }
}
