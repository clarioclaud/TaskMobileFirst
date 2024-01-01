<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use Auth;
use Carbon\Carbon;

class ArticleController extends Controller
{
    public function Articleweb(Request $request)
    {
        if (Auth::user()->hasRole('admin')) {

            $articles = Article::where('status', 4)->latest('published_at')->get();

        } elseif(Auth::user()->hasRole('author')) {

            $articles = Article::where('user_id', Auth::user()->id)->where('status','!=', 4)->latest('created_at')->get();
        
        } elseif (Auth::user()->hasRole('editor')) {

            $articles = Article::where('status',2)->latest('created_at')->get();
        
        }
        
        return view('article', compact('articles'));
    }

    public function AddArticle(Request $request)
    {
        $image = $request->file('image');
		$name_gen = hexdec(uniqid());
		$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
		$uploadfolder = public_path().'/article/';
		$destination = 'article/'.$filename;
		$image->move($uploadfolder,$filename);
		
		$article = Article::create([
			'title' => $request->title,
			'description' => $request->description,
			'image' => $destination,
            'user_id' => Auth::user()->id,
            'author_name' => Auth::user()->name,
            'status' => $request->save_type,
			'created_at' => Carbon::now(),
            'published_at' => $request->save_type == 4 ? Carbon::now() : null
		]);
		
		if(!is_null($article)){
			return response()->json([
				'status' => 'success',
				'message' => 'Article Created Successfully'
			]);
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'Article Creation Failed'
			],201);
		}
    }

    public function ArticleEdit(Request $request, $id)
    {
        $article = Article::findOrFail($id);
        return view('article_edit',compact('article'));
    }

    public function ArticleUpdate(Request $request, $id)
    {
        $article = Article::find($id);
		if(!empty($article)){
			if($request->file('image')){
				$image = $request->file('image');
				$name_gen = hexdec(uniqid());
				$filename = $name_gen.'.'.strtolower($image->getClientOriginalExtension());
				$uploadfolder = public_path().'/blog/';
				$destination = 'blog/'.$filename;
				$image->move($uploadfolder,$filename);
				unlink(public_path($article->image));
			}
			$status = isset($request->save_type)?$request->save_type:$article->status;
			$update = Article::findOrFail($article->id)->update([
				'title' => isset($request->title)?$request->title:$article->title,
				'description' => isset($request->description)?$request->description:$article->description,
				'image' => isset($request->image)?$destination:$article->image,
                'status' => $status,
				'updated_at' => Carbon::now(),
                'published_at' => $status == 4 ? Carbon::now() : null
			]);
			
			if(!is_null($update)){
				return response()->json([
					'status' => 'success',
					'message' => 'Article Updated Successfully',
				]);
			}else{
				return response()->json([
					'status' => 'error',
					'message' => 'Article Updation Failed',
				]);
			}
		}else{
			return response()->json([
				'status' => 'error',
				'message' => 'No Article Found to update'
			],201);
		}
    }

    public function ArticleDelete(Request $request, $id)
    {
        $article = Article::findOrFail($id);
		unlink(public_path($article->image));
		$delete = $article->delete();
		return redirect()->route('article')->with('success','Deleted Successfully');
    }

    public function UserArticle(Request $request)
    {
        $articles = Article::where('user_id', Auth::user()->id)->where('status', 4)->latest('published_at')->get();
        return view('user_article', compact('articles'));
    }

    public function PublishedArticle(Request $request)
    {
        $articles = Article::where('status', 4)->latest('published_at')->get();
        return view('publish_article', compact('articles'));
    }
}
