<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use App\Models\TicketLabel;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tickets = Ticket::all();
        return view('tickets.index', compact('tickets'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $priorities = Priority::all();
        $categories = Category::all();
        $labels = Label::all();
        return view('tickets.create', compact('categories', 'labels', 'priorities'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTicketRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTicketRequest $request)
    {

        $ticket = new Ticket;

        $ticket->title = $request->title;
        $ticket->text_description = $request->description;
        $ticket->priority_id = $request->priority;
        //File Data

        $fileData = [];

        $images = $request->file('images'); // Access the array of uploaded files

        foreach ($images as $file) {

            // Generate a unique filename
            $fileName = "gallery_" . uniqid() . "." . $file->extension();

            // Store the file in the specified directory
            $file->storeAs("public/gallery", $fileName);

            // Save the file path in the array
            $fileData[] = "public/gallery/$fileName";
        }
        // Implode file paths into a comma-separated string and assign it to the 'file_path_data' attribute
        $ticket->file_path_data = $fileData ? implode(',', $fileData) : null;
        $ticket->save();
        // Attach the selected labels if they exist
        if ($request->has('labels')) {
            $ticket->labels()->attach($request->input('labels'));
        }
        // Attach the selected categories if they exist
        if ($request->has('categories')) {
            $ticket->categories()->attach($request->input('categories'));
        }
        return redirect()->route('tickets.create')->with('success', "Ticket Created Successfully!");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function show(Ticket $ticket)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function edit(Ticket $ticket)
    {
        $priorities = Priority::all();
        $categories = Category::all();
        $labels = Label::all();
        return view('tickets.edit',compact('ticket','labels','categories','priorities'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTicketRequest  $request
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTicketRequest $request, Ticket $ticket)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        //
    }
}
