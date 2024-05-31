<nav id="sidebar" class="sidebar js-sidebar">
    <div class="sidebar-content js-simplebar">
        <a class="sidebar-brand" href="index.html">
            <span class="align-middle">{{ auth()->user()->role->role_name }}</span>
        </a>

        <ul class="sidebar-nav">
            <li class="sidebar-header">
                Pages
            </li>

            <li class="sidebar-item active">
                <a class="sidebar-link" href="{{ route('user.list') }}">
                    <i class="align-middle" data-feather="user"></i> <span class="align-middle">Menu User</span>
                </a>
            </li>

        </ul>
    </div>
</nav>
