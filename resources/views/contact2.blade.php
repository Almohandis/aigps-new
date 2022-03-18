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


    </style>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <script src="{{ asset('js/header.js') }}" defer></script>
    <script>
        function Scrolldown() {
            window.scroll(0, 300);
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
            </div>
        </nav>
    </div>

    <div class="h-screen" id="contact-info">
        <div class="text-2xl text-black font-bold ml-10" id="contact-title">Get In Touch</div>

        <div class="grid grid-cols-2">
            <div>
                <div class="text-xl text-black ml-20">Our Emails:</div>
                <div class="text-md text-blue-800 ml-24 underline">AIGPS@gmail.com</div>
                <div class="text-md text-blue-800 ml-24 underline">AIGPS@hotmail.com</div>
            </div>
            <div>
                <div class="text-xl text-black ml-20">Our Hotline:</div>
                <div class="text-md text-blue-800 ml-24 underline">15911</div>
            </div>

            <div class="mt-10">
                <div class="text-xl text-black ml-20">Our Working hours:</div>
                <div class="text-md text-blue-800 ml-24">Everyday except Friday</div>
                <div class="text-md text-blue-800 ml-24">8:00AM - 8:00PM</div>
            </div>
        </div>
    </div>
</body>

</html>
