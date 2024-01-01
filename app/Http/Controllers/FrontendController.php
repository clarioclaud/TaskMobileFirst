<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use App\Models\Article;
use App\Models\BlogComment;
use Carbon\Carbon;

class FrontendController extends Controller
{
    public function BlogPage($id,$title){
		$blog = Blog::where('id',$id)->first();
		return view('frontend.post',compact('blog'));
	}

	public function ArticlePage($id,$title)
	{
		$article = Article::find($id);
		return view('frontend.article',compact('article'));
	}
	
	public function CommentSubmit(Request $request){
		$insert = BlogComment::create([
			'blog_id' => $request->id,
			'user_id' => 1,
			'name' => $request->username,
			'email' => $request->useremail,
			'comment' => $request->usercomment,
			'created_at' => Carbon::now(),
		]);
		
		return redirect()->back()->with('success','Comment Sent Successfully...wait until admin approval..');
	}
}
