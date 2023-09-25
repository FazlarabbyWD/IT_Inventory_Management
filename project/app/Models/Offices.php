<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offices extends Model
{
    protected $table ='offices';
    public $timestamps = false;

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
