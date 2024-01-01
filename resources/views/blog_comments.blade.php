<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Blog') }}
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
						<div class="row">
							<div class="col-md-12">
								<table class="table">
									<thead>
										<tr>
											<th>Sl.No</th>											
											<th>Blog Title</th>
											<th>User Name</th>
											<th>User Email</th>
											<th>Comment</th>
											<th>Commented At</th>
											<th>Action</th>
										</tr>
									</thead>
									@php
										$i=1;
									@endphp
									<tbody>								
										@foreach($comments as $comment)
										<tr>
											<td>{{ $i++ }}</td>											
											<td>{{ $comment->blog->title }}</td>
											<td>{{ $comment->name }}</td>
											<td>{{ $comment->email }}</td>
											<td>{{ $comment->comment }}</td>
											<td>{{ Carbon\Carbon::parse($comment->created_at)->diffForHumans() }}</td>
											<td>
												@if($comment->status == 0)
													<a href="{{ route('blog.approve',$comment->id) }}" class="btn btn-danger">Approve Pending</a>
												@else
													<a href="#" class="btn btn-info">Approved</a>
												@endif
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