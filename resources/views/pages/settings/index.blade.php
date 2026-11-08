
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">SENTRA PREFERENCES</span>
            <h1>Settings</h1>
            <p>Manage your workspace preferences and account settings.</p>
        </div>
    </div>

    <div class="settings-grid">

        {{-- Profile Settings --}}
        <div class="settings-card">
            <div class="settings-card-icon">♙</div>
            <div>
                <h2>Profile Settings</h2>
                <p>Manage your personal information and account details.</p>
            </div>
            <a href="{{ route('profile.edit') }}#profile-information" class="settings-link">
                Manage Profile →
            </a>
        </div>

        {{-- Password and Security --}}
        <div class="settings-card">
            <div class="settings-card-icon">♧</div>
            <div>
                <h2>Password & Security</h2>
                <p>Update your password and keep your account secure.</p>
            </div>
            <a href="{{ route('profile.edit') }}#password-security" class="settings-link">
                Manage Security →
            </a>
        </div>

        {{-- Workspace Settings --}}
        <div class="settings-card">
            <div class="settings-card-icon">⚙</div>
            <div>
                <h2>Workspace Settings</h2>
                <p>Manage your Sentra workspace preferences.</p>
            </div>
            <span class="settings-status">Coming soon</span>
        </div>

    </div>
</x-app-layout>
