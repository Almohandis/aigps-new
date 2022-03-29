<a class="nav-link text-light" href="/">Home</a>
<a class="nav-link text-light" href="/reserve">Vaccine</a>
<a class="nav-link text-light" href="/stats">Pandemic Statistics</a>
<a class="nav-link text-light" href="/reserve">Diagnose</a>
<a class="nav-link text-light" href="/contact"">Contact Us</a>

@auth
    @if (Auth::user()->isNationalId())
        <a class="nav-link text-light" href="/staff/nationalid/modify">
            Modify national IDs
        </a>
    @elseif (Auth::user()->isMoia())
        <a class="nav-link text-light" href="/staff/moia/escorting">
            Campaigns
        </a>
    @elseif (Auth::user()->isHospital())
        <a class="nav-link text-light" href="/staff/isohospital/modify">
            Modify hospital statistics
        </a>

        <a class="nav-link text-light" href="/staff/isohospital/infection">
            Hospitalization
        </a>
    @elseif (Auth::user()->isClerk())
        <a class="nav-link text-light" href="/staff/clerk">
            Insert patient data
        </a>
    @elseif (Auth::user()->isAdmin())
        <a class="nav-link text-light" href="/staff/admin">
            Manage roles
        </a>
    @elseif (Auth::user()->isMoh())
        <a class="nav-link text-light dropdown-toggle" href="#" id="navbarDarkDropdownMenuLink" role="button" data-bs-toggle="dropdown">
            Manage
        </a>
          <ul class="dropdown-menu dropdown-menu-dark">
            <li><a class="dropdown-item" href="/staff/moh/manage-hospitals">Manage Hospitals</a></li>
            <li><a class="dropdown-item" href="/staff/moh/manage-doctors">Manage Doctors</a></li>
            <li><a class="dropdown-item" href="/staff/moh/manage-campaigns">Manage Campaigns</a></li>
          </ul>
    @endif

@else
    <a class="nav-link text-light" href="/login">Login</a>
    <a class="nav-link text-light" href="/register">Register</a>
@endauth