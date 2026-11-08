
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTER WORKSPACE</span>
            <h1>{{ $project->name }}</h1>
            <p>Review the project details before submitting your feedback.</p>
        </div>

        <a href="{{ route('tester.projects.index') }}" class="secondary-button">
            Back to Projects
        </a>
    </div>

    <div class="settings-card">
        <div class="form-section">
            <span class="page-eyebrow">PROJECT INFORMATION</span>

            <h2>{{ $project->name }}</h2>

            <p>{{ $project->description ?: 'No project description available.' }}</p>
        </div>

        <div class="project-item-meta">
            <div>
                <strong>Category</strong>
                <p>{{ $project->category }}</p>
            </div>

            <div>
                <strong>Project Status</strong>
                <p>{{ ucfirst($project->status) }}</p>
            </div>

            <div>
                <strong>Feedback Responses</strong>
                <p>{{ $project->feedback_count }}</p>
            </div>
        </div>

        <div class="form-actions" style="margin-top: 25px;">

            @if ($myFeedback)
                <a href="{{ route('feedback.edit', $myFeedback) }}" class="btn-primary">
                    Edit My Feedback
                </a>

            @elseif ($project->status === 'collecting')
                <a href="{{ route('feedback.create', ['project_id' => $project->id]) }}" class="btn-primary">
                    Submit Feedback
                </a>

            @else
                <span class="text-muted">
                    Feedback submission is closed.
                </span>
            @endif

        </div>
    </div>
</x-app-layout>
