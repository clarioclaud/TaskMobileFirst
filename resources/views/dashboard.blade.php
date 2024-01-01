<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                @if(auth()->user()->status == 1)
                    <div class="p-6 bg-white border-b border-gray-200">
                        You're logged in!
                    </div>
                @else
                    <div class="p-6 bg-white border-b border-gray-200">
                        Your Account is not activated by Admin. Contact Administratior.
                    </div>
                @endif
            </div>
        </div>
    </div>

    @if(auth()->user()->hasRole('admin') == 1)
    <div class="row">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <div class="card" style="width: 15rem; height: 9rem; background-color:#ef89af">
                <div class="card-body">
                    <h5 class="card-title text-center"><b>Users</b></h5><br>
                    <p class="card-text text-center"><b>{{ count($user) }}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 15rem; height: 9rem; background-color:#16b5d8">
                <div class="card-body">
                    <h5 class="card-title text-center"><b>Articles</b></h5><br>
                    <p class="card-text text-center"><b>{{ count($article) }}</b></p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card" style="width: 15rem; height: 9rem; background-color:#ae92f8">
                <div class="card-body">
                    <h5 class="card-title text-center"><b>Blogs</b></h5><br>
                    <p class="card-text text-center"><b>{{ count($blog) }}</b></p>
                </div>
            </div>
        </div>
    </div>
    @endif
</x-app-layout>