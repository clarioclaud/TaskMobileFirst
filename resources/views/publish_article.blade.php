<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Published Article') }}
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
                                            <th>Author Name</th>
											<th>Title</th>
											<th>Image</th>
                                            <th>Status</th>
											<th>Created At</th>
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
                                                @endif
                                            </td>
											<td>{{ Carbon\Carbon::parse($article->published_at)->diffForHumans() }}</td>
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