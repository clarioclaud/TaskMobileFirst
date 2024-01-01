<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="py-12">	
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
					<div class="container">
                        @if(session('message'))
                          <div class="alert alert-success alert-dismissible fade show" role="alert">
                          <strong>{{session('message')}}</strong>
                          <button type="button" class="close" data-dismiss="alert" aria-label="close">
                          <span aria-hidden="true">&times;</span>
                          </button>
                          </div>
                        @endif
						<div class="row">
                            <div class="col-md-2">
                            </div>

                            <div class="col-md-6">
                                <div class="card" style="border:none">
                                    <h4 class="text-center"></h4>
                                    <div class="card-body">
                                        <form action="{{route('profile.edit')}}" method="post">
                                        @csrf
                                        <div class="form-group">
                                            <label class="info-title" for="exampleInputEmail1">Name <span></span></label>
                                            <input type="text"  name="name" class="form-control" value="{{ Auth::user()->name }}" >
                                        </div>
                                        <div class="form-group">
                                            <label class="info-title" for="exampleInputEmail1">Email <span></span></label>
                                            <input type="email"  name="email" class="form-control" value="{{ Auth::user()->email }}" >
                                        </div>
                                        <div class="form-group">
                                            <button type="submit" class="btn btn-primary" name="submit">Update</button>
                                        </div>

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
</x-app-layout>