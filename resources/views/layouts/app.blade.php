<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="name" content="{{ Auth::user()->name }}">
    <meta name="user-type" content="{{ Auth::user()->usertype_id }}">
    <meta name="id" content="{{ Auth::user()->id }}">
    <meta name="server-datetime" content="{{ now() }}">

    <title>Alturush | GROCERY-ADMIN</title>
    {{-- <link rel="icon" type="image/x-icon" href="https://www.alturush.com/alturush_logo/AlturushDeliveryLogoGradient.png"> --}}

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>

<body class="font-poppins antialiased ">
    <div id='app'>
        <nav class="fixed w-full z-10 top-0 shadow ">
            <div
                class=" flex items-center justify-between  bg-gray-100 p-4 shadow-lg border-gray-200 dark:bg-gray-900 dark:text-white">
                <div class="flex items-center flex-shrink-0 text-white  ">
                    <router-link to="/" class="brand-logo ">
                        <img class="mr-6 w-40" src="{{ asset('img/alturush.png') }}" alt="main">
                    </router-link>
                </div>
                <div class="relative">
                    <button id="showMenu" @click="open = !open" @blur="handleBlur"
                        class="max-w-xs flex items-center  text-sm rounded-full text-white focus:outline-none focus:shadow-solid"
                        id="user-menu" aria-label="User menu" aria-haspopup="true">
                        <div class="sm:hidden md:block">
                            <span class="text-gray-500  text-center font-semibold px-3  tracking-wide">Hello, <span
                                    class="uppercase">{{ Auth::user()->username }}</span>
                            </span>
                        </div>
                    </button>

                    <figure v-if="open" id='menu'
                        class=" absolute z-30 right-0 mt-2 w-80 bg-white rounded-lg overflow-hidden tracking-wide ">
                        <div class="grid grid-cols-3 gap-3 p-5 ">
                            <div class=" rounded-full h-20 w-20 relative bg-gray-200">
                                <img class="w-20 rounded-full" src="{{ asset('USER-PROFILE/'. Auth::user()->image ) }}" alt="">
                                <button @click="showUpload"
                                    class="absolute bottom-0 right-0 p-1 bg-white rounded-full focus:outline-none text-gray-500 hover:text-blue-500 transition duration-500">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5  " fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </button>
                            </div>
                            <div class=" col-span-2">
                                <div class="w-full flex flex-col items-center space-y-2">
                                    <router-link to="/change_username"
                                        class=" text-center w-full p-2 text-sm font-bold rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                                        Change Username
                                    </router-link>
                                    <router-link to="/change_password"
                                        class="text-center w-full p-2 text-sm font-bold rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                                        Change Password
                                    </router-link>
                                </div>
                            </div>
                        </div>
                        <a href="{{ route('logout') }}" onclick="event.preventDefault();
                        document.getElementById('logout-form').submit();"
                            class=" flex justify-end items-center uppercase tracking-wider focus:outline-none  bg-yellow-500 w-full bg-opacity-80 font-bold px-4 py-2 text-white hover:text-white hover:bg-yellow-500 transition duration-500">
                            <span class="mx-auto">Logout</span>
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                            @csrf
                        </form>
                    </figure>
                </div>
                <button class="focus:outline-none sm:block md:hidden" @click="openMenu = !openMenu" @blur="toggleMenu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>

            </div>
            <div v-if="openMenu" class="bg-gray-100 p-4 flex justify-center items-center transistion duration-500">
                <div class="w-48 flex flex-col items-center space-y-2 tracking-wider">
                    <router-link to="/change_username"
                        class=" text-center w-full p-2 text-sm font-bold rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                        Change Username
                    </router-link>
                    <router-link to="/change_password"
                        class="text-center w-full p-2 text-sm font-bold rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                        Change Password
                    </router-link>

                    <a href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();"
                        class="text-center w-full p-2 text-sm font-bold rounded bg-blue-500 bg-opacity-80 text-white  hover:text-white hover:bg-blue-500 transition duration-500">
                        <span class="mx-auto">Logout</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
            <div class="w-full bg-yellow-500 shadow-md">
                @can('isSuperAdmin')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">
                            <router-link :to="{ name: 'dashboard', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class=" text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="">DASHBOARD</span>
                            </router-link>
                            <router-link :to="{ name: 'menu', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                class=" text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16" />
                                </svg>
                                <span>MENU</span>
                            </router-link>
                        </ul>
                    </div>
                @endcan
                @can('isGGM')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">
                            <li>
                                <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span>DASHBOARD</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link
                                    :to="{ name: 'uploading', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>ITEM, PRICE</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link :to="{ name: 'setting', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>IMAGE FILENAME AND CATEGORY</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                @endcan
                @can('isIAD')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">
                            <li>
                                <router-link
                                    :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>LIQUIDITION REPORT</span>
                                </router-link>
                            </li>
                            <li>
                                <router-link
                                    :to="{ name: 'accountability_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>CASHIER ACCOUNTABILITY REPORT</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                @endcan
                @can('isPurchasing')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">

                            <li class="nav-item">
                                <router-link :to="{ name: 'home', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                    </svg>
                                    <span>DASHBOARD</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span>ITEM MASTERFILE</span>
                                </router-link>
                            </li>
                            <li class="nav-item">
                                <router-link
                                    :to="{ name: 'disabled_item', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12" />
                                    </svg>
                                    <span>UPLOAD ITEM CODE TO DISABLE</span>
                                </router-link>
                            </li>
                            <li class="nav-item ml-1">
                                <router-link
                                    :to="{ name: 'reports_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>ITEM REPORT</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                @endcan
                @can('isAccounting')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">
                            <li>
                                <router-link :to="{ name: 'export', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                    </svg>
                                    <span>EXPORT FILES</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                @endcan
                @can('isSupervisor')
                    <div class="container">
                        <ul
                            class="list-reset flex items-center sm:justify-center md:justify-start uppercase space-x-5 text-white font-semibold text-sm tracking-normal p-2">
                            <li>
                                <router-link
                                    :to="{ name: 'liquidition_store', params: { id: {{ Auth::user()->usertype_id }}  } }"
                                    class="text-white hover:bg-white hover:text-yellow-500 rounded transition duration-500 p-2 flex ">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                    <span>LIQUIDITION REPORT</span>
                                </router-link>
                            </li>
                        </ul>
                    </div>
                @endcan
            </div>
        </nav>

        <header>
            <div class="absolute top-0 bottom-80 left-0 right-0 bg-gray-200"></div>
        </header>
        <div class=" relative p-5 mt-36 ">
            <transition enter-active-class="ease-in duration-300" enter-class="opacity-0" enter-to-class="opacity-100"
                leave-active-class="ease-in duration-300" leave-class="opacity-100" leave-to-class="opacity-0">
                <router-view></router-view>
            </transition>
        </div>

        <button id="backtoTop"
            class="hidden fixed z-30 bottom-0 right-0 mb-3 mr-3 focus:outline-none bg-red-500 bg-opacity-80 hover:bg-red-500 w-12 h-12 rounded-full shadow-xl transition duration-700 ease-in-out transform hover:scale-105 ">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white mx-auto" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>
        </button>


        <transition enter-active-class="ease-in duration-300" enter-class="opacity-0" enter-to-class="opacity-100"
            leave-active-class="ease-in duration-300" leave-class="opacity-100" leave-to-class="opacity-0">
            <Profile v-if="upload_profile"/>
        </transition>
    </div>
    <script defer src="{{ asset('js/app.js') }}"></script>
    <script defer src="{{ asset('js/custom.js') }}"></script>

</body>

</html>
