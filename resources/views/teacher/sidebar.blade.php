<div class="d-flex flex-column flex-shrink-0 p-3 bg-body-tertiary" style="width: 280px;">
    <a href="#" class="d-flex align-items-center mb-3 mb-md-0 me-md-auto link-body-emphasis text-decoration-none">
        <svg class="bi pe-none me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
        <span class="fs-4">Activities</span>
    </a>
    <hr>
    <ul class="nav nav-pills flex-column mb-auto">
        <li class="nav-item">
            <a href="/dispatch" class="nav-link link-body-emphasis" aria-current="page">
                <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/house.svg') }}" alt="Home" />
                Home
            </a>
        </li>
        <li class="nav-item">
            <a href="/projects" class="nav-link link-body-emphasis" aria-current="page">
                <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/box-arrow-right.svg') }}" alt="Projects Lists" />
                Projects
            </a>
        </li>
        <li class="nav-item">
            <a href="/profiles" class="nav-link link-body-emphasis" aria-current="page">
                <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/person-lines-fill.svg') }}" alt="Student Profile" />
                Student's Profiles
            </a>
        </li>
        <li>
            <a href="/approve-inps" class="nav-link link-body-emphasis">
                <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/building-check.svg') }}" alt="Approve InP" />
                Approve InPs
            </a>
        </li>
        <li>
            <a href="/auto_assign_page" class="nav-link link-body-emphasis">
                <div class="d-flex flex-nowrap align-items-center">
                    <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/filetype-exe.svg') }}" alt="Trigger Assignment" />
                    Trigger Automatic Assignment
                </div>
            </a>
        </li>
        <li>
            <a href="/change-profile" class="nav-link link-body-emphasis">
                <div class="d-flex flex-nowrap align-items-center">
                    <img class="bi pe-none me-2" width="16" height="16" src="{{ asset('svgs/passport.svg') }}" alt="Edit Profile" />
                    Edit Profile
                </div>
            </a>
        </li>
    </ul>
</div>

