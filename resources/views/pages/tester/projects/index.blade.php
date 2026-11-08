
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTER WORKSPACE</span>
            <h1>My Assigned Projects</h1>
            <p>View the projects assigned to you and share your feedback.</p>
        </div>
    </div>

    <div class="settings-card user-management-card">
        <div class="user-table-header">
            <div>
                <h2>Your Projects</h2>
                <p>Projects assigned to your Tester account.</p>
            </div>

            <span>{{ $projects->count() }} Projects</span>
        </div>

        @if ($projects->isEmpty())
            <div class="empty-state">
                <h3>No Assigned Projects Yet</h3>
                <p>
                    You don't have any assigned projects.
                    Please contact your Administrator.
                </p>
            </div>
        @else
            <div class="project-list">
                @foreach ($projects as $project)
                    <div class="settings-card project-item-card">
                        <div>
                            <span class="page-eyebrow">
                                {{ $project->category }}
                            </span>

                            <h3>{{ $project->name }}</h3>

                            <p>
                                {{ $project->description ?: 'No project description available.' }}
                            </p>

                           <div class="project-item-meta">
                                <span>
                                    {{ $project->feedback_count }} Feedback Responses
                                </span>

                                <span class="status-active">
                                    {{ ucfirst($project->status) }}
                                </span>

                                <span>
                                    **My Feedback:**

                                    @if ($project->status !== 'collecting')
                                        <span class="status-closed">Closed</span>
                                    @elseif ($project->has_my_feedback)
                                        <span class="status-submitted">Submitted</span>
                                    @else
                                        <span class="status-pending">Pending</span>
                                    @endif
                                </span>
                            </div>
                        </div>

                        <a
                            href="{{ route('tester.projects.show', $project->id) }}"
                            class="primary-button"
                        >
                            View Project
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-app-layout>
