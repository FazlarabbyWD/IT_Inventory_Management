<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

use DB;
use Auth;
use Validator;
use Throwable;
use App\Models\Settings;

class SettingsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit()
    {
        $data['dataInfo'] = Settings::orderBy('id', 'desc')->first();
        return view('settings::edit', $data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'title' => 'string|required|max:255',
            'contact' => 'string|nullable|max:255',
            'email' => 'string|nullable|email|max:255',
            'address' => 'string|nullable|max:255',
            'website' => 'string|nullable|max:255',
            'logo_1' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'logo_2' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_1' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'icon_2' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'thumbnail' => 'nullable|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput()->with('errorMessage','Form validation failed!.');
        }

        try{
           DB::beginTransaction();

           $dataInfo = Settings::orderBy('id', 'desc')->first();
           $dataInfo->title = $request->title;
           $dataInfo->contact = $request->contact;
           $dataInfo->email = $request->email;
           $dataInfo->address = $request->address;
           $dataInfo->website = $request->website;
           $dataInfo->updated_by = Auth::user()->id;
           $dataInfo->updated_at = date('Y-m-d H:i:s');

           if (!empty($request->logo_1)) {
            $file = $request->file('logo_1');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/settings/';
            $file->move($uploadPath, $file_name);
            $dataInfo->logo_1 = $file_name;
        }

        if (!empty($request->logo_2)) {
            $file = $request->file('logo_2');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/settings/';
            $file->move($uploadPath, $file_name);
            $dataInfo->logo_2 = $file_name;
        }

        if (!empty($request->icon_1)) {
            $file = $request->file('icon_1');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/settings/';
            $file->move($uploadPath, $file_name);
            $dataInfo->icon_1 = $file_name;
        }

        if (!empty($request->icon_2)) {
            $file = $request->file('icon_2');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/settings/';
            $file->move($uploadPath, $file_name);
            $dataInfo->icon_2 = $file_name;
        }

        if (!empty($request->thumbnail)) {
            $file = $request->file('thumbnail');
            $file_name = time()."-".rand(111111,999999).".".$file->getClientOriginalExtension();
            $uploadPath = 'uploads/settings/';
            $file->move($uploadPath, $file_name);
            $dataInfo->thumbnail = $file_name;
        }

        $dataInfo->save();
        DB::commit();

        return redirect()->route('Settings Edit')->with('successMessage', 'Settings has been updated successfully!.');

    }catch(Exception $e){
        DB::rollback();
        return redirect()->route('Settings Edit')->with('errorMessage', 'Failed to update settings!.');
    }
}


}
