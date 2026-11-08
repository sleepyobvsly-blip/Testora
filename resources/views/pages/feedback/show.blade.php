<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Feedback Details</h1>
            <p>Review an individual feedback response.</p>
        </div>

        <a href="{{ route('feedback.index') }}" class="back-link">
            ← Back to Feedback
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>{{ $feedback->project->name }}</h2>
                <p>{{ $feedback->project->category }}</p>
            </div>

            <span class="status-draft">
                {{ $feedback->sentiment ? ucfirst($feedback->sentiment) : 'Pending Analysis' }}
            </span>
        </div>

        <div class="project-information">
            <div class="information-item">
                <label>Project</label>
                <p>{{ $feedback->project->name }}</p>
            </div>

            <div class="information-item">
                <label>Date Submitted</label>
                <p>{{ $feedback->created_at->format('F d, Y h:i A') }}</p>
            </div>
        </div>

        <div class="feedback-content">
            <label>Feedback Response</label>
            <p>{{ $feedback->feedback_text }}</p>
        </div>

        <div class="form-actions">
            <a href="{{ route('feedback.edit', $feedback) }}" class="primary-button">
                Edit Feedback
            </a>

            <form action="{{ route('feedback.destroy', $feedback) }}"
                method="POST"
                onsubmit="return confirm('Are you sure you want to delete this feedback?');">

                @csrf
                @method('DELETE')

                <button type="submit" class="delete-button">
                    Delete Feedback
                </button>
            </form>
        </div>
    </section>
</x-app-layout>