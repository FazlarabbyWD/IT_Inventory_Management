<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table ='contacts';
    public $timestamps = false;

    public function officeInfo(){
    	return $this->hasOne('App\Models\Offices', 'id', 'office_id');
    }

    public function contactTypeInfo(){
        return $this->hasOne('App\Models\ContactTypes', 'id', 'contact_type_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
