
<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Manage Project Assignments</h1>
            <p>Update the projects assigned to {{ $user->name }}.</p>
        </div>

        <a href="{{ route('users.index') }}" class="secondary-button">
            ← Back to Users
        </a>
    </div>

    <section class="projects-section">
        <div class="section-heading">
            <div>
                <h2>Available Projects</h2>
                <p>Select the projects this Tester should have access to.</p>
            </div>
        </div>

        <form action="{{ route('users.assignments.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            @if ($errors->any())
                <div class="error-message">
                    Please check your project selections.
                </div>
            @endif

            <div class="assignment-list">
                @forelse ($projects as $project)
                    <label class="assignment-item">
                        <input
                            type="checkbox"
                            name="project_ids[]"
                            value="{{ $project->id }}"
                            {{ in_array($project->id, old('project_ids', $assignedProjectIds)) ? 'checked' : '' }}
                        >

                        <div>
                            <strong>{{ $project->name }}</strong>
                            <p>{{ $project->category }}</p>
                        </div>
                    </label>
                @empty
                    <p>No projects are available. Create a project first.</p>
                @endforelse
            </div>

            @error('project_ids')
                <p class="error-text">{{ $message }}</p>
            @enderror

            <button type="submit" class="primary-button">
                Save Assignments
            </button>
        </form>
    </section>
</x-app-layout>
