<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Article') }}
        </h2>
    </x-slot>

	
    <div class="py-12">	
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
					<div class="container">					
						<div class="row">
							<div class="col-md-12">
								<form method="post" id="editform" action="" enctype="multipart/form-data">
									@csrf
									<div class="form-group">
										<label for="title">Article Title</label>
										<input type="text" class="form-control" name="title" id="title" placeholder="Article Title" value="{{ $article->title }}">
										
									</div>
									<div class="form-group">
										<label for="image">Article Image</label>
										<input type="file" class="form-control" name="image" id="image" placeholder="Image">
										<br>
										<a href="{{ asset($article->image) }}" target="_blank"><img src="{{ asset($article->image) }}" width="100px" height="100px"></a>
									</div>
									<div class="form-group">
										<label for="description">Article Description</label>
										<textarea class="form-control" name="description" id="textarea" rows="5" col="5">{{ $article->description }}</textarea>
									</div>
                                    <div class="form-group">
                                        <label for="description">Save Type</label>
                                        <select class="form-control" name="save_type" id="save_type" required>
                                            <option value="" >Select</option>
                                            <option value=1 @if($article->status ==1) selected @endif >Draft</option>
                                            <option value=2 @if($article->status ==2) selected @endif>Sent for Approval</option>
                                            @if(auth()->user()->hasRole('editor'))
                                            <option value=3 @if($article->status ==3) selected @endif>Reviewed</option>
                                            @elseif(auth()->user()->hasRole('admin'))
                                            <option value=3 @if($article->status ==3) selected @endif>Reviewed</option>
                                            <option value=4 @if($article->status ==4) selected @endif >Ready to publish</option>
                                            @endif
                                        </select>
                                        @error('save_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                </div>
									<input type="hidden" name="old_image" value="{{ $article->image }}">
									<input type="hidden" name="token" id="token" value="{{ auth()->user()->auth_token }}">
									<input type="hidden" name="id" id="articleid" value="{{ $article->id }}">
									<button type="submit" class="btn btn-primary" name="submit">Save</button>
								</form>
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

    $("#editform").on('submit', function (e) {
        e.preventDefault();
        tinyMCE.triggerSave();
        var formData = new FormData(this);
        $.ajax({
            type: "POST",
            url: "/api/article/update/" + $('#articleid').val(),
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
			headers: {
				'Authorization': 'Bearer ' + $('#token').val()
			},
            success: function(result) {
                if (result.status == 'success') {
                    toastr.success(result.message, function(){
                        setTimeout(function() {
                            window.location.href = '/article/show';
                        },1000);
                    });
                    
                } else {
                    toastr.error(result.message);
                    
                }
            },
            error: function(e) {
                toastr.error('Something went wrong');
            }
        })
    });
</script>