<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Products extends Model
{
    protected $table ='products';
    public $timestamps = false;

    public function productItems(){
        return $this->hasMany('App\Models\ProductItems', 'product_id', 'id')
        ->when(isset($_GET['t_code']) && !empty($_GET['t_code']), function($query){
            $query->where('t_code', $_GET['t_code']);
        })
        ->when(isset($_GET['quality_status']) && !empty($_GET['quality_status']), function($query){
            $query->where('quality_status', $_GET['quality_status']);
        })
        ->where('status', '>=', 1)
        ->orderBy('order_id', 'asc');
    }

    public function categoryInfo(){
        return $this->hasOne('App\Models\Categories', 'id', 'category_id');
    }

    public function brandInfo(){
        return $this->hasOne('App\Models\Brands', 'id', 'brand_id');
    }

    public function officeInfo(){
    	return $this->hasOne('App\Models\Offices', 'id', 'office_id');
    }

    public function createdBy(){
    	return $this->hasOne('App\Models\User', 'id', 'created_by');
    }

    public function updatedBy(){
    	return $this->hasOne('App\Models\User', 'id', 'updated_by');
    }
}
