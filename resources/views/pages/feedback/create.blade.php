<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Submit Feedback</h1>
            <p>Record feedback about a product or service being tested.</p>
        </div>

        <a href="{{ route('feedback.index') }}" class="back-link">
            ← Back to Feedback
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Feedback Information</h2>
                <p>Select a project and enter the feedback response.</p>
            </div>
        </div>

        @if ($projects->isEmpty())
            <div class="empty-projects">
                <h3>No active projects available</h3>
                <p>You need a project with Collecting status before submitting feedback.</p>

                <a href="{{ route('projects.index') }}" class="primary-button">
                    View Projects
                </a>
            </div>
        @else
            <form action="{{ route('feedback.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="project_id">Select Project</label>

                    <select id="project_id" name="project_id" required>
                        <option value="">Choose a project</option>

                        @foreach ($projects as $project)
                            <option
                                value="{{ $project->id }}"
                                {{ old('project_id') == $project->id ? 'selected' : '' }}
                            >
                                {{ $project->name }}
                            </option>
                        @endforeach
                    </select>

                    @error('project_id')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="feedback_text">Feedback Response</label>

                    <textarea
                        id="feedback_text"
                        name="feedback_text"
                        rows="7"
                        placeholder="Write the customer's feedback here..."
                        required
                    >{{ old('feedback_text') }}</textarea>

                    @error('feedback_text')
                        <p class="form-error">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form-actions">
                    <a href="{{ route('feedback.index') }}" class="cancel-button">
                        Cancel
                    </a>

                    <button type="submit" class="primary-button">
                        Submit Feedback
                    </button>
                </div>
            </form>
        @endif
    </section>
</x-app-layout>