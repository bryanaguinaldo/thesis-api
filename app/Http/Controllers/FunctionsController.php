<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use Illuminate\Http\Request;

class FunctionsController extends Controller
{
    public function verify(Entry $entry, Request $request)
    {
        $answer = $entry->pluck('answer')->first();

        if ($request->input == null) return response()->json(null);

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
