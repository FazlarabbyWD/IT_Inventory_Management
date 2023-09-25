<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use Validator;
use Throwable;
use App\Models\Products;
use App\Models\ProductItems;
use App\Models\ProductItemDetails;
use App\Models\Offices;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\SpecTypes;
use App\Models\Contacts;

class ProductsController extends Controller
{
  public function __construct()
  {
    $this->middleware('auth');
  }

    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
      $data['lists'] = Products::where('status', '>=', 1)
      ->when(isset($_GET['title']) && !empty($_GET['title']), function($query){
        $query->where('title', 'like', '%'.$_GET['title'].'%');
      })
      ->when(isset($_GET['office_id']) && !empty($_GET['office_id']), function($query){
        $query->where('office_id', $_GET['office_id']);
      })
      ->when(isset($_GET['category_id']) && !empty($_GET['category_id']), function($query){
        $query->where('category_id', $_GET['category_id']);
      })
      ->when(isset($_GET['brand_id']) && !empty($_GET['brand_id']), function($query){
        $query->where('brand_id', $_GET['brand_id']);
      })
      ->orderBy('order_id', 'desc')->simplePaginate(10);

      $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['categories'] = Categories::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['brands'] = Brands::where('status', 1)->orderBy('order_id', 'desc')->get();
      return view('products::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
      $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['categories'] = Categories::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['brands'] = Brands::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['specTypes'] = SpecTypes::where('status', 1)->orderBy('order_id', 'asc')->get();
      return view('products::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'office_id' => 'required|numeric|exists:offices,id',
        'category_id' => 'nullable|numeric|exists:categories,id',
        'brand_id' => 'nullable|numeric|exists:brands,id',
        'title' => 'required|string|max:255',
        'spec_types_ids.*' => 'required|integer',
        'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'numeric|between:-1,2',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
      }

      try{
       DB::beginTransaction();

       $dataInfo = new Products;
       $dataInfo->office_id = $request->office_id;
       $dataInfo->category_id = $request->category_id;
       $dataInfo->brand_id = $request->brand_id;
       $dataInfo->spec_type_ids = !empty($request->spec_types_ids) ? implode(',', $request->spec_types_ids) : Null;
       $dataInfo->title = $request->title;
       $dataInfo->order_id = $this->orderId();
       $dataInfo->status = !empty($request->status) ? $request->status: 2;
       $dataInfo->created_by = Auth::user()->id;
       $dataInfo->created_at = date('Y-m-d H:i:s');

       if (!empty($request->photo)) {
        $file = $request->file('photo');
        $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
        $uploadPath = 'uploads/products/';
        $file->move($uploadPath, $file_name);
        $dataInfo->photo = $file_name;
      }

      $dataInfo->save();
      DB::commit();

      return redirect()->route('Products')->with('successMessage', 'Product has been created successfully!.');

    }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Products')->with('errorMessage', 'Failed to create product!.');
    }
  }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
      $data['dataInfo'] = Products::where('id', $id)->first();
      $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['categories'] = Categories::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['brands'] = Brands::where('status', 1)->orderBy('order_id', 'desc')->get();
      $data['specTypes'] = SpecTypes::where('status', 1)->orderBy('order_id', 'asc')->get();
      return view('products::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
      $validator = Validator::make($request->all(), [
        'office_id' => 'required|numeric|exists:offices,id',
        'category_id' => 'nullable|numeric|exists:categories,id',
        'brand_id' => 'nullable|numeric|exists:brands,id',
        'title' => 'required|string|max:255',
        'spec_types_ids.*' => 'required|integer',
        'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        'status' => 'numeric|between:-1,2',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
      }

      try{
       DB::beginTransaction();

       $dataInfo = Products::find($id);
       $dataInfo->office_id = $request->office_id;
       $dataInfo->category_id = $request->category_id;
       $dataInfo->brand_id = $request->brand_id;
       $dataInfo->spec_type_ids = !empty($request->spec_types_ids) ? implode(',', $request->spec_types_ids) : Null;
       $dataInfo->title = $request->title;
       $dataInfo->status = !empty($request->status) ? $request->status: 2;
       $dataInfo->updated_by = Auth::user()->id;
       $dataInfo->updated_at = date('Y-m-d H:i:s');

       if (!empty($request->photo)) {
        $file = $request->file('photo');
        $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
        $uploadPath = 'uploads/products/';
        $file->move($uploadPath, $file_name);
        $dataInfo->photo = $file_name;
      }

      $dataInfo->save();
      DB::commit();

      return redirect()->route('Products')->with('successMessage', 'Product has been updated successfully!.');

    }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Products')->with('errorMessage', 'Failed to update product!.');
    }
  }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
      if(!empty($id)){
        $dataInfo = Products::find($id);
        $dataInfo->status = -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');
        $dataInfo->save();
        return redirect()->back()->with('successMessage', 'Success! Deleted Successfully.');
      }
      return redirect()->back()->with('errorMessage', 'Alert! Error Deleting Data.');
    }


    public function orderId()
    {
      $orderData = Products::orderBy('order_id', 'desc')->first();
      $id = !empty($orderData) ? $orderData->order_id+1 : 1;
      return $id;
    }



    public function stockList($id)
    {
      try{
        $dataInfo = Products::where('id', $id)->first();
        $data['dataInfo'] = $dataInfo;
        return view('products::stock-list', $data);
      }catch(Exception $e){
        return redirect()->route('Products')->with('errorMessage', 'Alert! Error Data.');
      }
    }

    public function stockCreate($id)
    {
      try{
        $dataInfo = Products::where('id', $id)->first();
        $data['dataInfo'] = $dataInfo;
        $data['specTypes'] = SpecTypes::whereIn('id', explode(',', $dataInfo->spec_type_ids))->orderBy('order_id', 'asc')->get();
        return view('products::stock-create', $data);
      }catch(Exception $e){
        return redirect()->route('Products')->with('errorMessage', 'Alert! Error Data.');
      }
    }


    public function stockStore(Request $request, $id)
    {
      // dd($request->all());

      $validator = Validator::make($request->all(), [
        'items.*' => 'nullable',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
      }

      try{
       DB::beginTransaction();

       $productInfo = Products::find($id);
       if(!empty($request->items) && count($request->items)>0){
        foreach($request->items as $itemKey => $item){
         if(!empty($productInfo)){
          $productItemsInfo = new ProductItems;
          $productItemsInfo->office_id = $productInfo->office_id;
          $productItemsInfo->product_id = $productInfo->id;
          $productItemsInfo->purchase_date = !empty($request->purchase_date[$itemKey]) ? date('Y-m-d', strtotime($request->purchase_date[$itemKey])) : Null;
          $productItemsInfo->warranty_start = !empty($request->warranty_start[$itemKey]) ? date('Y-m-d', strtotime($request->warranty_start[$itemKey])) : Null;
          $productItemsInfo->warranty_end = !empty($request->warranty_end[$itemKey]) ? date('Y-m-d', strtotime($request->warranty_end[$itemKey])) : Null;
          $productItemsInfo->price = $request->price[$itemKey];
          $productItemsInfo->stock = $request->stock[$itemKey];
          $productItemsInfo->vendor_id = !empty($request->vendor[$itemKey]) ? $request->vendor[$itemKey] : Null;
          $productItemsInfo->order_id = $this->productItemOrderId();
          $productItemsInfo->t_code = 'TC-'.$productItemsInfo->order_id;
          $productItemsInfo->created_by = Auth::user()->id;
          $productItemsInfo->created_at = date('Y-m-d H:i:s');
          $productItemsInfo->save();
        }

        if(!empty($productInfo) && !empty($productItemsInfo) && !empty($item) && count($item)>0){
          foreach($item as $itemDetailKey => $itemDetail){
           $productItemDetailsInfo = new ProductItemDetails;
           $productItemDetailsInfo->office_id = $productInfo->office_id;
           $productItemDetailsInfo->product_id = $productInfo->id;
           $productItemDetailsInfo->product_item_id = $productItemsInfo->id;
           $productItemDetailsInfo->spec_type_id = $itemDetailKey;
           $productItemDetailsInfo->spec_detail = $itemDetail;
           $productItemDetailsInfo->order_id = $this->productItemDetailOrderId();
           $productItemDetailsInfo->created_by = Auth::user()->id;
           $productItemDetailsInfo->created_at = date('Y-m-d H:i:s');
           $productItemDetailsInfo->save();
         }
       }
     }
   }

   DB::commit();

   $ref = !empty($request->ref) ? $request->ref : (isset($request->exit) ? route('Products Stock List', $id) : route('Products Stock Create', $id));
   return redirect()->to($ref)->with('successMessage', 'Product item has been updated successfully!.');

 }catch(Exception $e){
  DB::rollback();
  return redirect()->back()->with('errorMessage', 'Failed to update product item!.');
}
}


public function stockEdit($stockId)
{
  $data['dataInfo'] = ProductItems::where('id', $stockId)->where('status', '>=', 1)->first();
  $data['contacts'] = Contacts::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
  return view('products::stock-edit', $data);
}


public function stockUpdate(Request $request, $id)
{

  $validator = Validator::make($request->all(), [
    'itemDetails.*' => 'nullable',
  ]);

  if ($validator->fails()) {
    return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
  }

  try{
   DB::beginTransaction();

   $productItemsInfo = ProductItems::find($id);
   $productItemsInfo->purchase_date = !empty($request->purchase_date) ? date('Y-m-d', strtotime($request->purchase_date)) : Null;
   $productItemsInfo->warranty_start = !empty($request->warranty_start) ? date('Y-m-d', strtotime($request->warranty_start)) : Null;
   $productItemsInfo->warranty_end = !empty($request->warranty_end) ? date('Y-m-d', strtotime($request->warranty_end)) : Null;
   $productItemsInfo->price = $request->price;
   $productItemsInfo->stock = $request->stock;
   $productItemsInfo->vendor_id = $request->vendor;
   $productItemsInfo->updated_by = Auth::user()->id;
   $productItemsInfo->updated_at = date('Y-m-d H:i:s');
   $productItemsInfo->save();

   if(!empty($productItemsInfo) && !empty($request->itemDetails) && count($request->itemDetails)>0){
    foreach($request->itemDetails as $key => $itemDetail){
     $productItemDetailsInfo = ProductItemDetails::find($key);
     $productItemDetailsInfo->spec_detail = $itemDetail;
     $productItemDetailsInfo->updated_by = Auth::user()->id;
     $productItemDetailsInfo->updated_at = date('Y-m-d H:i:s');
     $productItemDetailsInfo->save();
   }
 }
 DB::commit();

 return redirect()->route('Products Stock List', $productItemsInfo->product_id)->with('successMessage', 'Item has been updated successfully!.');

}catch(Exception $e){
  DB::rollback();
  return redirect()->back()->with('errorMessage', 'Failed to update item!.');
}
}



public function destroyStock($stockId)
{
  if(!empty($stockId)){
    $dataInfo = ProductItems::find($stockId);
    $dataInfo->status = -1;
    $dataInfo->updated_by = Auth::user()->id;
    $dataInfo->updated_at = date('Y-m-d H:i:s');
    $dataInfo->save();
    if($dataInfo){
          #item detail info
      $itemDetailDataInfo = ProductItemDetails::where('product_item_id', $stockId)->update(['status' => -1]);
    }
    return redirect()->back()->with('successMessage', 'Success! Deleted Successfully.');
  }
  return redirect()->back()->with('errorMessage', 'Alert! Error Deleting Data.');
}


public function productItemOrderId()
{
  $orderData = ProductItems::orderBy('order_id', 'desc')->first();
  $id = !empty($orderData) ? $orderData->order_id+1 : 1;
  return $id;
}

public function productItemDetailOrderId()
{
  $orderData = ProductItemDetails::orderBy('order_id', 'desc')->first();
  $id = !empty($orderData) ? $orderData->order_id+1 : 1;
  return $id;
}


public function ajaxGetProducts()
{
  try{
    $dataInfo = Products::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
    return response()->json($dataInfo);
  }catch(Exception $e){
    return Null;
  }
}

public function ajaxGetProductSpecTypes($productId)
{
  try{
    $dataInfo = Products::where('id', $productId)->first();
    $specTypes = SpecTypes::whereIn('id', explode(',', $dataInfo->spec_type_ids))->orderBy('order_id', 'asc')->get();
    return response()->json($specTypes);
  }catch(Exception $e){
    return Null;
  }
}

public function ajaxGetProductItems($productId)
{
  try{
    $dataInfo = Products::where('id', $productId)->with('productItems', 'productItems.distributionInfo', 'productItems.distributionInfo.contactInfo')->first();
    return response()->json($dataInfo->productItems);
  }catch(Exception $e){
    return Null;
  }
}


}
