
<aside class="sentra-sidebar">
    <!-- Logo -->
    <div class="sentra-logo">
        Testora
    </div>

    <!-- Workspace -->
    <div class="workspace-selector">
        <span>Testora Workspace</span>
        <span class="workspace-arrow">⌄</span>
    </div>

    <!-- Navigation -->
    <nav class="sidebar-navigation">

        <a href="{{ route('dashboard') }}"
           class="sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
            <span class="sidebar-icon">▦</span>
            <span>Dashboard</span>
        </a>

        @role('tester')
            <a href="{{ route('tester.projects.index') }}"
            class="sidebar-link {{ request()->routeIs('tester.projects.*') ? 'active' : '' }}">
                <span class="sidebar-icon">▦</span>
                <span>My Assigned Projects</span>
            </a>
        @endrole

        @role('admin')
        <a href="{{ route('projects.index') }}"
            class="sidebar-link {{ request()->routeIs('projects.*') ? 'active' : '' }}">
            <span class="sidebar-icon">▢</span>
            <span>Projects</span>
        </a>
        @endrole

        <a href="{{ route('feedback.index') }}"
            class="sidebar-link {{ request()->routeIs('feedback.*') ? 'active' : '' }}">
            <span class="sidebar-icon">▢</span>
            <span>Feedback Responses</span>
        </a>

        @role('admin')
        <a href="{{ route('analysis.index') }}"
            class="sidebar-link {{ request()->routeIs('analysis.*') ? 'active' : '' }}">
            <span class="sidebar-icon">✧</span>
            <span>AI Analysis</span>
        </a>
        @endrole

        @role('admin')
        {{-- User Management --}}
        <a href="{{ route('users.index') }}"
        class="sidebar-link {{ request()->routeIs('users.*') ? 'active' : '' }}">
            <span class="sidebar-icon">♙</span>
            <span>User Management</span>
        </a>
        @endrole

        {{-- <a href="{{ url('/reports') }}" class="sidebar-link">
            <span class="sidebar-icon">▥</span>
            <span>Reports</span>
        </a> --}}

        <a href="{{ route('settings.index') }}"
        class="sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
            <span class="sidebar-icon">⚙</span>
            <span>Settings</span>
        </a>

    </nav>

    {{-- Help --}}
<div class="sidebar-help">
    <a href="#">Help &amp; resources ↗</a>
</div>

{{-- Logout --}}
<div class="sidebar-logout">
    <form method="POST" action="{{ route('logout') }}">
        @csrf

        <button type="submit" class="sidebar-link logout-button">
            <span class="sidebar-icon">⇥</span>
            <span>Log Out</span>
        </button>
    </form>
</div>
</aside>
