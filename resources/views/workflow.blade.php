<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('WorkFlow') }}
        </h2>
    </x-slot>

	
    <div class="py-12">	
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
			
					<div class="container">
						@if(session('success'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{session('success')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                        @endif

                        <ul class="nav nav-tabs">
                            <li class="nav-item">
                                <button type="button" class="btn btn-light" id="userbtn">User</button>
                            </li>
                            <li class="nav-item">
                                <button type="button" class="btn btn-light" id="articlebtn">Articles</button>
                            </li>
                        </ul>
                        <br>
						<div class="row" id="user">
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>Sl.No</th>
											<th>Name</th>
											<th>Email</th>
											<th>Role</th>
											<th>Created At</th>
											<th>Action</th>
										</tr>
									</thead>
									@php
										$i=1;
									@endphp
									<tbody>								
										@foreach($users as $user)
										<tr>
											<td>{{ $i++ }}</td>
											<td>{{ $user->name }}</td>
											<td>{{$user->email}}</td>
                                            <td>{{ucfirst($user->getRoleNames()[0])}}</td>
											<td>{{ Carbon\Carbon::parse($user->created_at)->diffForHumans() }}</td>
											<td>
												<a href="{{ route('user.activate', $user->id) }}" class="btn btn-info">Activate</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>  
							</div>
							<div class="col-md-4">
								
								
							</div>
						</div>

                        <div class="row" id="article">
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>Sl.No</th>
											<th>Image</th>
                                            <th>Author Name</th>
											<th>Title</th>
											<th>Status</th>
											<th>Created At</th>
											<th>Action</th>
										</tr>
									</thead>
									@php
										$i=1;
									@endphp
									<tbody>								
										@foreach($articles as $article)
										<tr>
											<td>{{ $i++ }}</td>
											<td><img src="{{ asset($article->image) }}" alt="blog" style="width:70px;height:70px;border-radius:3px"></td>
											<td>{{ $article->author_name }}</td>
                                            <td>{{ $article->title }}</td>
											<td> 
                                                @if($article->status == 4)
                                                    <span class="badge badge-pill badge-success">Published</span>
                                                @elseif($article->status == 3)
                                                    <span class="badge badge-pill badge-danger">Reviewed</span>
                                                @elseif($article->status == 2)
                                                    <span class="badge badge-pill badge-warning">Sent For Approval</span>
                                                @elseif($article->status == 1)
                                                    <span class="badge badge-pill badge-primary">Drafted</span>
                                                @endif
                                            </td>
											<td>{{ Carbon\Carbon::parse($article->created_at)->diffForHumans() }}</td>
											<td>
												<a href="{{route('article.publish', $article->id)}}" class="btn btn-info">Ready to publish</a>
											</td>
										</tr>
										@endforeach
									</tbody>
								</table>  
							</div>
							<div class="col-md-4">
								
								
							</div>
						</div>
					</div>
					            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
    $("#article").hide();
    $("#userbtn").on('click',function(){
        $("#user").show();
        $("#article").hide();
    });

    $("#articlebtn").on('click',function(){
        $("#user").hide();
        $("#article").show();
    });
</script>