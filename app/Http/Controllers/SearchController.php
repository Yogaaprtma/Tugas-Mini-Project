<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        if (!empty($search)) {
            $users = User::query()
                ->where(function ($query) use ($search) {
                    $query->where('username', 'like', '%'.$search.'%')
                        ->orWhere('nama', 'like', '%'.$search.'%');
                })
                ->get();
        } else {
            $users = [];
        }

        $latestUsers = User::latest()->take(3)->get();

        return view('dashboard.explore.cari', compact('users', 'latestUsers', 'search'));
    }
}
