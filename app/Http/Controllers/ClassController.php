<?php

namespace App\Http\Controllers;

use App\Models\Classes;
use App\Models\Hour;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Models\Day;

class ClassesController extends Controller
{
    public function __construct()
    {
        if(!Session::has("class")) {
            Session::put("class", []);
        }
    }
    public function index()
    {
        return view(
            "class.index",
            [
                "materias"=> Classes::addSelect([
                    'day' => Day::select('description')->whereColumn('id', 'class.day'),
                    'hour' => Hour::select('hour')->whereColumn('id','class.idhour')
                ])->get(),
            ]
        );
    }

    public function create()
    {
        return view(
            "class.create",
            [
                "days" => Day::All(),
                "hours" => Hour::all()
            ]
        );
    }

    public function edit($id)
    {
        $class = Classes::findOrFail($id);

        return view(
            "class.edit",
            [
                "days" => Day::all(),
                "hours" => Hour::all(),
                "class" => $class
            ]
        );
    }

    public function update($id, Request $request)
    {
        $class = Classes::find($id);
        $class->description = $request->description;
        $class->idhour = $request->hour;
        $class->day = $request->day;
        $class->save();
        return redirect("class");
    }

    public function store(Request $request)
    {
        $class = new Classes();
        $class->description = $request->description;
        $class->day = $request->day;
        $class->idhour = $request->hour;
        $class->iduser = Auth::user()->id;
        $class->save();

        return redirect("class");
    }

    public function destroy(Classes $class)
    {
        $class->delete();

        return redirect("class");
    }

    protected function getDays()
    {
        return [
            'Monday',
            'Tuesday',
            'Wednesday',
            'Thursday',
            'Friday'
        ];
    }

    protected function getHours()
    {
        return [
            '19:15',
            '22:15'
        ];
    }
}
