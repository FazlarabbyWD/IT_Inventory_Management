<?php

namespace Modules\ContactTypes\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use Validator;
use Throwable;
use App\Models\ContactTypes;

class ContactTypesController extends Controller
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
        $data['lists'] = ContactTypes::where('status', '>=', 1)
        ->when(isset($_GET['title']) && !empty($_GET['title']), function($query){
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->when(isset($_GET['status']) && !empty($_GET['status']), function($query){
            $query->where('status', $_GET['status']);
        })
        ->orderBy('order_id', 'desc')->simplePaginate(10);

        return view('contacttypes::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('contacttypes::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title.*' => 'string|required|max:255',
            'status.*' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
           DB::beginTransaction();
           if(!empty($request->title) && (count($request->title)>0)){
            foreach($request->title as $key => $title){
               $dataInfo = new ContactTypes;
               $dataInfo->title = $title;
               $dataInfo->order_id = $this->orderId();
               $dataInfo->status = !empty($request->status[$key]) ? $request->status[$key]: 2;
               $dataInfo->created_by = Auth::user()->id;
               $dataInfo->created_at = date('Y-m-d H:i:s');
               $dataInfo->save();
           }
       }
       DB::commit();

       $ref = !empty($request->ref) ? $request->ref : (isset($request->exit) ? route('ContactTypes') : route('ContactTypes Create'));
       return redirect()->to($ref)->with('successMessage', 'Contact Type has been created successfully!.');

   }catch(Exception $e){
    DB::rollback();
    return redirect()->route('ContactTypes')->with('errorMessage', 'Failed to create contact type!.');
}
}


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['dataInfo'] = ContactTypes::where('id', $id)->first();
        return view('contacttypes::edit', $data);
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
            'title' => 'string|required|max:255',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
           DB::beginTransaction();

           $dataInfo = ContactTypes::find($id);
           $dataInfo->title = $request->title;
           $dataInfo->status = !empty($request->status) ? $request->status : 2;
           $dataInfo->updated_by = Auth::user()->id;
           $dataInfo->updated_at = date('Y-m-d H:i:s');
           $dataInfo->save();
           DB::commit();

           return redirect()->route('ContactTypes')->with('successMessage', 'Contact Type has been updated successfully!.');

       }catch(Exception $e){
        DB::rollback();
        return redirect()->route('ContactTypes')->with('errorMessage', 'Failed to update contact type!.');
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
            $dataInfo = ContactTypes::find($id);
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
        $orderData = ContactTypes::orderBy('order_id', 'desc')->first();
        $id = !empty($orderData) ? $orderData->order_id+1 : 1;
        return $id;
    }

}
