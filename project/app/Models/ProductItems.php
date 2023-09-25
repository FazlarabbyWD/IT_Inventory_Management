<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductItems extends Model
{
    protected $table ='product_items';
    public $timestamps = false;

    public function productItemDetails(){
        return $this->hasMany('App\Models\ProductItemDetails', 'product_item_id', 'id')->orderBy('order_id', 'asc');
    }

    public function productInfo(){
        return $this->hasOne('App\Models\Products', 'id', 'product_id');
    }

    public function specTypeInfo(){
        return $this->hasOne('App\Models\SpecTypes', 'id', 'spec_type_id');
    }

    public function officeInfo(){
    	return $this->hasOne('App\Models\Offices', 'id', 'office_id');
    }

    public function vendorInfo(){
        return $this->hasOne('App\Models\Contacts', 'id', 'vendor_id');
    }

    public function distributionInfo(){
        return $this->hasOne('App\Models\Distributions', 'product_item_id', 'id')->whereNull('end_using')->where('status', 1)->orderBy('id', 'desc');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
