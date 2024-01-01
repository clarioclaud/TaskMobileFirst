<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js" type="text/javascript"></script>

<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <b>My Project</b>
                <!-- <x-application-logo class="w-20 h-20 fill-current text-gray-500" /> -->
            </a>
        </x-slot>

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" id="register" action="">
            @csrf

            <!-- Name -->
            <div>
                <x-label for="name" :value="__('Name')" />

                <x-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-label for="email" :value="__('Email')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label for="password" :value="__('Password')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                pattern=".{8,}"
                                title="Password should be 8 characters"
                                required autocomplete="new-password" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-input id="password_confirmation" class="block mt-1 w-full"
                                type="password"
                                pattern=".{8,}"
                                title="Password should be 8 characters"
                                name="password_confirmation" required />
            </div>

            <div class="mt-4">
                <x-label for="roles" :value="__('Select Role')" />
                <select id="roles" class="rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full" name="roles" required>
                    <option value="">Select Role</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}"> {{ ucfirst($role->name) }} </option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center justify-end mt-4">
                <a class="underline text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
                    {{ __('Already registered?') }}
                </a>

                <x-button class="ml-4">
                    {{ __('Register') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>

<script type="module" src="{{asset('firebase-messaging-sw.js')}}"></script>
<script type="module">
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });
    var registrationToken;
    import { initializeApp } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-app.js";
    import { getMessaging, getToken } from "https://www.gstatic.com/firebasejs/10.7.1/firebase-messaging.js";

    var firebaseConfig = {
        apiKey: "AIzaSyBzgGiFsGUPQZYzRmGOm048Z6wo8d8yy7w",
        authDomain: "my-project-e3231.firebaseapp.com",
        projectId: "my-project-e3231",
        storageBucket: "my-project-e3231.appspot.com",
        messagingSenderId: "640360439051",
        appId: "1:640360439051:web:86c2f1b123d0a1251cd60e",
        measurementId: "G-4JCPG6730K"
    };

    // Initialize Firebase
    const app = initializeApp(firebaseConfig);

    // Initialize Firebase Messaging
    const messaging = getMessaging(app);
    const token = getToken(messaging, {vapidKey: "BJuRiIhkPYyvAyAVxGfBqfQuomzNYGYgMupEZ0zE0lsyvKe_SeUt58QHh5SXHJVMtdo9c8_RlZVGeLJKK-yl604"})
                    .then((currentToken) => {
                        if (currentToken) {
                            registrationToken = currentToken;
                        } else {
                            console.log('tokennnnn','error');
                        }
                    });

    $("#register").on('submit', function (e) {
        e.preventDefault();
        var formData = new FormData(this);
        formData.append('fcm_token', registrationToken);
        $.ajax({
            type: "POST",
            url: "/api/register",
            data: formData,
            dataType: "json",
            contentType: false,
            cache: false,
            processData: false,
            success: function(result) {
                if (result.status == 'success') {
                    toastr.success(result.message, function(){
                        setTimeout(function() {
                            window.location.href = '/login';
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
