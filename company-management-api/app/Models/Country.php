<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

     protected $fillable = ['name'];

     /**
      * Get all of the users for the Country
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function users(): HasMany
     {
         return $this->hasMany(User::class, 'user_id', 'id');
     }

     /**
      * Get all of the companies for the Country
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function companies(): HasMany
     {
         return $this->hasMany(Company::class, 'company_id', 'id');
     }

}
