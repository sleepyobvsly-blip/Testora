<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <span class="page-eyebrow">TESTORA ADMINISTRATION</span>
            <h1>User Management</h1>
            <p>Create and manage Tester accounts and their product assignments.</p>
        </div>

        <a href="{{ route('users.create') }}" class="sentra-primary-button">
            + Create Tester Account
        </a>
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    
    @if (session('temporary_credentials'))
        @php
            $credentials = session('temporary_credentials');

            $copyText = "TESTORA - TESTER ACCOUNT\n\n"
                . "Name: {$credentials['name']}\n"
                . "Email: {$credentials['email']}\n"
                . "Temporary Password: {$credentials['password']}\n\n"
                . "Please log in and change your temporary password.";
        @endphp

        <div class="credentials-card">
            <h2>Tester Account Created Successfully!</h2>
            <p>Share these temporary login credentials with the Tester.</p>

            <div>
                <strong>Name:</strong> {{ $credentials['name'] }}
            </div>

            <div>
                <strong>Email:</strong> {{ $credentials['email'] }}
            </div>

            <div>
                <strong>Temporary Password:</strong>
                <code>{{ $credentials['password'] }}</code>
            </div>

            <button
                type="button"
                class="primary-button"
                style="margin-top: 18px;"
                onclick="copyTesterCredentials(this)"
                data-copy-text="{{ $copyText }}"
            >
                Copy Credentials
            </button>

            <p class="credentials-warning">
                Copy these credentials now. The temporary password
                will not be displayed again after leaving or refreshing this page.
            </p>
        </div>

        <script>
            async function copyTesterCredentials(button) {
                try {
                    await navigator.clipboard.writeText(
                        button.dataset.copyText
                    );

                    button.textContent = 'Copied!';
                } catch (error) {
                    alert('Unable to copy credentials. Please copy them manually.');
                }
            }
        </script>
    @endif


    <div class="settings-card user-management-card">

        <div class="user-table-header">
            <div>
                <h2>Tester Accounts</h2>
                <p>Manage your registered testing participants.</p>
            </div>

            <span>{{ $users->count() }} Testers</span>
        </div>

        @if ($users->isEmpty())

            <div class="empty-state">
                <h3>No Tester Accounts Yet</h3>
                <p>Create your first Tester account to get started.</p>
            </div>

        @else

            <div class="table-responsive">
                <table class="users-table">
                    <thead>
                        <tr>
                            <th>Tester</th>
                            <th>Assigned Products</th>
                            <th>Account Status</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($users as $user)
                            <tr>
                                <td>
                                    <strong>{{ $user->name }}</strong>
                                    <small>{{ $user->email }}</small>
                                </td>

                                <td>
                                    @forelse ($user->assignedProducts as $product)
                                        <span class="project-tag">
                                            {{ $product->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted">
                                            No products assigned
                                        </span>
                                    @endforelse
                                </td>

                                <td>
                                    @if ($user->is_active)
                                        <span class="status-active">Active</span>
                                    @else
                                        <span class="status-inactive">Inactive</span>
                                    @endif
                                </td>

                                <td>
                                    {{ $user->created_at->format('M d, Y') }}
                                </td>
                                <td>
                                    <a
                                        href="{{ route('users.assignments', $user) }}"
                                        class="view-project-link"
                                    >
                                        Manage Assignments →
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>
</x-app-layout>