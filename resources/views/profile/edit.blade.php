
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTORA ACCOUNT</span>
            <h1>Profile Settings</h1>
            <p>Manage your personal information and account security.</p>
        </div>
    </div>

    <div class="profile-settings-container">

        <div class="profile-settings-card" id="profile-information">
            <div class="profile-settings-heading">
                <h2>Personal Information</h2>
                <p>Update your name and email address.</p>
            </div>

            @include('profile.partials.update-profile-information-form')
        </div>

        <div class="profile-settings-card" id="password-security">
            <div class="profile-settings-heading">
                <h2>Password & Security</h2>
                <p>Keep your account secure by updating your password.</p>
            </div>

            @include('profile.partials.update-password-form')
        </div>

        <div class="profile-settings-card danger-card">
            <div class="profile-settings-heading">
                <h2>Delete Account</h2>
                <p>Permanently delete your account and associated data.</p>
            </div>

            @include('profile.partials.delete-user-form')
        </div>

        <a href="{{ route('settings.index') }}" class="settings-back-link">
            ← Back to Settings
        </a>

    </div>
</x-app-layout>
