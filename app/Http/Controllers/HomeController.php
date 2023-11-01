<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    // public function saveData(Request $request)
    // {
    //     $request->validate([
    //         'name' => 'required'
    //     ]);

    //     $post = new Post();
    //     $post->name = $request->name;
    //     $post->save();

    //     return response()->json([$post, 'message' => 'save post']);
    // }

    public function getuser()
    {
        $post = Post::all();
        $data = [
            'status' => 200,
            'post' => $post,
            'message' => 'All Post',
            'nirav' => 'msg'
        ];
        return response()->json([$data, 200]);
    }
}
