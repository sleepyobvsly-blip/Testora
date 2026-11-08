<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Create New Project</h1>
            <p>Set up a product or service testing project.</p>
        </div>

        <a href="{{ route('projects.index') }}" class="back-link">
            ← Back to Projects
        </a>
    </div>

    <section class="projects-section create-project-section">
        <div class="section-heading">
            <div>
                <h2>Project Information</h2>
                <p>Enter the basic details of your project.</p>
            </div>
        </div>

        <form action="{{ route('projects.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Project Name</label>
                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Sentra Mobile App Testing"
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
                    value="{{ old('category') }}"
                    placeholder="e.g. Mobile Application"
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
                    placeholder="Describe the product or service being tested..."
                >{{ old('description') }}</textarea>
                @error('description')
                    <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('projects.index') }}" class="cancel-button">
                    Cancel
                </a>

                <button type="submit" class="primary-button">
                    Create Project
                </button>
            </div>
        </form>
    </section>
</x-app-layout>