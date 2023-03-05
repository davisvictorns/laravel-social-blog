<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Follow;
use Illuminate\Http\Request;

class FollowController extends Controller
{
    public function createFollow(User $user){
        if(auth()->user()->id == $user->id) {
            return back()->with('failure', 'You cannot follow yourself.');
        }

        $existCheck = Follow::where([['user_id', auth()->user()->id], ['followeduser', $user->id]])->count();
        if($existCheck){
            return back()->with('failure', 'You already follow this user.');
        }

        $follow = new Follow;
        $follow->user_id = auth()->user()->id;
        $follow->followeduser = $user->id;
        $follow->save();

        return back()->with('success', 'You are now following this user.');
    }

    public function removeFollow(User $user){
        Follow::where([['user_id', auth()->user()->id], ['followeduser', $user->id]])->delete();
        return back()->with('success', 'User successfully unfollowed.');
    }
}
