<?php

namespace Modules\Contacts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use Validator;
use Throwable;
use App\Models\Contacts;
use App\Models\ContactTypes;
use App\Models\Offices;

class ContactsController extends Controller
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
        $data['lists'] = Contacts::where('status', '>=', 1)
        ->when(isset($_GET['title']) && !empty($_GET['title']), function($query){
            $query->where('title', 'like', '%'.$_GET['title'].'%');
        })
        ->when(isset($_GET['code']) && !empty($_GET['code']), function($query){
            $query->where('code', $_GET['code']);
        })
        ->when(isset($_GET['contact']) && !empty($_GET['contact']), function($query){
            $query->where('contact', $_GET['contact']);
        })
        ->when(isset($_GET['email']) && !empty($_GET['email']), function($query){
            $query->where('email', $_GET['email']);
        })
        ->when(isset($_GET['office_id']) && !empty($_GET['office_id']), function($query){
            $query->where('office_id', $_GET['office_id']);
        })
        ->when(isset($_GET['contact_type_id']) && !empty($_GET['contact_type_id']), function($query){
            $query->where('contact_type_id', $_GET['contact_type_id']);
        })
        ->orderBy('order_id', 'desc')->simplePaginate(10);

        $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
        $data['contactTypes'] = ContactTypes::where('status', 1)->orderBy('order_id', 'desc')->get();
        return view('contacts::index', $data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
        $data['contactTypes'] = ContactTypes::where('status', 1)->orderBy('order_id', 'desc')->get();
        return view('contacts::create', $data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'company_id' => 'nullable|numeric|exists:offices,id',
            'contact_type_id' => 'nullable|numeric|exists:contact_types,id',
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signature' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
         DB::beginTransaction();

         $dataInfo = new Contacts;
         $dataInfo->office_id = $request->office_id;
         $dataInfo->contact_type_id = $request->contact_type_id;
         $dataInfo->title = $request->title;
         $dataInfo->code = $request->code;
         $dataInfo->bio = $request->bio;
         $dataInfo->contact = $request->contact;
         $dataInfo->email = $request->email;
         $dataInfo->address = $request->address;
         $dataInfo->order_id = $this->orderId();
         $dataInfo->status = !empty($request->status) ? $request->status: 2;
         $dataInfo->created_by = Auth::user()->id;
         $dataInfo->created_at = date('Y-m-d H:i:s');

         if (!empty($request->photo)) {
            $file = $request->file('photo');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/contacts/';
            $file->move($uploadPath, $file_name);
            $dataInfo->photo = $file_name;
        }

        if (!empty($request->signature)) {
            $file = $request->file('signature');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/contacts/signatures/';
            $file->move($uploadPath, $file_name);
            $dataInfo->signature = $file_name;
        }

        $dataInfo->save();
        DB::commit();
        
        $ref = !empty($request->ref) ? $request->ref : route('Contacts');
        return redirect()->to($ref)->with('successMessage', 'Contact has been created successfully!.');

    }catch(Exception $e){
        DB::rollback();
        return redirect()->route('Contacts')->with('errorMessage', 'Failed to create contact!.');
    }
}


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $data['dataInfo'] = Contacts::where('id', $id)->first();
        $data['offices'] = Offices::where('status', 1)->orderBy('order_id', 'desc')->get();
        $data['contactTypes'] = ContactTypes::where('status', 1)->orderBy('order_id', 'desc')->get();
        return view('contacts::edit', $data);
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
            'office_id' => 'nullable|numeric|exists:offices,id',
            'contact_type_id' => 'nullable|numeric|exists:contact_types,id',
            'title' => 'required|string|max:255',
            'code' => 'nullable|string|max:255',
            'bio' => 'nullable|string|max:255',
            'contact' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string|max:1000',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'signature' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'status' => 'numeric|between:-1,2',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
         DB::beginTransaction();

         $dataInfo = Contacts::find($id);
         $dataInfo->office_id = $request->office_id;
         $dataInfo->contact_type_id = $request->contact_type_id;
         $dataInfo->title = $request->title;
         $dataInfo->code = $request->code;
         $dataInfo->bio = $request->bio;
         $dataInfo->contact = $request->contact;
         $dataInfo->email = $request->email;
         $dataInfo->address = $request->address;
         $dataInfo->status = !empty($request->status) ? $request->status: 2;
         $dataInfo->updated_by = Auth::user()->id;
         $dataInfo->updated_at = date('Y-m-d H:i:s');

         if (!empty($request->photo)) {
            $file = $request->file('photo');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/contacts/';
            $file->move($uploadPath, $file_name);
            $dataInfo->photo = $file_name;
        }

        if (!empty($request->signature)) {
            $file = $request->file('signature');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/contacts/signatures/';
            $file->move($uploadPath, $file_name);
            $dataInfo->signature = $file_name;
        }

        $dataInfo->save();
        DB::commit();

        return redirect()->route('Contacts')->with('successMessage', 'Contact has been updated successfully!.');

    }catch(Exception $e){
        DB::rollback();
        return redirect()->route('Contacts')->with('errorMessage', 'Failed to update contact!.');
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
            $dataInfo = Contacts::find($id);
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
        $orderData = Contacts::orderBy('order_id', 'desc')->first();
        $id = !empty($orderData) ? $orderData->order_id+1 : 1;
        return $id;
    }


    public function ajaxGetContacts()
    {
        $contacts = Contacts::where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
        return response()->json($contacts);
    }

    public function ajaxGetContactsByType($contactTypeId)
    {
        $contacts = Contacts::where('contact_type_id', $contactTypeId)->where('status', '>=', 1)->orderBy('order_id', 'desc')->get();
        return response()->json($contacts);
    }


}
