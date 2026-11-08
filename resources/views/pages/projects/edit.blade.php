<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Edit Project</h1>
            <p>Update your project information.</p>
        </div>

        <a href="{{ route('projects.show', $project) }}" class="back-link">
            ← Back to Project
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Project Information</h2>
                <p>Modify the details of your testing project.</p>
            </div>
        </div>

        <form action="{{ route('projects.update', $project) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Project Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $project->name) }}"
                    required
                >
                @error('name')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="category">Project Category</label>
                <input
                    type="text"
                    id="category"
                    name="category"
                    value="{{ old('category', $project->category) }}"
                    required
                >
                @error('category')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description">Project Description</label>
                <textarea
                    id="description"
                    name="description"
                    rows="5"
                >{{ old('description', $project->description) }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="status">Project Status</label>
                <select id="status" name="status" required>
                    <option value="draft" {{ old('status', $project->status) === 'draft' ? 'selected' : '' }}>
                        Draft
                    </option>
                    <option value="collecting" {{ old('status', $project->status) === 'collecting' ? 'selected' : '' }}>
                        Collecting
                    </option>
                    <option value="completed" {{ old('status', $project->status) === 'completed' ? 'selected' : '' }}>
                        Completed
                    </option>
                </select>
                @error('status')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('projects.show', $project) }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="primary-button">
                    Save Changes
                </button>
            </div>
        </form>
    </section>
</x-app-layout>