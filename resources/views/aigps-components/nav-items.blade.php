<a class="nav-link text-dark" href="/">Home</a>
<a class="nav-link text-dark" href="/gallery">Gallery</a>
<a class="nav-link text-dark" href="/reserve">Vaccine Reservation</a>
<a class="nav-link text-dark" href="/reserve/hospital">Reserve Hospital</a>
<a class="nav-link text-dark" href="/stats">Pandemic Statistics</a>

@auth
    @if (Auth::user()->isNationalId())
        <a class="nav-link text-dark" href="/staff/nationalids">
            Modify national IDs
        </a>
    @elseif (Auth::user()->isMoia())
        <a class="nav-link text-dark" href="/staff/moia/escorting">
            Campaigns
        </a>
    @elseif (Auth::user()->isHospital())
        <a class="nav-link text-dark" href="/staff/isohospital/infection">
            Hospitalization
        </a>
    @elseif (Auth::user()->isClerk())
        <a class="nav-link text-dark" href="/staff/clerk/">
            Campaign Clerk Entry
        </a>
    @elseif (Auth::user()->isAdmin())
        <a class="nav-link text-dark" href="/staff/admin">
            Manage roles
        </a>
    @elseif (Auth::user()->isMoh())
        <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
            data-bs-toggle="dropdown">
            Manage
        </a>
        <ul class="dropdown-menu">
            <li><a class="dropdown-item" href="/staff/moh/manage-hospitals">Manage Hospitals</a></li>
            <li><a class="dropdown-item" href="/staff/moh/manage-doctors">Manage Doctors</a></li>
            <li><a class="dropdown-item" href="/staff/moh/manage-campaigns">Manage Campaigns</a></li>
            <li><a class="dropdown-item" href="/staff/moh/articles">Manage Articles</a></li>
            <li><a class="dropdown-item" href="/staff/moh/survey">Manage Survey</a></li>
        </ul>
    @endif

    <a class="nav-link text-dark dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button"
        data-bs-toggle="dropdown">
        {{ Auth::user()->name }}
    </a>
    <ul class="dropdown-menu">
        <li>
            <p class="dropdown-item-text"> {{ Auth::user()->getRoleName() }}</p>
        </li>
        <hr>
        <li><a class="dropdown-item" href="/appointments">My Appointments</a></li>
        <li><a class="dropdown-item" href="/profile">My profile</a></li>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <li>
                <a class="dropdown-item" href="/logout" onclick="event.preventDefault();this.closest('form').submit();">
                    Logout
                </a>
            </li>
        </form>
    </ul>
@else
    <a class="nav-link text-dark" href="/login">Login</a>
    <a class="nav-link text-dark" href="/register">Register</a>
@endauth


<a class="nav-link text-dark" href="/contact"">Contact Us</a>
