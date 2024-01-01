@extends('frontend.main_master')

@section('frontend')
 <div class="container">
      <div class="row">
        <!-- Latest Posts -->
        <main class="post blog-post col-lg-8"> 
          <div class="container">
            <div class="post-single">
              <div class="post-thumbnail"><img src="{{ asset($article->image) }}" alt="..." class="img-fluid"></div>
              <div class="post-details">
                <div class="post-meta d-flex justify-content-between">
                  <div class="category"><a href="#">Business</a></div>
                </div>
                <h1>{{ $article->title }}<a href="#"><i class="fa fa-bookmark-o"></i></a></h1>
                <div class="post-footer d-flex align-items-center flex-column flex-sm-row"><a href="#" class="author d-flex align-items-center flex-wrap">
                    <div class="avatar"><img src="https://d19m59y37dris4.cloudfront.net/blog/1-2-1/img/avatar-1.jpg" alt="..." class="img-fluid"></div>
                    <div class="title"><span>John Doe</span></div></a>
                  <div class="d-flex align-items-center flex-wrap">       
                    <div class="date"><i class="icon-clock"></i>{{ Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</div>
                  
                  </div>
                </div>
                <div class="post-body">
                  <p class="lead">{!! $article->description !!}</p>
                 
                </div>
				
				 <!-- Go to www.addthis.com/dashboard to customize your tools -->
			<script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-6170224abc9c1b7f"></script>
			
                <!-- Go to www.addthis.com/dashboard to customize your tools -->
                <div class="addthis_inline_share_toolbox_ec2p"></div>
				
				
                
        </main>
        <aside class="col-lg-4">
          <!-- Widget [Search Bar Widget]-->
          <!--<div class="widget search">
            <header>
              <h3 class="h6">Search the blog</h3>
            </header>
            <form action="#" class="search-form">
              <div class="form-group">
                <input type="search" placeholder="What are you looking for?">
                <button type="submit" class="submit"><i class="icon-search"></i></button>
              </div>
            </form>
          </div>-->
          <!-- Widget [Latest Posts Widget]        -->
          <div class="widget latest-posts">
            <header>
              <h3 class="h6">Latest Articles</h3>
            </header>
            <div class="blog-posts">
			@php
				$articles = App\Models\Article::where('status',4)->where('id','!=',$article->id)->latest()->limit(5)->get();
				
			@endphp
			
			@foreach($articles as $blo)
				<a href="#">
                <div class="item d-flex align-items-center">
                  <div class="image"><img src="{{ asset($blo->image) }}" alt="..." class="img-fluid"></div>
                  <div class="title"><strong>{{ $blo->title }}</strong>
                    <div class="d-flex align-items-center">
                     
                    </div>
                  </div>
                </div></a>
			@endforeach	
			</div>
          </div>
		  
		 
            

         
          <!-- Widget [Tags Cloud Widget]-->
          <!-- <div class="widget tags">       
            <header>
              <h3 class="h6">Tags</h3>
            </header>
            <ul class="list-inline">
              <li class="list-inline-item"><a href="#" class="tag">#Business</a></li>
              <li class="list-inline-item"><a href="#" class="tag">#Technology</a></li>
              <li class="list-inline-item"><a href="#" class="tag">#Fashion</a></li>
              <li class="list-inline-item"><a href="#" class="tag">#Sports</a></li>
              <li class="list-inline-item"><a href="#" class="tag">#Economy</a></li>
            </ul>
          </div> -->
        </aside>
      </div>
    </div>
	@endsection