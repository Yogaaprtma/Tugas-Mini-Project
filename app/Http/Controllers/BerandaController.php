<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BerandaController extends Controller
{
    public function index()
    {
        $postings = Posting::all();
        $latestUsers = User::orderBy('created_at', 'desc')->take(3)->get(); 
        return view('dashboard.beranda.index', compact('postings', 'latestUsers'));
    }

    public function foryou()
    {
        // $user = Auth::user();
        $postings = Posting::all();
        $latestUsers = User::orderBy('created_at', 'desc')->take(3)->get(); 
        return view('dashboard.beranda.index', compact('postings', 'latestUsers'))->with('tab', 'foryou');
    }

    public function following()
    {
        $user = Auth::user();
        $followedUsers = $user->followings->pluck('id');
        $postings = Posting::whereIn('user_id', $followedUsers)->get();
        $latestUsers = User::orderBy('created_at', 'desc')->take(3)->get(); 
        return view('dashboard.beranda.index', compact('postings', 'latestUsers'))->with('tab', 'following');
    }
}
