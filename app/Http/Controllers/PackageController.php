<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Package;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $packages = Package::all();
        return view('admin.packages.index')->with('packages',$packages);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.packages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $package = new Package;
        $package->name = $request->package_name;
        $package->price = $request->package_price;
        $package->save();
        return redirect()->route('admin.package.index')->with('status', 'package added successfully');

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($packageId)
    {
        $package = Package::where('id',$packageId)->first();
        return view('admin.packages.edit')->with('package',$package);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $packageId)
    {
        
        $package = Package::where('id',$packageId)->first();
        $package->name = $request->package_name;
        $package->price = $request->package_price;
        $package->save();
        return redirect()->route('admin.package.index')->with('status','Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($packageId)
    {
        $package = Package::where('id',$packageId)->first();
        $package->delete();
        return redirect()->route('admin.package.index')->with('status','package deleted successfully');
    }
}
