<!DOCTYPE html>
<html>

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="server-datetime" content="{{ now() }}">
    <meta name="name" content="">
    <meta name="user-type" content="">
    <meta name="id" content="">
    <title>Alturush | Grocery-Admin</title>
    <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png">


    <link rel="stylesheet" href="{{ asset('custom/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">



</head>

<body class="font-poppins antialiased ">
    <div id="app" class=" fixed top-0 left-0 flex justify-center items-center w-full min-h-screen bg-gray-100">
        <div class="bg-white shadow-lg w-96 rounded p-5 ">
            <div class="flex flex-col  justify-center items-center space-y-5">
                <img src="{{ asset('/img/AlturushDeliveryLogoGradient.png') }}" class="h-20">
                <span class=" text-lg uppercase tracking-wider">GROCERY ADMINISTRATOR</span>
            </div>
            <div class="flex flex-col  justify-center items-center space-y-5">
                <form method="POST" action="{{ route('login') }}" id='myForm' class="p-3">
                    @csrf
                    <div class="space-y-5 mt-10">
                        <div class="relative  w-full flex flex-wrap items-stretch focus:text-yellow-400">
                            <span
                                class="absolute z-10 py-3 pl-3 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </span>
                            <input type="text" name="username"
                                class="relative py-3 px-3 pl-10 w-full  border focus:border-yellow-500 focus:ring-yellow-500 border-gray-300 rounded-lg bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:shadow-outline transition duration-500"
                                placeholder="Username" value="{{ old('username') }}" required autocomplete="username"
                                autofocus />
                        </div>
                        @error('username')
                            <small class="text-red-500 text-xs">{{ $message }}</small>
                        @enderror
                        <div>
                            <div class="relative w-full flex flex-wrap items-stretch focus:text-yellow-400">
                                <span
                                    class="absolute z-10 py-3 pl-3 w-8 h-full leading-snug bg-transparent rounded text-base font-normal text-gray-400 text-center flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                    </svg>
                                </span>
                                <input v-if="!showPassword" type="password" name="password" v-model="password"
                                    class="relative py-3 px-3 pl-10 w-full  border focus:border-yellow-500 focus:ring-yellow-500 border-gray-300 rounded-lg bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:shadow-outline transition duration-500"
                                    placeholder="Password" />
                                <input v-if="showPassword" type="text" name="password" v-model="password"
                                    class="relative py-3 px-3 pl-10 w-full  border focus:border-yellow-500 focus:ring-yellow-500 border-gray-300 rounded-lg bg-white text-sm text-gray-700 placeholder-gray-400 focus:outline-none focus:shadow-outline transition duration-500"
                                    placeholder="Password" />

                            </div>
                            <div class="flex items-center justify-end w-full space-x-1 mt-1 ">
                                <input type="checkbox" name="" @click="toggleShow" id="show_password" class="form-checkbox">
                                <label for="show_password" class="cursor-pointer">Show Password</label>
                            </div>
                        </div>

                        @error('password')
                            <small class="text-red-500 text-xs">{{ $message }}</small>
                        @enderror

                        <div class="w-full">
                            <button type="submit"
                                class="bg-yellow-500 py-2 px-3 rounded w-full text-lg tracking-wider text-white transition duration-500 hover:bg-yellow-600 focus:outline-none"
                                tabindex="3">
                                {{ __('Sign in') }}
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/app.js') }}" defer></script>
</body>

</html>
