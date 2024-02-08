<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Label;
use App\Models\Ticket;
use App\Models\Category;
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
        // For Admin dashboard
        if (Auth::user()->role == 0) {
            $tickets = Ticket::latest()->Paginate(5);
            $categories=Category::all();
            $labels=Label::all();
            $users=User::all();
            return view('home', compact('tickets', 'categories', 'labels','users'));
        }
        // For Agent User dashboard
        if (Auth::user()->role == 1) {
            $tickets = Ticket::where('user_id', Auth::user()->id)
                ->orWhere('created_user_id', Auth::user()->id)
                ->latest()->Paginate(5);
            $assignedTickets = Ticket::where('user_id', Auth::user()->id)->get();
            return view('home', compact('tickets', 'assignedTickets'));
        }
        //For Regular User dashboard
        $user = Auth::user();
        $tickets = Ticket::where('created_user_id', $user->id)->latest()->Paginate(5);
        return view('home', compact('tickets'));
    }
}
