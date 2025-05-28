<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\unit;

class UnitController extends Controller
{
    
    public function index(){
        $unit_types = unit::orderBy("id","desc")->paginate(50);
        return view('admin.unit_type.index',compact('unit_types'));
    }
    public function create(){
        return view('admin.unit_type.create');
    }
    public function store(Request $request){
        $request->validate([
            "name"=>"required",
        ]);
       

        $unit = new unit();
        $unit->name = $request->name;
        $unit->save();

        return redirect()->route('unit.index')->with("success","Add Successfully!");

        
    }
    public function edit($id){
        $unit_type = unit::findOrFail($id);
        return view('admin.unit_type.edit',compact('unit_type'));
    }
    public function update($id , Request $request){
        $request->validate([
            "name"=>"required",
        ]);

        $unit_type = unit::findOrFail($id);
        $unit_type->name = $request->name;
      
        $unit_type->save();
        return redirect()->route('unit.index')->with("success","Update Successfully!");
    }
    public function destory($id){
        $unit = unit::findOrFail($id);
        $unit->delete();
        return redirect()->route('unit.index')->with("success","Delete Successfully!");

    }

    public function getUnits(){
        $unit = unit::orderBy("id","desc")->get();
        return response()->json($unit);
    }

    
}
