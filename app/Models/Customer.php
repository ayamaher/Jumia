<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\DB;

class Customer extends Model
{
    protected $table = "customer";
    protected $fillable = ['id', 'name', 'phone'];

//    public function country(): BelongsTo
//    {
//        return $this->belongsTo(Country::class);
//
//    }

    public function country()
    {


//        $customersWithCountries = DB::table('customer')->union('SELECT * FROM country')->whereRaw("country.regex REGEXP customer.phone'")->get();
//
//        eval(\Psy\sh());
//        return $customersWithCountries;
    }
}
