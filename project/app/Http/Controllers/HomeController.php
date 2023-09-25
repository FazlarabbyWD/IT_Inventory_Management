<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Auth;
use Validator;
use Throwable;
use Hash;
use App\Models\User;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile()
    {
        return view('profile');
    }

    public function profileUpdate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'string|required|max:255',
            'email' => 'string|email|required|max:255|unique:users,email,'.Auth::user()->id,
            'password' => 'string|nullable|min:6',
            'designation' => 'string|nullable|max:255',
            'contact' => 'string|nullable|max:255',
            'address' => 'string|nullable|max:255',
            'photo' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
           DB::beginTransaction();

           $dataInfo = User::find(Auth::user()->id);
           $dataInfo->name = $request->name;
           $dataInfo->email = $request->email;
           $dataInfo->designation = $request->designation;
           $dataInfo->contact = $request->contact;
           $dataInfo->address = $request->address;
           $dataInfo->updated_by = Auth::user()->id;
           $dataInfo->updated_at = date('Y-m-d H:i:s');

           if(!empty($request->password)){
            $dataInfo->password = Hash::make($request->password);
        }

        if (!empty($request->photo)) {
            $file = $request->file('photo');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/users/';
            $file->move($uploadPath, $file_name);
            $dataInfo->photo = $file_name;
        }

        $dataInfo->save();
        DB::commit();

        return redirect()->back()->with('successMessage', 'Profile has been updated successfully!.');

    }catch(Exception $e){
        DB::rollback();
        return redirect()->back()->with('errorMessage', 'Failed to update Profile!.');
    }
}


}
