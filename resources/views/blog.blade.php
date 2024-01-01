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
				
					<button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#exampleModal">
					  Add Blog
					</button>
					<br><br>
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
											<th>Image</th>
											<th>Title</th>
											<th>Description</th>
											<th>Created At</th>
											<th>Action</th>
										</tr>
									</thead>
									@php
										$i=1;
									@endphp
									<tbody>								
										@foreach($blogs as $blog)
										<tr>
											<td>{{ $i++ }}</td>
											<td><img src="{{ asset($blog->image) }}" alt="blog" style="width:70px;height:70px;border-radius:3px"></td>
											<td>{{ $blog->title }}</td>
											<td>{!! $blog->description !!}</td>
											<td>{{ Carbon\Carbon::parse($blog->created_at)->diffForHumans() }}</td>
											<td>
												<a href="{{ route('blog.edit',$blog->id) }}" class="btn btn-info">Edit</a>
												<a href="{{ route('blog.delete',$blog->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a>
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
					
					<!-- Button trigger modal -->
					

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Blog</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
								<div class="card">
									<div class="card-header text-center">Add Blog</div>
									<div class="card-body">
										<form method="post" id="addblog" action="" enctype="multipart/form-data">
											@csrf
											<input type="hidden" class="form-control" name="token" id="token" value="{{ auth()->user()->auth_token }}">
											<div class="form-group">
												<label for="title">Blog Title</label>
												<input type="text" class="form-control" name="title" id="title" placeholder="Blog Title" required>
												@error('title')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="form-group">
												<label for="image">Blog Image</label>
												<input type="file" class="form-control" name="image" id="image" placeholder="Image" required>
												@error('image')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="form-group">
												<label for="description">Blog Description</label>
												<textarea class="form-control" name="description" id="textarea" rows="5" col="5">Description</textarea>
												@error('description')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
											<button type="submit" class="btn btn-primary" name="submit">Save</button>
										</form>
									</div>
								</div>
						  </div>
						 
						</div>
					  </div>
					</div>
					            
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<script type="text/javascript">
	$('#addblog').on('submit', function(e){
		e.preventDefault();
		tinyMCE.triggerSave();
		var formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: '/api/blog/add',
			data: formData,
			dataType: "json",
			headers: {
				'Authorization': 'Bearer '+ $('#token').val()
			},
			contentType: false,
            cache: false,
            processData: false,
			success: function(result) {
				toastr.success(result.message);
				window.location.href = "/blog/show";
			},
			error: function(error) {
				toastr.error('Something Went Wrong');
			}
		})
	});
</script>