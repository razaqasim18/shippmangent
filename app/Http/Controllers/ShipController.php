<?php

namespace App\Http\Controllers;

use App\Models\Ship;
use Illuminate\Http\Request;

class ShipController extends Controller
{
    public function index()
    {
        $title = "List Ship";
        $ship = Ship::orderBy("id", "desc")->get();
        return view('ship.list', compact('title', 'ship'));
    }
    public function add()
    {
        $title = "Create Ship";
        return view('ship.add', compact('title'));
    }
    public function insert(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:ships',
            'image' => 'mimes:jpeg,png,jpg,gif|max:10240',
        ]);
        $image = null;
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/ship'), $image);
        }
        $ship = new Ship();
        $ship->name = $request->name;
        $ship->image = $image;
        if ($ship->save()) {
            return redirect()
                ->route('ship.add')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('ship.add')
                ->with('error', 'Something went wrong');
        }
    }
    public function edit($id)
    {
        $title = "Edit Ship";
        $ship = Ship::findOrFail($id);
        return view('ship.edit', compact('title', 'ship'));
    }
    public function update($id, Request $request)
    {
        $this->validate($request, [
            'name' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $image = null;
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/ship'), $image);
        } else {
            $image = $request->oldimage;
        }
        $ship = Ship::findOrFail($id);
        $ship->name = $request->name;
        $ship->image = $image;
        if ($ship->update()) {
            return redirect()
                ->route('ship.edit', $id)
                ->with('success', 'Data is updated successfully');
        } else {
            return redirect()
                ->route('ship.edit', $id)
                ->with('error', 'Something went wrong');
        }
    }
    public function delete($id)
    {
        $ship = Ship::findOrFail($id);
        $response = $ship->delete();
        if ($response) {
            $json = [
                'type' => 1,
                'msg' => 'Data is deleted successfully',
            ];
        } else {
            $json = [
                'type' => 0,
                'msg' => 'Something went wrong',
            ];
        }
        return response()->json($json);
    }
}
