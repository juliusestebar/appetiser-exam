<?php

namespace App\Http\Controllers;

use App\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class EventController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'from_date' => 'required',
            'to_date' => 'required',
            'event_date' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 200);
        }

        $data = $request->all();

        $event = Event::create($data);

        return response()->json(['data' => $event], 200);
    }
}
