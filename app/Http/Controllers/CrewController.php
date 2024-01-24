<?php

namespace App\Http\Controllers;

use App\Helpers\CustomHelper;
use App\Models\Crew;
use App\Models\CrewSalary;
use App\Models\Ship;
use App\Models\Transection;
use App\Notifications\CrewRegistration;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Str;

class CrewController extends Controller
{
    public function index()
    {
        $crew = Crew::orderBy("id", "desc")->get();
        return view('crew.list', compact('crew'));
    }

    public function add()
    {
        $ship = Ship::all();
        return view('crew.add', compact('ship'));
    }

    public function insert(Request $request)
    {
        $this->validate($request, [
            'ship_id' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'salary' => 'required|max:20',
            'date' => 'required',
            'email' => 'required|unique:crews',
            'password' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $image = null;
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/crew'), $image);
        }
        $crew = new Crew();
        $crew->ship_id = $request->ship_id;
        $crew->name = $request->name;
        $crew->join_date = $request->date;
        $crew->rank = $request->rank;
        $crew->salary = $request->salary;
        $crew->email = $request->email;
        $crew->password = Hash::make($request->password);
        $crew->image = $image;
        if ($crew->save()) {
            $crew->notify(new CrewRegistration($request->email, $request->password));
            return redirect()
                ->route('crew.add')
                ->with('success', 'Data is saved successfully');
        } else {
            return redirect()
                ->route('crew.add')
                ->with('error', 'Something went wrong');
        }
    }

    public function edit($id)
    {
        CustomHelper::ristrictEditor();
        $ship = Ship::all();
        $crew = Crew::findOrFail($id);
        return view('crew.edit', compact('ship', 'crew'));
    }

    public function update($id, Request $request)
    {
        $this->validate($request, [
            'ship_id' => 'required',
            'name' => 'required|max:50',
            'rank' => 'required|max:50',
            'salary' => 'required|max:20',
            'date' => 'required',
            'email' => 'required',
            'image' => 'mimes:jpeg,png,jpg,gif|max:10240',
        ]);

        $image = null;
        if (!empty($request->file('image'))) {
            $image = time() . '.' . $request->file('image')->extension();
            $request
                ->file('image')
                ->move(public_path('uploads/crew'), $image);
        } else {
            $image = $request->oldimage;
        }
        $crew = Crew::findOrFail($id);
        $crew->ship_id = $request->ship_id;
        $crew->name = $request->name;
        $crew->join_date = $request->date;
        $crew->rank = $request->rank;
        $crew->salary = $request->salary;
        $crew->email = $request->email;
        if ($request->password != '') {
            $crew->password = Hash::make($request->password);
        }
        $crew->image = $image;
        if ($crew->update()) {
            return redirect()
                ->route('crew.edit', $id)
                ->with('success', 'Data is updated successfully');
        } else {
            return redirect()
                ->route('crew.edit', $id)
                ->with('error', 'Something went wrong');
        }
    }

    public function delete($id)
    {
        $response = Crew::destroy($id);
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

    public function loadSalary($crewid)
    {
        $crew =  Crew::findOrFail($crewid);
        return view('crew.salary', compact('crew'));
    }

    public function salarySubmit(Request $request)
    {
        $months = [];
        for ($month = 1; $month <= 12; $month++) {
            $months[$month] = Carbon::create(null, $month, 1)->monthName;
        }
        $selectmonth = strtolower($months[$request->month]);
        $response = DB::transaction(function () use ($request, $selectmonth) {
            try {
                CrewSalary::updateOrCreate(
                    [
                        'crew_id' => $request->crew_id,
                        'year' => date("Y"),
                    ],
                    [
                        $selectmonth => $request->salary,
                    ]
                );

                Transection::create([
                    'ship_id' => $request->ship_id,
                    'amount' => $request->salary,
                    'status' => '1',
                    'detail' => 'crew salary',
                    'expense_type' => 3
                ]);

                // If everything is successful, return true
                return true;
            } catch (\Exception $e) {
                // If an exception occurs, the transaction will be rolled back
                // and return false to indicate an error
                return false;
            }
        });
        if ($response) {
            return redirect()
                ->route('crew.salary.load',  $request->crew_id)
                ->with('success', 'Data is updated successfully');
        } else {
            return redirect()
                ->route('crew.salary.load', $request->crew_id)
                ->with('error', 'Something went wrong');
        }
    }
}
