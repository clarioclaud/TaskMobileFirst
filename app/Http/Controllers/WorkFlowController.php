<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Article;
use App\Models\User;
use Carbon\Carbon;
use App\Helper\Helper;

class WorkFlowController extends Controller
{
    public function workflows()
    {
        $users = User::where('status', 0)->latest()->get();
        $articles = Article::whereIn('status', [2,3])->latest()->get();
        return view('workflow', compact('users','articles'));
    }

    public function UserActivate(Request $request, $id)
    {
        $activate = User::findOrFail($id)->update([
            'status' => 1
        ]);

        return redirect()->route('workflows')->with('success','Activated');
    }

    public function ArticlePublish(Request $request, $id)
    {
        $publish = Article::findOrFail($id)->update([
            'status' => 4,
            'published_at' => Carbon::now()
        ]);

        $users = User::where('status', 1)->whereNotNull('fcm_token')->pluck('fcm_token')->toArray();
        Helper::Sendfirebasenotification($users,'My Project','New Article Published');
        return redirect()->route('workflows')->with('success','Published');
    }

}
