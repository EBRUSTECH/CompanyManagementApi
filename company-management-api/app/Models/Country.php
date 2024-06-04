<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Country extends Model
{
    use HasFactory;

     /**
      * Get all of the users for the Country
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function users(): HasMany
     {
         return $this->hasMany(User::class, 'country_id', 'id');
     }

     /**
      * Get all of the companies for the Country
      *
      * @return \Illuminate\Database\Eloquent\Relations\HasMany
      */
     public function companies(): HasMany
     {
         return $this->hasMany(Company::class, 'country_id', 'id');
     }

}
