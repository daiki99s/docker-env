<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;


class FollowController extends Controller
{
    public function follow(Request $request){
        auth()->user()->follows()->attach( User::find($request->user_id) );
    // フォロワーを追加
        auth()->user()->followers()->attach( User::find($request->user_id) );
        // return redirect()->route('post.show',$request->post_id);
        return redirect()->back();
    }
    public function unfollow(Request $request){
        auth()->user()->follows()->detach( User::find($request->user_id) );
    // フォロワーを削除
        auth()->user()->followers()->detach( User::find($request->user_id) );  
        // return redirect()->route('post.show',$request->post_id);  
        return redirect()->back();  
    }
}
