<?php

namespace Modules\Distributions\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use Validator;
use Throwable;
use App\Models\Categories;
use App\Models\Brands;
use App\Models\Offices;
use App\Models\Products;
use App\Models\Contacts;
use App\Models\ContactTypes;
use App\Models\Distributions;

class DistributionsController extends Controller
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
      $data['lists'] = Distributions::where('distributions.status', '>=', 1)
      ->when(isset($_GET['contact_type_id']) && !empty($_GET['contact_type_id']), function($query){
        $query->leftjoin('contacts', 'contacts.id', '=', 'distributions.contact_id')->where('contacts.contact_type_id', $_GET['contact_type_id']);
      })
      ->when(isset($_GET['contact_id']) && !empty($_GET['contact_id']), function($query){
        $query->where('distributions.contact_id', $_GET['contact_id']);
      })
      ->when(isset($_GET['product_id']) && !empty($_GET['product_id']), function($query){
        $query->where('distributions.product_id', $_GET['product_id']);
      })
      ->when(isset($_GET['product_item_id']) && !empty($_GET['product_item_id']), function($query){
        $query->where('distributions.product_item_id', $_GET['product_item_id']);
      })
      ->when(isset($_GET['category_id']) && !empty($_GET['category_id']), function($query){
        $query->leftjoin('products', 'products.id', '=', 'distributions.product_id')->where('products.category_id', $_GET['category_id']);
      })
      ->when(isset($_GET['brand_id']) && !empty($_GET['brand_id']), function($query){
        $query->leftjoin('products as productBrandInfo', 'productBrandInfo.id', '=', 'distributions.product_id')->where('productBrandInfo.brand_id', $_GET['brand_id']);
      })
      ->when(isset($_GET['office_id']) && !empty($_GET['office_id']), function($query){
        $query->leftjoin('contacts as contactOfficeInfo', 'contactOfficeInfo.id', '=', 'distributions.contact_id')->where('contactOfficeInfo.office_id', $_GET['office_id']);
      })
      ->when(isset($_GET['start_using']) && !empty($_GET['start_using']), function($query){
        $query->where('distributions.start_using', '>=', date('Y-m-d', strtotime($_GET['start_using'])));
      })
      ->when(isset($_GET['end_using']) && !empty($_GET['end_using']), function($query){
        $query->where('distributions.end_using', '<=', date('Y-m-d', strtotime($_GET['end_using'])));
      })
      ->when(isset($_GET['note']) && !empty($_GET['note']), function($query){
        $query->where('distributions.note', 'like', '%'.$_GET['note'].'%');
      })
      ->orderBy('distributions.id', 'desc')->simplePaginate(20);

      // dd($data['lists']);

      $data['categories'] = Categories::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['brands'] = Brands::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['products'] = Products::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['contactTypes'] = ContactTypes::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['offices'] = Offices::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();

      return view('distributions::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
      $data['products'] = Products::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['contacts'] = Contacts::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      return view('distributions::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
      $validator = Validator::make($request->all(), [
        'product_id.*' => 'required|numeric|exists:products,id',
        'product_item_id.*' => 'required|numeric|exists:product_items,id',
        'contact_id.*' => 'required|numeric|exists:contacts,id',
        'date_from.*' => 'required|string',
        'date_to.*' => 'nullable|string',
        'note.*' => 'string|nullable|max:1000',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
      }

      try{
       DB::beginTransaction();

       if(!empty($request->product_id) && (count($request->product_id)>0)){
        foreach($request->product_id as $key => $productId){
         $dataInfo = new Distributions; 
         $dataInfo->contact_id = $request->contact_id;
         $dataInfo->product_id = $request->product_id[$key];
         $dataInfo->product_item_id = $request->product_item_id[$key];
         $dataInfo->start_using = date('Y-m-d', strtotime(str_replace(',', '', $request->date_from[$key])));
         $dataInfo->end_using = !empty($request->date_to[$key]) ? date('Y-m-d', strtotime(str_replace(',', '', $request->date_to[$key]))) : Null;
         $dataInfo->note = $request->note[$key];
         $dataInfo->status = 1;
         $dataInfo->created_by = Auth::user()->id;
         $dataInfo->created_at = date('Y-m-d H:i:s');
         $dataInfo->save();
       }
     }

     DB::commit();

     $ref = !empty($request->ref) ? $request->ref : (isset($request->exit) ? route('Distributions') : route('Distributions Create'));
     return redirect()->to($ref)->with('successMessage', 'Distribution has been created successfully!.');

   }catch(Exception $e){
    DB::rollback();
    return redirect()->route('Distributions')->with('errorMessage', 'Failed to create distribution!.');
  }
}

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
      $data['dataInfo'] = Distributions::where('id', $id)->first();
      $data['products'] = Products::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      $data['contacts'] = Contacts::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
      return view('distributions::edit', $data);
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
        'product_id' => 'required|numeric|exists:products,id',
        'product_item_id' => 'required|numeric|exists:product_items,id',
        'contact_id' => 'required|numeric|exists:contacts,id',
        'date_from' => 'required|string',
        'date_to' => 'nullable|string',
        'note' => 'string|nullable|max:1000',
      ]);

      if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
      }

      try{
       DB::beginTransaction();

       $dataInfo = Distributions::find($id);
       $dataInfo->contact_id = $request->contact_id;
       $dataInfo->product_id = $request->product_id;
       $dataInfo->product_item_id = $request->product_item_id;
       $dataInfo->start_using = date('Y-m-d', strtotime(str_replace(',', '', $request->date_from)));
       $dataInfo->end_using = !empty($request->date_to) ? date('Y-m-d', strtotime(str_replace(',', '', $request->date_to))) : Null;
       $dataInfo->note = $request->note;
       $dataInfo->updated_by = Auth::user()->id;
       $dataInfo->updated_at = date('Y-m-d H:i:s');
       $dataInfo->save();

       DB::commit();

       return redirect()->route('Distributions')->with('successMessage', 'Distribution has been updated successfully!.');

     }catch(Exception $e){
      DB::rollback();
      return redirect()->route('Distributions')->with('errorMessage', 'Failed to update distribution!.');
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
        $dataInfo = Distributions::find($id);
        $dataInfo->status = -1;
        $dataInfo->updated_by = Auth::user()->id;
        $dataInfo->updated_at = date('Y-m-d H:i:s');
        $dataInfo->save();
        return redirect()->back()->with('successMessage', 'Success! Deleted Successfully.');
      }
      return redirect()->back()->with('errorMessage', 'Alert! Error Deleting Data.');
    }


  }
