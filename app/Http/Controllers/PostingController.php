<?php

namespace App\Http\Controllers;

use App\Models\Posting;
use App\Models\Comment;
use App\Models\ReplyComment;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class PostingController extends Controller
{
    public function addPostingan()
    {
        $user = Auth::user();
        return view('dashboard.posting.add', compact('user'));
    }

    public function storePostingan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'deskripsi' => 'required|string|max:2000',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()->route('tambahPostingan')
                ->withErrors($validator)
                ->withInput();
        }

        $file = $request->file('image');
        $fileName = time() . '_' . $file->getClientOriginalName();
        $file->move('storage/products', $fileName);

        $imagePath = '/storage/products/' . $fileName;

        Posting::create([
            'user_id' => Auth::user()->id,
            'image' => '/storage/products/' . $fileName,
            'deskripsi' => $request->deskripsi,
        ]);

        return redirect()->route('halamanBeranda')->with('success', 'Postingan added successfully');
    }

    public function showBookmarks()
    {
        $user = auth()->user();
        $bookmarkIds = $user->bookmarks()->pluck('posting_id');
        $bookmarkedPosts = Posting::whereIn('id', $bookmarkIds)->with('user')->get();
        return view('dashboard.bookmark.bookmark', compact('bookmarkedPosts'));
    }

    public function bookmark($id)
    {
        $post = Posting::find($id);
        $user = auth()->user();

        if ($post->bookmarks()->where('user_id', $user->id)->exists()) {
            $post->bookmarks()->where('user_id', $user->id)->delete();
        } else {
            $post->bookmarks()->create(['user_id' => $user->id]);
        }

        return redirect()->back();
    }

    public function showDetail($id)
    {
        $posting = Posting::with('user', 'comments')->findOrFail($id);
        return view('dashboard.posting.detail', compact('posting'));
    }

    public function like($id)
    {
        $posting = Posting::findOrFail($id);
        $user = Auth::user();

        if ($posting->likes()->where('user_id', $user->id)->exists()) {
            // Jika sudah di-like, hapus like tersebut
            $posting->likes()->where('user_id', $user->id)->delete();
        } else {
            // Tambahkan like baru
            $like = $posting->likes()->create(['user_id' => $user->id]);

            // Buat notifikasi
            Notification::create([
                'user_id' => $posting->user_id, // ID pengguna yang membuat postingan
                'message' => $user->name . ' menyukai postingan anda', // Pesan notifikasi
                'sender_id' => $user->id, // ID pengguna yang melakukan tindakan (menyukai postingan)
                'type' => 'like', 
                'posting_id' => $posting->id,
            ]);
        }

        return back()->with('success', 'Postingan disukai');
    }
    
    public function comment(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string', // Atur aturan validasi untuk bidang komentar
        ]);

        $posting = Posting::findOrFail($id);
        $user = Auth::user();

        Comment::create([
            'user_id' => $user->id,
            'posting_id' => $id,
            'content' => $request->comment,
        ]);

        Notification::create([
            'user_id' => $posting->user_id,
            'sender_id' => $user->id,
            'message' => 'mengomentari postingan anda',
            'type' => 'comment', // Set jenis notifikasi
            'posting_id' => $posting->id,
        ]);

        return back()->with('success', 'Komentar ditambahkan');
    }

    public function likeComment($id)
    {
        $comment = Comment::findOrFail($id);
        $user = Auth::user();

        if ($comment->likes()->where('user_id', $user->id)->exists()) {
            $comment->likes()->where('user_id', $user->id)->delete();
        } else {
            $comment->likes()->create(['user_id' => $user->id]);
        }

        return back();
    }

    public function hapus(Request $request, $id)
    {
        $comment = Comment::findOrFail($id);
        if ($comment->user_id == auth()->user()->id) {
            $comment->delete();
            return back()->with('success', 'Komentar berhasil dihapus');
        } else {
            return back()->with('error', 'Anda tidak memiliki izin untuk menghapus komentar ini');
        }
    }

    public function reply(Request $request, $commentId)
    {
        $request->validate([
            'replyContent' => 'required|string|max:255',
        ]);

        $comment = Comment::findOrFail($commentId);

        $reply = new ReplyComment();
        $reply->content = $request->input('replyContent');
        $reply->user_id = auth()->id();
        $reply->comment_id = $comment->id;
        $reply->save();

        return redirect()->back()->with('success', 'Reply added successfully.');
    }

    public function hapusReply($id)
    {
        $reply = ReplyComment::find($id);

        if (!$reply) {
            return redirect()->back()->with('error', 'Reply not found.');
        }

        // Optional: You might want to check if the user is authorized to delete this reply
        if (auth()->id() !== $reply->user_id) {
            return redirect()->back()->with('error', 'Unauthorized action.');
        }

        $reply->delete();
        return redirect()->back()->with('success', 'Reply deleted successfully.');
    }
}
