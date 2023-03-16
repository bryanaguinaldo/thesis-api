<?php

namespace App\Http\Controllers;

use App\Models\Entry;
use App\Http\Requests\StoreEntryRequest;
use App\Http\Requests\UpdateEntryRequest;
use App\Http\Resources\EntriesResource;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return !in_array($request->subject, ['english', 'math', 'science']) ? EntriesResource::collection(Entry::all()) : EntriesResource::collection(Entry::where('subject', $request->subject)->get());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreEntryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEntryRequest $request)
    {
        $count = Entry::where('subject', $request->subject)->count();
        if($count >= 20){
            return response()->json(["status" => "fail", "message" => "You have reached the maximum allowed questions for this subject."]);
        }
        if ($request->file('file') !== null) {
            $file = $request->file('file');

            $filename = time() . ".jpg";
            $file->storeAs('public/static/images', $filename);
        }

        $entry = Entry::create([
            'subject' => $request->subject,
            'question' => $request->question,
            'answer' => $request->answer,
            'file' => $request->file('file') == null ? null : $filename
        ]);

        return new EntriesResource($entry);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function show(Entry $entry)
    {
        return new EntriesResource($entry);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateEntryRequest  $request
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEntryRequest $request, Entry $entry)
    {
        if ($request->file('file') != null) {
            $file = $request->file('file');

            $filename = Str::random(9) . ".jpg";
            $file->storeAs('public/static/images', $filename);
        }

        $entry->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'file' => $request->file('file') == null ? Entry::where('id', $entry->id)->pluck('file')->first() : $filename
        ]);

        return new EntriesResource($entry);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Entry  $entry
     * @return \Illuminate\Http\Response
     */
    public function destroy(Entry $entry)
    {
        $entry->delete();
        return response(null, 204);
    }
}
