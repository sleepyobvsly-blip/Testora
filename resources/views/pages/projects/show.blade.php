<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Project Details</h1>
            <p>View information about your testing project.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="back-link">
            ← Back to Projects
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>{{ $project->name }}</h2>
                <p>{{ $project->category }}</p>
            </div>

            <span class="status-{{ $project->status }}">
                {{ ucfirst($project->status) }}
            </span>
        </div>

        <div class="project-information">
            <div class="information-item">
                <label>Project Name</label>
                <p>{{ $project->name }}</p>
            </div>

            <div class="information-item">
                <label>Category</label>
                <p>{{ $project->category }}</p>
            </div>

            <div class="information-item">
                <label>Description</label>
                <p>{{ $project->description ?: 'No description provided.' }}</p>
            </div>

            <div class="information-item">
                <label>Status</label>
                <p>{{ ucfirst($project->status) }}</p>
            </div>

            <div class="information-item">
                <label>Date Created</label>
                <p>{{ $project->created_at->format('F d, Y') }}</p>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('projects.edit', $project) }}" class="primary-button">
                Edit Project
            </a>
            
            <form action="{{ route('projects.destroy', $project) }}" method="POST"
                onsubmit="return confirm('Are you sure you want to delete this project?');">
                @csrf
                @method('DELETE')

                <button type="submit" class="delete-button">
                    Delete Project
                </button>
            </form>
        </div>
    </section>
</x-app-layout>