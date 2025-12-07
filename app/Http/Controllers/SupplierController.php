<?php
namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return Supplier::orderBy('name')->get();
    }

    public function store(Request $r)
    {
        return Supplier::create($r->validate([
            'name'=>'required',
            'contact_person'=>'nullable',
            'phone'=>'nullable',
            'email'=>'nullable|email',
            'address'=>'nullable'
        ]));
    }

    public function show($id)
    {
        return Supplier::findOrFail($id);
    }

    public function update(Request $r, $id)
    {
        $s = Supplier::findOrFail($id);
        $s->update($r->all());
        return $s;
    }

    public function destroy($id)
    {
        Supplier::findOrFail($id)->delete();
        return ['message'=>'Supplier deleted'];
    }
}
