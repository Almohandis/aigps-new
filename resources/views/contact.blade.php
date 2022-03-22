<x-base-layout>
    <script>
        function Scrolldown() {
            window.scroll(0, 300);
        }
        window.onload = Scrolldown;
    </script>


    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <script src="https://kit.fontawesome.com/a1983178b4.js" crossorigin="anonymous"></script>

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
        </div>

        <div id="contact-info">
            <div class="text-2xl text-black font-bold ml-10" id="contact-title">Get In Touch</div>

            <div class="grid grid-cols-2" style="margin-left: 8rem;margin-top: 1rem;">
                <div>
                    <div class="text-xl text-black ml-20" style="margin-left: 3rem;"><i class="fa-solid fa-envelope"
                            style="margin-right: 1rem;"></i>Our Emails:</div>
                    <div class="text-md text-blue-800 ml-24 underline">AIGPS@gmail.com</div>
                    <div class="text-md text-blue-800 ml-24 underline">AIGPS@hotmail.com</div>
                </div>
                <div>
                    <div class="text-xl text-black ml-20"> <i class="fa-solid fa-phone"
                            style="margin-right: 0.5rem;"></i>Our Hotline:</div>
                    <div class="text-md text-blue-800 ml-24 underline" style="margin-left: 8rem;">15911</div>
                </div>

                <div class="mt-10">
                    <div class="text-xl text-black ml-20" style="margin-left: 3rem;"> <i class="fa-solid fa-clock"
                            style="margin-right: 0.5rem;"></i> Our Working hours:</div>
                    <div class="text-md text-blue-800 ml-24">Everyday except Friday</div>
                    <div class="text-md text-blue-800 ml-24">8:00AM - 8:00PM</div>
                </div>
            </div>

            <div class="text-2xl text-black font-bold ml-10" id="contact-title">Our Location</div>
            <div style="height: 450px; padding: 20px;">
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.5268123249007!2d31.309183415424524!3d29.99302608190114!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145839202cd65b27%3A0x5bee403e7f57345c!2sModern%20University%20for%20Technology%20%26%20Information!5e0!3m2!1sen!2seg!4v1647614214306!5m2!1sen!2seg" width="100%" height="400" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
    </body>

</x-base-layout>
