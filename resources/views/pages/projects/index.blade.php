<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Projects</h1>
            <p>Manage your product testing and feedback collection projects.</p>
        </div>

        <a href="{{ route('projects.create') }}" class="primary-button">
            + Create New Project
        </a>
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <section class="projects-section">
        <div class="section-heading">
            <div>
                <h2>All Projects</h2>
                <p>View and manage your testing projects.</p>
            </div>

            <span class="project-count">
                {{ $projects->count() }} Projects
            </span>
        </div>

        @forelse ($projects as $project)
            <div class="project-row">
                <div class="project-details">
                    <h3>{{ $project->name }}</h3>
                    <p>{{ $project->category }}</p>

                    @if ($project->description)
                        <p>{{ $project->description }}</p>
                    @endif
                </div>

                <div class="project-status">
                    <span class="status-{{ $project->status }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>

                <div class="project-date">
                    {{ $project->created_at->format('M d, Y') }}
                </div>

                <a href="{{ route('projects.show', $project) }}"
                   class="view-project-link">
                    View project →
                </a>
            </div>
        @empty
            <div class="empty-projects">
                <h3>No projects yet</h3>
                <p>Create your first project to start organizing feedback.</p>

                <a href="{{ route('projects.create') }}" class="primary-button">
                    Create Your First Project
                </a>
            </div>
        @endforelse
    </section>
</x-app-layout>