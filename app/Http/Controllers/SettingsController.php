<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\Settings;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $setting = Settings::where('type', 'logo')->first();
        // dd($setting);
         return view("admin.settings.index", compact("setting"));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function show(Settings $settings)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function edit(Settings $settings)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request)
    {
        



        $category = Settings::updateOrCreate(
            ['type' => 'logo', 'key' => 'logo'],
            ['value' => $request->logo ? 'uploads/logo/' . uniqid() . "_" . $request->logo->getClientOriginalName() : null]
        );

        if ($request->logo != "") {
            $path = "uploads/logo/";
            $file = $request->logo;
            $filename  = uniqid() . "_" . $file->getClientOriginalName();
            $file->move(public_path($path), $filename);
            $category->value = $path . $filename;
            $category->save();
        }
        return redirect()->back()->with('success', 'Settings Updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Settings  $settings
     * @return \Illuminate\Http\Response
     */
    public function destroy(Settings $settings)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getSuggestion(Request $request)
    {
        if ($request->search) {
            $products = product::where('name', 'like', '%' . $request->search . '%')->get();
            return response()->json($products);
        } else {
            return response()->json('No Products', 404);
        }
    }
}
