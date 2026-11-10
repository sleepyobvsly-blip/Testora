
@php
    $user = auth()->user();

    $initials = collect(explode(' ', trim($user->name)))
        ->filter()
        ->take(2)
        ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
        ->implode('');

    $displayName = $user->name;
@endphp

<header class="sentra-topbar">

    <!-- Search -->
    {{-- <div class="topbar-search">
        <span class="search-icon">⌕</span>
        <input
            type="text"
            placeholder="Search projects, feedback..."
            aria-label="Search projects and feedback"
        >
    </div> --}}

    <!-- Right side -->
    <div class="topbar-right">

        <span class="workspace-label">
            Personal workspace
        </span>

        <button
            type="button"
            class="notification-button"
            aria-label="Notifications"
        >
            ♧
        </button>

        <div class="user-avatar">
            {{ $initials ?: 'U' }}
        </div>

        <span class="user-name">
            {{ $displayName }}
        </span>

    </div>

</header>
