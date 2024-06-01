<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Notification;
use App\Models\Follower;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function profile()
    {
        $user = Auth::user();
        $user->loadCount(['postings', 'followers', 'followings']);
        return view('dashboard.profile.myProfile', compact('user'));
    }

    public function konfirmasiPassword(Request $request)
    {
        // Verifikasi password
        if (Auth::attempt(['email' => Auth::user()->email, 'password' => $request->confirmPassword])) {
            return redirect()->route('editPage'); // Mengarahkan ke halaman edit profil jika password benar
        } else {
            return response()->json(['success' => false], 401); // Password salah, tetap di modal
        }
    }

    public function edit()
    {
        // Logika untuk halaman edit profil
        $user = Auth::user();
        return view('dashboard.profile.editProfile', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'username' => 'required|string|max:255',
            'nama' => 'required|string|max:255',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Jika ingin mengizinkan upload gambar profil
        ]);

        // Ambil data pengguna yang sedang login
        $user = Auth::user();

        // Update data pengguna
        $user->username = $request->username;
        $user->nama = $request->nama;
        $user->bio = $request->bio;

        // Periksa apakah ada file gambar yang diunggah
        if ($request->hasFile('profile_picture')) {
            $image = $request->file('profile_picture');
            $fileName = time() . '_' . $image->getClientOriginalName();
            $image->move('public/images', $fileName); 
            $user->profile_picture = 'public/images/' . $fileName; 
        }

        // Simpan perubahan
        $user->save();

        // Redirect ke halaman edit profil dengan pesan sukses
        return redirect()->route('MyProfile')->with('success', 'Profile updated successfully.');
    }

    public function showProfile($id, Request $request)
    {
        $user = User::withCount(['postings', 'followers', 'followings'])
                    ->with('postings')
                    ->findOrFail($id);

        // Inisialisasi variabel pencarian
        $search = $request->query('search');
        $tab = $request->query('tab', 'followers'); // Default ke followers jika tab tidak disediakan

        // Ambil pengikut (followers) dengan pencarian jika diberikan
        $followers = [];
        $followings = [];

        if ($tab === 'followers') {
            if ($search) {
                $followers = $user->followers()
                    ->where(function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%')
                            ->orWhere('nama', 'like', '%' . $search . '%');
                    })
                    ->get();
            } else {
                $followers = $user->followers;
            }
        } elseif ($tab === 'following') {
            if ($search) {
                $followings = $user->followings()
                    ->where(function ($query) use ($search) {
                        $query->where('username', 'like', '%' . $search . '%')
                            ->orWhere('nama', 'like', '%' . $search . '%');
                    })
                    ->get();
            } else {
                $followings = $user->followings;
            }
        }

        return view('dashboard.profile.detailProfile', compact('user', 'followers', 'followings', 'search', 'tab'));
    }

    public function follow(Request $request, $id)
    {
        $userToFollow = User::findOrFail($id);
        $currentUser = Auth::user();

        if ($currentUser->id !== $userToFollow->id) {
            $currentUser->followings()->attach($userToFollow->id);

            // Membuat notifikasi untuk user yang diikuti
            $notification = new Notification([
                'user_id' => $userToFollow->id,
                'sender_id' => $currentUser->id,
                'message' => 'mulai mengikuti anda',
            ]);
            $userToFollow->notifications()->save($notification);

            return redirect()->back()->with('success', 'User followed successfully!');
        }

        return redirect()->back()->with('error', 'You cannot follow yourself.');
    }

    public function unfollow($id)
    {
        $userToUnfollow = User::findOrFail($id);
        $currentUser = Auth::user();

        if ($currentUser->id !== $userToUnfollow->id) {
            $currentUser->followings()->detach($userToUnfollow->id);

            // Hapus notifikasi jika ada
            $currentUser->notifications()->where('user_id', $userToUnfollow->id)->delete();

            return redirect()->back()->with('success', 'User unfollowed successfully!');
        }

        return redirect()->back()->with('error', 'You cannot unfollow yourself.');
    }
}
