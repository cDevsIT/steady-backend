<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\WebsiteSetting;
use Illuminate\Http\Request;

class WebsiteSettingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        menuSubmenu("settings", 'settings');
        $settings = WebsiteSetting::first();
        if (!$settings){
            $settings = new WebsiteSetting();
            $settings->save();
        }
        return view("admin.settings.settings",compact('settings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(WebsiteSetting $websiteSetting)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $settings = WebsiteSetting::find($id);
       if(!$settings){
           return redirect()->route('admin.settings.index')->with('error','No settings found!');
       }

       $settings->gtm = $request->gtm;
       $settings->facebook_url = $request->facebook_url;
       $settings->instagram_url = $request->instagram_url;
       $settings->x_url = $request->x_url;
       $settings->linkedin_url = $request->linkedin_url;
       $settings->youtube_url = $request->youtube_url;
       $settings->tiktok_url = $request->tiktok_url;
       $settings->pinterest_url = $request->pinterest_url;
       $settings->threads_url = $request->threads_url;
       $settings->save();
       return redirect()->route('admin.settings.index')->with('success','Settings updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WebsiteSetting $websiteSetting)
    {
        //
    }
}
