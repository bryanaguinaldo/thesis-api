<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class FunctionsController extends Controller
{
    public function verify($entry, Request $request)
    {
        $answer = Entry::where('id', $entry)->pluck('answer')->first();

        if (count(Entry::where('id', $entry)->get()) == 0) return response()->json();
        if ($request->input == null) return response()->json(["status" => "fail", "message" => "incorrect answer"]);

        return strtolower($request->input) == strtolower($answer) ?
            response()->json(['status' => 'OK', 'message' => 'correct answer']) :
            response()->json(['status' => 'fail', 'message' => 'incorrect answer']);
    }

    public function isValid()
    {
        return response()->json([
            "status" => "OK"
        ]);
    }
}
