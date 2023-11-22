<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
// use Illuminate\Support\Facades\Validator as FacadesValidator;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Validation\Validator;

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

    public function getuser($id = null)
    {
        $user = Auth::user();
        $post = $id ? Post::find($id) : Post::all();
        $data = [
            'status' => 200,
            'user' => $user,
            'message' => 'All Post'
        ];
        return response()->json([$data, 200]);
    }

    public function deletePost($id)
    {
        $post = Post::where('id', $id)->first();
        if ($post) {
            $post->delete();
            $data = [
                'status' => 500,
                'message' => 'Delete Successfull',
                'postname' => $post->name
            ];
            return response()->json([$data]);
        } else {
            $data = [
                'status' => 200,
                'message' => 'Id Not Found'
            ];
            return response()->json([$data]);
        }
    }

    public function updatedata($id, Request $request)
    {
        $post = Post::find($id);

        if (!$post) {
            return response()->json(['message' => 'Post not found'], 404);
        }

        // Validate and update the post data
        $request->validate([
            'post' => 'required|string',
        ]);

        $post->post = $request->input('post');
        $post->save();

        return response()->json(['message' => 'Updated Post', 'post' => $post], 200);
    }

    public function fileupload(Request $request)
    {
        $file = $request->file('image');
        $name = time() . '.' . $file->getClientOriginalExtension();
        $file->storeAs('/public/logo/logo' . $name);

        return response()->json([
            'success' => true
        ]);
    }

    public function registration(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6'
        ]);

        if ($validate->fails()) {
            return response()->json([$validate->errors(), 202]);
        }
        $allData = $request->all();
        $allData['password'] = bcrypt($allData['password']);

        $user = User::create($allData);
        $resArr = [];
        $resArr['token'] = $user->createToken('Laravel')->accessToken;
        $resArr['name'] = $user->name;

        return response()->json([$resArr, 200]);
    }

    public function log(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
            'password' => 'required'
        ]);

        if ($validate->fails()) {
            return response()->json([$validate->errors(), 202]);
        }

        // $credentials = $validate->validated();

        if (Auth::attempt(['email' => $request['email'], 'password' => $request['password']])) {
            $user = Auth::user();
            $token = $user->createToken('Laravel')->accessToken;

            return response()->json(['token' => $token, 'user' => $user->name]);
        }

        return response()->json(['Invalid credentials'], 401);
    }
}
