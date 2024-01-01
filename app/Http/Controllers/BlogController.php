<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Blog;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class BlogController extends Controller
{
    public function AddBlog(Request $request){
		$validate = Validator::make($request->all(),[
			'title' => 'required',
			'description' => 'required',
			'image' => 'required|mimes:jpg,jpeg,png',
		]);
		
		if($validate->fails()){
			return response()->json([
				'status' => 'error',
				'message' => $validate->errors(),
			],400);
		}
		
		$image = $request->file('image');
		$name_gen = hexdec(uniqid());
		$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
		$uploadfolder = public_path().'/blog/';
		$destination = 'blog/'.$filename;
		$image->move($uploadfolder,$filename);
		
		$blog = Blog::create([
			'title' => $request->title,
			'description' => $request->description,
			'image' => $destination,
			'created_at' => Carbon::now(),
		]);
		
		if(!is_null($blog)){
			return response()->json([
				'status' => 'success',
				'message' => 'Blog Created Successfully'
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'Blog Creation Failed'
			],201);
		}
	}
	
	public function BlogDetails(){
		$details = Blog::all();
		if(count($details)){
			return response()->json([
				'status' => 'success',
				'blogs' => $this->ImageUrls($details),
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Blog Found'
			],201);
		}
	}
	
	public function ImageUrls($data){
		foreach($data as $blog){
			$blog->image = asset($blog->image);
		}
		return $data;
	}
	
	public function BlogUpdate(Request $request, $id){
		$blog = Blog::find($id);
		if(!empty($blog)){
			if($request->file('image')){
				$image = $request->file('image');
				$name_gen = hexdec(uniqid());
				$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
				$uploadfolder = public_path().'/blog/';
				$destination = 'blog/'.$filename;
				$image->move($uploadfolder,$filename);
				unlink(public_path($blog->image));
			}
			
			$update = Blog::findOrFail($blog->id)->update([
				'title' => isset($request->title)?$request->title:$blog->title,
				'description' => isset($request->description)?$request->description:$blog->description,
				'image' => isset($request->image)?$destination:$blog->image,
				'updated_at' => Carbon::now(),
			]);
			
			if(!is_null($update)){
				return response()->json([
					'status' => 'success',
					'message' => 'Blog Updated Successfully',
				]);
			}else{
				return response()->json([
					'status' => 'error',
					'message' => 'Blog Updation Failed',
				]);
			}
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Blog Found to update'
			],201);
		}
	}
	
	public function BlogDelete(Request $request,$id){
		$blog = Blog::find($id);
		if(!empty($blog)){
			unlink($blog->image);
			$delete = Blog::findOrFail($blog->id)->delete();
			return response()->json([
				'status' => 'success',
				'message' => 'Blog Deleted Successfully',
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Blog Found to delete'
			],201);
		}
	}
	
	public function Blogweb(){
		$blogs = Blog::latest()->get();
		return view('blog', compact('blogs'));
	}
	
	public function BlogStore(Request $request){
		$validate = Validator::make($request->all(),[
			'title' => 'required',
			'description' => 'required',
			'image' => 'required|mimes:jpg,jpeg,png',
		]);
		
		$image = $request->file('image');
		$name_gen = hexdec(uniqid());
		$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
		$uploadfolder = public_path().'/blog/';
		$destination = 'blog/'.$filename;
		$image->move($uploadfolder,$filename);
		
		$blog = Blog::create([
			'title' => $request->title,
			'description' => $request->description,
			'image' => $destination,
			'created_at' => Carbon::now(),
		]);
		return redirect()->back()->with('success','Blog Created Successfully');
	}
	
	public function BlogEdit($id){
		$blog = Blog::findOrFail($id);
		return view('blog_edit',compact('blog'));
	}
	
	public function BlogUpdateWeb(Request $request){
		$id = $request->id;
		if($request->file('image')){
			$image = $request->file('image');
			$name_gen = hexdec(uniqid());
			$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
			$uploadfolder = public_path().'/blog/';
			$destination = 'blog/'.$filename;
			$image->move($uploadfolder,$filename);
			unlink(public_path($request->old_image));
		}
		$blog = Blog::findOrFail($id)->update([
			'title' => $request->title,
			'description' => $request->description,
			'image' => $request->file('image')?$destination:$request->old_image,
			'updated_at' => Carbon::now(),
		]);
		
		return redirect()->route('blog')->with('success','Updated Successfully');
	}
	
	public function BlogDeleteWeb($id){
		$blog = Blog::findOrFail($id);
		unlink(public_path($blog->image));
		$delete = $blog->delete();
		return redirect()->route('blog')->with('success','Deleted Successfully');
	}
}
