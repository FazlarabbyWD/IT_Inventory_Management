<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributions extends Model
{
    protected $table ='distributions';
    public $timestamps = false;

    public function productInfo(){
        return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }

    public function productItemInfo(){
        return $this->hasOne('App\Models\ProductItems', 'id', 'product_item_id');
    }

    public function contactInfo(){
        return $this->hasOne('App\Models\Contacts', 'id', 'contact_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
