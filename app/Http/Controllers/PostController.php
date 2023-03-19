<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Jobs\SendEmail;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class PostController extends Controller
{
    public function showCreateForm() {
        return view('create-post');
    }

    public function storeNewPost(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        dispatch(new SendEmail([
            'sendTo' => auth()->user()->email,
            'name' => auth()->user()->username,
            'title' => $incomingFields['title']
        ]));

        return redirect("/post/{$newPost->id}")->with('success', 'New post created successfully!');
    }

    public function storeNewPostAPI(Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        $newPost = Post::create($incomingFields);

        dispatch(new SendEmail([
            'sendTo' => auth()->user()->email,
            'name' => auth()->user()->username,
            'title' => $incomingFields['title']
        ]));

        return $newPost->id;
    }

    public function showCreatedPost(Post $post) {
        $post['body'] = strip_tags(Str::markdown($post->body), '<ul><li><strong><h1><h2><h3><br><p><em>');
        return view('single-post', ['post' => $post]);
    }

    public function delete(Post $post) {
        $post->delete();
        return redirect('/profile/' . auth()->user()->username);
    }

    public function deleteAPI(Post $post) {
        $post->delete();
        return "Post deleted!";
    }

    public function showEditForm(Post $post) {
        return view('edit-post', ['post' => $post]);
    }

    public function actuallyUpdate(Post $post, Request $request) {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);

        return back()->with('success', 'Post edited successfully!');
    }

    public function search($term) {
        $posts = Post::search($term)->get();
        $posts->load('user:id,username,avatar');
        return $posts;
    }
}
