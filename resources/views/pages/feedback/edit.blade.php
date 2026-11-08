<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Edit Feedback</h1>
            <p>Update an existing feedback response.</p>
        </div>

        <a href="{{ route('feedback.show', $feedback) }}" class="back-link">
            ← Back to Feedback
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>{{ $feedback->project->name }}</h2>
                <p>Modify the submitted feedback below.</p>
            </div>
        </div>

        <form action="{{ route('feedback.update', $feedback) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Project</label>
                <input
                    type="text"
                    value="{{ $feedback->project->name }}"
                    disabled
                >
            </div>

            <div class="form-group">
                <label for="feedback_text">Feedback Response</label>

                <textarea
                    id="feedback_text"
                    name="feedback_text"
                    rows="7"
                    required
                >{{ old('feedback_text', $feedback->feedback_text) }}</textarea>

                @error('feedback_text')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('feedback.show', $feedback) }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="primary-button">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
</x-app-layout>