<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use Illuminate\Http\Request;

class BranchController extends Controller
{

    public function __construct(){
        $this->middleware(['permission:branches.view'])->only('List');
        $this->middleware(['permission:branches.add'])->only('Store');
        $this->middleware(['permission:branches.update'])->only('Update');
        $this->middleware(['permission:branches.delete'])->only('Delete');
    }
  
    public function List(){

        $branches = Branch::all();
        //   $branches = Branch::orderBy('created_at', 'desc')
        // ->paginate(5) 
        // ->withQueryString(); 
        return view('Backend.Branch.List',compact('branches'));
    }

    public function Create(){
        return view('Backend.Branch.Create');
    }


public function store(Request $request)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'manager'  => 'required|string|max:255',
        'phone'    => 'required|string|max:20',
        'status'   => 'required|in:active,inactive',
    ]);

    $branch = new Branch();
    $branch->user_id = auth()->id(); 
    $branch->name = $request->name;
    $branch->location = $request->location;
    $branch->manager = $request->manager;
    $branch->phone = $request->phone;
    $branch->status = $request->status;
    $branch->save();

    return redirect()->route('list.branch')->with('success', 'Branch created successfully.');
}

public function FormUpdate($id)
{
    $branch = Branch::findOrFail($id);
    return view('Backend.Branch.Update', compact('branch'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name'     => 'required|string|max:255',
        'location' => 'required|string|max:255',
        'manager'  => 'required|string|max:255',
        'phone'    => 'required|string|max:20',
        'status'   => 'required|in:active,inactive',
    ]);

    $branch = Branch::findOrFail($id);
    $branch->update($request->only(['name', 'location', 'manager', 'phone', 'status']));

    return redirect()->route('list.branch')->with('success', 'Branch updated successfully.');
}


public function delete($id)
{
    $branch = Branch::findOrFail($id);
    $branch->delete();

    return redirect()->route('list.branch')->with('success', 'Branch deleted successfully.');
}
}
