<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTORA ADMINISTRATION</span>
            <h1>Create Tester Account</h1>
            <p>Create a login account and assign testing projects.</p>
        </div>
    </div>

    <div class="settings-card user-form-card">

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-section">
                <h2>Tester Information</h2>
                <p>Enter the Tester's personal and account details.</p>

                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="Enter full name"
                        required
                    >
                    @error('name')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="Enter email address"
                        required
                    >
                    @error('email')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <div class="form-section">
                <h2>Project Assignment</h2>
                <p>Select the testing projects this Tester will participate in.</p>

                @error('project_ids')
                    <span class="field-error">{{ $message }}</span>
                @enderror

                @if ($projects->isEmpty())
                    <p class="text-muted">
                        You don't have any projects available for assignment yet.
                    </p>
                @else
                    <div class="project-assignment-list">
                        @foreach ($projects as $project)
                            <label class="project-assignment-option">
                                <input
                                    type="checkbox"
                                    name="project_ids[]"
                                    value="{{ $project->id }}"
                                    {{ in_array($project->id, old('project_ids', [])) ? 'checked' : '' }}
                                >

                                <span>
                                    <strong>{{ $project->name }}</strong>
                                    <small>{{ $project->category }} · {{ ucfirst($project->status) }}</small>
                                </span>
                            </label>
                        @endforeach
                    </div>

                    @error('project_ids.*')
                        <span class="field-error">{{ $message }}</span>
                    @enderror
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('users.index') }}" class="secondary-button">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="primary-button"
                    {{ $projects->isEmpty() ? 'disabled' : '' }}
                >
                    Create Tester Account
                </button>
            </div>
        </form>

    </div>
</x-app-layout>