@extends('frontend.main_master')

@section('frontend')
<section style="background: url(https://d19m59y37dris4.cloudfront.net/blog/1-2-1/img/hero.jpg); background-size: cover; background-position: center center" class="hero">
      <div class="container">
        <div class="row">
          <div class="col-lg-7">
            <h1>My Project</h1><a href="#" class="hero-link">Discover More</a>
          </div>
        </div><a href=".intro" class="continue link-scroll"><i class="fa fa-long-arrow-down"></i> Scroll Down</a>
      </div>
    </section>
    <!-- Intro Section-->
    <section class="intro">
      <div class="container">
        <div class="row">
          <div class="col-lg-8">
            <h2 class="h3">Some great intro here</h2>
            <p class="text-big">Place a nice <strong>introduction</strong> here <strong>to catch reader's attention</strong>. Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderi.</p>
          </div>
        </div>
      </div>
    </section>
    
        <!-- Latest Articles -->
    <section class="latest-posts" id="article"> 
      <div class="container">
        <header> 
          <h2>Latest from the Article</h2>
          <p class="text-big"></p>
        </header>
        <div class="row">
		    @foreach($articles as $article)
          <div class="post col-md-4">
            <div class="post-thumbnail"><a href="{{ url('/article/'.$article->id.'/'.$article->title) }}"><img src="{{ asset($article->image) }}" alt="..." class="img-fluid"></a></div>
            <div class="post-details">
              <div class="post-meta d-flex justify-content-between">
                <div class="date">{{ Carbon\Carbon::parse($article->published_at)->format('d F Y') }}</div>
                <!-- <div class="category"><a href="#">Business</a></div> -->
              </div><a href="{{ url('/article/'.$article->id.'/'.$article->title) }}">
                <h3 class="h4">{{ $article->title }}</h3></a>
              <p class="text-muted">{!! $article->description !!}</p>
            </div>
          </div>
		    @endforeach  
        </div>
      </div>
    </section>

    <!-- Latest Posts -->
    <section class="latest-posts" id="blog"> 
      <div class="container">
        <header> 
          <h2>Latest from the Blog</h2>
          <p class="text-big"></p>
        </header>
        <div class="row">
		@foreach($blogs as $blog)
          <div class="post col-md-4">
            <div class="post-thumbnail"><a href="{{ url('/post/'.$blog->id.'/'.$blog->title) }}"><img src="{{ asset($blog->image) }}" alt="..." class="img-fluid"></a></div>
            <div class="post-details">
              <div class="post-meta d-flex justify-content-between">
                <div class="date">{{ Carbon\Carbon::parse($blog->created_at)->format('d F Y') }}</div>
                <!-- <div class="category"><a href="#">Business</a></div> -->
              </div><a href="{{ url('/post/'.$blog->id.'/'.$blog->title) }}">
                <h3 class="h4">{{ $blog->title }}</h3></a>
              <p class="text-muted">{!! $blog->description !!}</p>
            </div>
          </div>
		@endforeach 
          
        </div>
      </div>
    </section>
	
	@endsection