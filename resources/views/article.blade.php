<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Article') }}
        </h2>
    </x-slot>

	
    <div class="py-12">	
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    @if(auth()->user()->hasRole('editor'))
                    @else
					<button type="button" class="btn btn-primary" style="float:right" data-toggle="modal" data-target="#exampleModal">
					  Add Article
					</button>
					<br><br>
                    @endif
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
                                            <th>Author Name</th>
											<th>Title</th>
											<th>Image</th>
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
                                            <td>{{ $article->author_name }}</td>
                                            <td>{{ $article->title }}</td>
											<td><img src="{{ asset($article->image) }}" alt="blog" style="width:70px;height:70px;border-radius:3px"></td>		
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
											<td>{{ Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</td>
											<td>
												<a href="{{ route('article.edit',$article->id) }}" class="btn btn-info">Edit</a>
												@if(auth()->user()->hasRole('editor'))
                                                @else
                                                <a href="{{ route('article.delete',$article->id) }}" class="btn btn-danger" onclick="return confirm('Are you sure want to delete?')">Delete</a>
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
					
					<!-- Button trigger modal -->
					

					<!-- Modal -->
					<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
					  <div class="modal-dialog" role="document">
						<div class="modal-content">
						  <div class="modal-header">
							<h5 class="modal-title" id="exampleModalLabel">Article</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
							  <span aria-hidden="true">&times;</span>
							</button>
						  </div>
						  <div class="modal-body">
								<div class="card">
									<div class="card-header text-center">Add Article</div>
									<div class="card-body">
										<form method="post" id="addarticle" action="" enctype="multipart/form-data">
											@csrf
											<input type="hidden" class="form-control" name="token" id="token" value="{{ auth()->user()->auth_token }}">
											<div class="form-group">
												<label for="title">Article Title</label>
												<input type="text" class="form-control" name="title" id="title" placeholder="Blog Title" required>
												@error('title')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="form-group">
												<label for="image">Article Image</label>
												<input type="file" class="form-control" name="image" id="image" placeholder="Image" required>
												@error('image')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
											<div class="form-group">
												<label for="description">Article Description</label>
												<textarea class="form-control" name="description" id="textarea" rows="5" col="5">Description</textarea>
												@error('description')
													<div class="text-danger">{{ $message }}</div>
												@enderror
											</div>
                                            <div class="form-group">
												<label for="description">Save Type</label>
												<select class="form-control" name="save_type" id="save_type" required>
                                                    <option value="" >Select</option>
                                                    <option value=1 >Draft</option>
                                                    <option value=2 >Sent for Approval</option>
                                                    @if(auth()->user()->hasRole('editor'))
                                                    <option value=3 >Reviewed</option>
                                                    @elseif(auth()->user()->hasRole('admin'))
                                                    <option value=3 >Reviewed</option>
                                                    <option value=4 >Ready to publish</option>
                                                    @endif
                                                </select>
												@error('save_type')
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
	$('#addarticle').on('submit', function(e){
		e.preventDefault();
        tinyMCE.triggerSave();
		var formData = new FormData(this);
		$.ajax({
			type: 'POST',
			url: '/api/article/add',
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
				window.location.href = "/article/show";
			},
			error: function(error) {
				toastr.error('Something Went Wrong');
			}
		})
	});
</script>