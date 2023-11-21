<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Posts;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    //
    function index()
    {
        $lists = Posts::orderBy('created_at', 'DESC')->get();
        return view('admin.posts.lists', compact('lists'));
    }
    function add(){
        return view('admin.posts.add');
    }
    function postAdd(Request $request){
        $request->validate([
            'title' =>'required',
            'content_post' =>'required'
        ]);
        $posts = new Posts();
        $posts->title = $request->title;
        $posts->content = $request->content_post;
        $posts->user_id = Auth::user()->id;
        $posts->save();
        return redirect()->route('admin.posts.index')
            ->with('msg', 'Thêm Bài Viết Thành Công!')
            ->with('type', 'success');
    }
    function edit(Posts $post){
        return view('admin.posts.edit', compact('post'));
    }
    function postEdit(Posts $post, Request $request){
        $request->validate([
            'title' =>'required',
            'content_post' =>'required',
        ]);
        $post->title = $request->title;
        $post->content = $request->content_post;
        $post->update();
        return back()
            ->with('msg', 'Cập Nhật Bài Viết Thành Công!')
            ->with('type', 'success');
    }
    function delete(Posts $post){
        $status = Posts::destroy($post->id);
        if ($status){
            return redirect()->route('admin.posts.index')
                ->with('msg', 'Bạn Xóa Bài Viết Thành Công!')
                ->with('type', 'success');
        }
        return redirect()->route('admin.posts.index')
            ->with('msg', 'Xóa Bài Viết Không Thành Công, Hãy Thử Lại')
            ->with('type', 'danger');
    }
}
