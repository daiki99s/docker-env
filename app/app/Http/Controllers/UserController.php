<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Like;
use App\Post;
use App\Report;
use App\Http\Requests\ProfileEditValidation;
use App\Http\Requests\ReportValidation;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $likes = Like::select('likes.post_id', 'posts.id', 'posts.user_id', 'posts.description', 'posts.image', 'users.name', 'users.icon')->join('posts', 'likes.post_id', '=', 'posts.id')->join('users', 'likes.user_id', '=', 'users.id')->where('likes.user_id', Auth::user()->id)->get();
        // return view('posts.like',[
        //     'posts' => $likes
        // ]);    
        $posts = Post::withCount('likes')->orderBy('created_at', 'desc')->get();        
        $like_model = new Like;
        $search = $request->input('search');
        $query = Post::withCount('likes')->orderBy('created_at', 'desc');
        if ($search) {
            $spaceConversion = mb_convert_kana($search, 's');
            $wordArraySearched = preg_split('/[\s,]+/', $spaceConversion, -1, PREG_SPLIT_NO_EMPTY);
            foreach($wordArraySearched as $value) {
                $query->whereHas('user', function($q) use($value){
                    $q->where('name', 'like', '%'.$value.'%');
                  })->orWhere('description', 'like', '%'.$value.'%');
            }
            $posts = $query->get();
        }
        return view('posts.like', [
            'posts'=>$likes,
            'like_model' => $like_model,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = User::find($id);
        $follows = auth()->user()->follows()->get();
        $followed_id = "";
        foreach($follows as $follow){
            if($follow->id == $user->id){
                $followed_id = $follow->id;
            }
        }
        // ログインユーザーの全投稿を取得
        $posts = auth()->user()->posts;
        // dd($posts);
        return view('users.show', [
            'user' => $user,
            'followed_id' => $followed_id,
            'posts' => $posts,
        ]);
    }
    
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        return view('users.edit')->with('user', $user);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileEditValidation $request, $id)
    {
        $user = User::find($id);
        $posts = auth()->user()->posts;
        if(request()->file('profile_bgp') != null ){
            $profile_bgp = request()->file('profile_bgp');
            request()->file('profile_bgp')->storeAs('', $profile_bgp, 'public');
            $user->profile_bgp = $profile_bgp;
        }
        if(request()->file('icon') != null ){
            $icon = request()->file('icon');
            request()->file('icon')->storeAs('', $icon, 'public');
            $user->icon = $icon; 
        }
        $user->name = $request->input('name');
        $user->bio = $request->input('bio');
        $user->save();
        return view('users.show')->with('user', $user)->with('posts', $posts);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function reportForm($id)
    {
        return view('users.report',[
            'id'=>$id,
        ]);
    }

    public function report(ReportValidation $request, $id)
    {
        $report = new Report;
        $report->user_id = $id;
        $report->reason = $request->reason;
        $report->save();
        return redirect('/post');
    }
}
