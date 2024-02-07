<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        if (Auth::user()->role == 0) {
            $tickets = Ticket::all();
            return view('home', compact('tickets'));
        }
        if (Auth::user()->role == 1) {
            $tickets = Ticket::where('user_id', Auth::user()->id)->get();
            $createdTickets = Ticket::where('created_user_id', Auth::user()->id)->get();
            return view('home', compact('tickets', 'createdTickets'));
        }
        $user = Auth::user();
        $tickets = Ticket::where('created_user_id', $user->id)->get();
        return view('home',compact('tickets'));
    }
}
