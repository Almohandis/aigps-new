<nav class="p-3 aigps-nav aigps-nav-desktop">
    <div class="container-fluid nav justify-content-center nav-desktop">
        <a class="navbar-brand text-dark" href="/" style="position: absolute; left: 40px;">
            <img src="/EDIT3.png" width="30" height="30" alt="">
            AIGPS
        </a>

        <x-nav-items></x-nav-items>
    </div>
</nav>

<nav class="navbar navbar-expand-lg navbar-dark aigps-nav aigps-nav-mobile">
    <div class="container-fluid">
        <a class="navbar-brand text-dark" href="/">
            <img src="/EDIT3.png" width="30" height="30" alt="">
            AIGPS
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navBarDropdown" >
            <span><img src="{{ asset('/images/menu-button.svg') }}" width="32"></span>
        </button>

        <div class="collapse navbar-collapse" id="navBarDropdown">
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <x-nav-items></x-nav-items>
                </li>
            </ul>
        </div>
    </div>
</nav>