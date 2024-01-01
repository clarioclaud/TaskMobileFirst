<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BlogComment;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Auth;
use App\Http\Controllers\BlogController;

class BlogcommentController extends Controller
{
    public function AddBlogComment(Request $request){
		$validate = Validator::make($request->all(),[
			'blog_id' => 'required',
			'name' => 'required',
			'email' => 'required',
			'comment' => 'required',
		]);
		
		if($validate->fails()){
			return response()->json([
				'status' => 'error',
				'message' => $validate->errors(),
			],400);
		}
		
		$blog = Blog::where('id',$request->blog_id)->first();
		if(!empty($blog)){
			$add = BlogComment::create([
				'user_id' => 1,
				'blog_id' => $request->blog_id,
				'name' => $request->name,
				'email' => $request->email,
				'comment' => $request->comment,
				'created_at' => Carbon::now(),
			]);
			
			return response()->json([
				'status' => 'success',
				'message' => 'Blog Comment Sent Successfully..wait untill for approval..'
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Blog Found to Comment..'
			],201);
		}
	}
	
	public function BlogCommentDetails(){
		$details = BlogComment::with('blog')->where('status',1)->get();
		if(count($details) > 0){
			return response()->json([
				'status' => 'success',
				'blogcomments' => $this->Details($details),
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Blog Found..'
			],201);
		}
	}
	
	public function Details($details){
		foreach($details as $det){
			$det->blog->image = asset($det->blog->image);
		}	
		return $details;
	}
	
	public function BlogCommentsWeb(){
		$comments = BlogComment::with('blog')->latest()->get();
		return view('blog_comments',compact('comments'));
	}
	
	public function BlogCommentsApprove($id){
		$blog = BlogComment::findOrFail($id)->update([
			'status' => 1,
			'updated_at' => Carbon::now(),
		]);
		
		return redirect()->back()->with('success','Comment Approved Successfully');
	}
}
