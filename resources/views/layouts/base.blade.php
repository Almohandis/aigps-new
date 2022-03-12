<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/x-icon" href="EDIT3.png">

    <title>
        {{ $title ?? 'AIGPS' }}
    </title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

    <style>
        body {
            background: white;
            /*background: linear-gradient(90deg, #6075ac 0%, #be989e 100%);*/
        }

    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/header.js') }}" defer></script>
    <script src="https://kit.fontawesome.com/a1983178b4.js" crossorigin="anonymous"></script>
</head>

<body class="antialiased">
    <div class="relative items-top justify-center min-h-screen sm:items-center py-4 sm:pt-0">
        <nav class="header">
            <div class="container flex flex-wrap justify-between items-center mx-auto">
                <a href="/" class="flex">
                    <img class="logo" src="{{ asset('EDIT3.png') }}" alt="Logo">
                    <div class="title">
                        AIGPS
                    </div>
                </a>

                <div class="flex items-center md:order-2">
                    <div class="flex mr-3 text-sm md:mr-0">
                        @auth
                            <a href="{{ url('/') }}" class="text-sm text-white hover:text-blue-100">Dashboard</a>
                        @else
                            <a href="{{ route('login') }}" class="text-sm text-white hover:text-blue-100">Log in</a>

                            @if (Route::has('register'))
                                <a href="{{ route('register') }}"
                                    class="ml-4 text-sm text-white hover:text-blue-100">Register</a>
                            @endif
                        @endauth

                    </div>

                    <button data-collapse-toggle="mobile-menu-2" type="button"
                        class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
                        aria-controls="mobile-menu-2" aria-expanded="false">
                        <span class="sr-only">Open main menu</span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                                clip-rule="evenodd"></path>
                        </svg>
                    </button>
                </div>
                <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
                    <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                        <li>
                            <a href="/"
                                class="block py-2 pr-4 pl-3 text-white bg-blue-700 rounded md:bg-transparent md:p-0 md:hover:text-blue-100">Home</a>
                        </li>
                        <li>
                            <a href="/reserve"
                                class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Vaccine</a>
                        </li>
                        <li>
                            <a href="stats"
                                class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Pandemic
                                Statistics</a>
                        </li>
                        <li>
                            <a href="/reserve"
                                class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Diagnose</a>
                        </li>
                        <li>
                            <a href="/view/contact"
                                class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Contact
                                Us</a>
                        </li>
                        @auth
                            @if (Auth::user()->role_id == 2)
                                <li>
                                    <a href="{{ url('/staff/nationalid/modify') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Modify
                                        national IDs</a>
                                </li>
                            @elseif(Auth::user()->role_id == 4)
                                <li>
                                    <a href="{{ url('/staff/moia/escorting') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Campaign
                                        escorting</a>
                                </li>
                            @elseif(Auth::user()->role_id == 6)
                                {{-- <li>
                                    <a href="{{ url('/staff/isohospital/modify') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Modify
                                        hospital statistics</a>
                                </li> --}}
                                <li>
                                    <a href="{{ url('/staff/isohospital/infection') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Hospitalization</a>
                                </li>
                            @elseif(Auth::user()->role_id == 1)
                                <li>
                                    <a href="{{ url('/staff/moh/manage-hospitals') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Manage
                                        hospitals</a>
                                </li>
                                <li>
                                    <a href="{{ url('/staff/moh/manage-doctors') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Manage
                                        doctors</a>
                                </li>
                                <li>
                                    <a href="{{ url('/staff/moh/manage-campaigns') }}"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Manage
                                        campaigns</a>
                                </li>
                            @elseif(Auth::user()->role_id == 5)
                                <li>
                                    <a href="/staff/clerk"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Insert
                                        patient data</a>
                                </li>
                            @elseif(Auth::user()->role_id == 9)
                                <li>
                                    <a href="/staff/admin"
                                        class="block py-2 pr-4 pl-3 text-white border-b border-gray-100 hover:bg-gray-50 md:hover:bg-transparent md:border-0 md:hover:text-blue-100 md:p-0 dark:text-gray-400 md:dark:hover:text-white dark:hover:bg-gray-700 dark:hover:text-white md:dark:hover:bg-transparent dark:border-gray-700">Manage
                                        roles</a>
                                </li>
                            @endif
                        @endauth
                        <li>
                            <div class="bell-container" align="center">
                                <a href="/notifications">
                                    <i class="fa fa-bell" id="bell" aria-hidden="true"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        {{ $slot }}
    </div>
</body>

</html>
