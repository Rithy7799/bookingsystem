<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Service;
use finfo;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
     public function __construct()
    {
        $this->middleware(['permission:services.view'])->only('List');
        $this->middleware(['permission:services.add'])->only('Store');
        $this->middleware(['permission:services.update'])->only('Update');
        $this->middleware(['permission:services.delete'])->only('Delete');
       
    }

    public function List()
{
    $services = Service::orderByDesc('created_at')
        ->paginate(25)
        ->withQueryString();

    return view('Backend.Service.List', compact('services'));
}


    public function Create(){
        return view('Backend.Service.Create');
    }
public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|unique:services,name',
    ]);

    $service = new Service();
    $service->name = $request->name;
    $service->user_id = auth()->id(); 
    $service->save();

    return redirect()->route('list.service')->with('success', 'Service added successfully');
}


public function FormUpdate($id) {
    $service = Service::findOrFail($id);
    return view('Backend.Service.Update', compact('service'));
}

public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|unique:services,name,' . $id, 
    ]);

    $service = Service::findOrFail($id);
    $service->name = $request->name;
    $service->save();

    return redirect()->route('list.service')->with('success', 'Service updated successfully');
}

        
 public function delete($id)
{
    $service = Service::findOrFail($id);
    $service->delete();

    return redirect()->route('list.service')->with('success', 'User deleted successfully.');
}   
}
