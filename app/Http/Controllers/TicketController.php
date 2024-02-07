<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
use App\Models\Priority;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Requests\UpdateTicketRequest;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->role == 0) {
            $tickets = Ticket::all();
            return view('tickets.index', compact('tickets'));
        }
        if (Auth::user()->role == 1) {
            $tickets = Ticket::where('user_id', Auth::user()->id)->get();
            $createdTickets = Ticket::where('created_user_id', Auth::user()->id)->get();
            return view('tickets.index', compact('tickets', 'createdTickets'));
        }
        $user = Auth::user();
        $tickets = Ticket::where('created_user_id', $user->id)->get();
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
        $ticket->created_user_id = Auth::User()->id;
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
        $labels = $ticket->labels;
        $categories = $ticket->categories;
        return view('tickets.detail', compact('ticket', 'labels', 'categories'));
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
        $users = User::where('role', 2)->get();
        // Fetch checked labels for the ticket
        $checkedLabels = $ticket->labels->pluck('id')->toArray();
        // Fetch checked categories for the ticket
        $checkedCategories = $ticket->categories->pluck('id')->toArray();
        return view('tickets.edit', compact('ticket', 'labels', 'categories', 'priorities', 'users', 'checkedLabels', 'checkedCategories'));
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
        $ticket->title = $request->title;
        $ticket->text_description = $request->description;
        $ticket->priority_id = $request->priority;
        if ($request->has('user_id')) {
            $ticket->user_id = $request->user_id;
        }
        // Handle file uploads if any
        if ($request->hasFile('images')) {
            $fileData = [];
            $images = $request->file('images');

            foreach ($images as $file) {
                $fileName = "gallery_" . uniqid() . "." . $file->extension();
                $file->storeAs("public/gallery", $fileName);
                $fileData[] = "public/gallery/$fileName";
            }

            // Merge existing file paths with new ones
            $existingFileData = explode(',', $ticket->file_path_data);
            $fileData = array_merge($existingFileData, $fileData);
            $ticket->file_path_data = implode(',', $fileData);
        }
        // Sync labels
        if ($request->has('labels')) {
            $ticket->labels()->sync($request->input('labels'));
        } else {
            // If no labels are selected, detach all existing labels
            $ticket->labels()->detach();
        }

        // Sync categories
        if ($request->has('categories')) {
            $ticket->categories()->sync($request->input('categories'));
        } else {
            // If no categories are selected, detach all existing categories
            $ticket->categories()->detach();
        }

        $ticket->save();

        return redirect()->route('tickets.index')->with('success', "Ticket Updated Successfully!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Ticket  $ticket
     * @return \Illuminate\Http\Response
     */
    public function destroy(Ticket $ticket)
    {
        if ($ticket) {
            $ticket->delete();
            return redirect()->route('tickets.index')->with('delete', "Ticket is Deleted Successfully!");
        }

        return redirect()->back();
    }
}
