<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/x-icon" href="EDIT3.png">
        <title>AIGPS</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <script src="https://kit.fontawesome.com/a1983178b4.js" crossorigin="anonymous"></script>

       
        </style>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}" defer></script>
        <script src="{{ asset('js/header.js') }}" defer></script>
        <script>
            function Scrolldown() {
                            window.scroll(0,300); 
                            }
                        window.onload = Scrolldown;
        </script>
    </head>
    <body class="antialiased">
    <img src="/contact.jpg" class="contact-header">
        <div class="divide2"></div>
        <div class="wrap2"></div>
            <h1 class="ml-5 text-left text-4xl text-white" style="text-shadow: 2px 2px 8px #000000;">
                Contact Us
            </h1>
        <div class="py-40 bgimage relative items-top justify-center sm:items-center py-4 sm:pt-0">
            <nav class="header">
                <div class="container flex flex-wrap justify-between items-center mx-auto">
                    <a href="/" class="flex">
                        <img class="logo" id="logo" src="{{ asset('EDIT3.png') }}" alt="Logo">
                        <div class="title" id="title">
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
                                    <a href="{{ route('register') }}" class="ml-4 text-sm text-white hover:text-blue-100">Register</a>
                                @endif
                            @endauth
                        </div>

                        <button data-collapse-toggle="mobile-menu-2" type="button" class="inline-flex items-center p-2 ml-1 text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600" aria-controls="mobile-menu-2" aria-expanded="false">
                            <span class="sr-only">Open main menu</span>
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                            <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                        </button>
                    </div>
                    <div class="hidden justify-between items-center w-full md:flex md:w-auto md:order-1" id="mobile-menu-2">
                        <ul class="flex flex-col mt-4 md:flex-row md:space-x-8 md:mt-0 md:text-sm md:font-medium">
                        <li>
                            <a href="/"
                                class="home">Home</a>
                        </li>
                        <li>
                            <a href="/reserve"
                                class="vaccine">Vaccine</a>
                        </li>
                        <li>
                            <a href="#"
                                class="pandemic">Pandemic Statistics</a>
                        </li>
                        <li>
                            <a href="/reserve"
                                class="diagnose">Diagnose</a>
                        </li>
                        <li>
                            <a href="/view/contact"
                                class="contact-us">Contact Us</a>
                        </li>
                        </ul>
                    </div>
                </div>
            </nav>

            
        </div>

        <div class="h-screen" id="contact-info">
            <div class="text-2xl text-black font-bold ml-10" id="contact-title">Get In Touch</div>
            
            <div class="grid grid-cols-2" style="margin-left: 8rem;margin-top: 1rem;">
                <div>
                    <div class="text-xl text-black ml-20" style="margin-left: 3rem;"><i class="fa-solid fa-envelope" style="margin-right: 1rem;"></i>Our Emails:</div>
                    <div class="text-md text-blue-800 ml-24 underline">AIGPS@gmail.com</div>
                    <div class="text-md text-blue-800 ml-24 underline">AIGPS@hotmail.com</div>
                </div>
                <div>
                    <div class="text-xl text-black ml-20"> <i class="fa-solid fa-phone" style="margin-right: 0.5rem;"></i>Our Hotline:</div>
                    <div class="text-md text-blue-800 ml-24 underline" style="margin-left: 8rem;">15911</div>
                </div>
                
                <div class="mt-10">
                    <div class="text-xl text-black ml-20" style="margin-left: 3rem;" > <i class="fa-solid fa-clock" style="margin-right: 0.5rem;"></i> Our Working hours:</div>
                    <div class="text-md text-blue-800 ml-24">Everyday except Friday</div>
                    <div class="text-md text-blue-800 ml-24">8:00AM - 8:00PM</div>
                </div>
            </div>
        </div>
    </body>
</html>
