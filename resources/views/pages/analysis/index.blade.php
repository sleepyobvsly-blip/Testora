
<x-app-layout>
    <div class="page-header">
        <div>
            <span class="page-eyebrow">TESTORA INTELLIGENCE</span>
            <h1>AI Analysis</h1>
            <p>Generate AI-powered summaries of your collected feedback.</p>
        </div>
    </div>

    {{-- Success message --}}
    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    {{-- Error message --}}
    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    {{-- Project selection card --}}
    <div class="analysis-card">
        <div class="analysis-card-header">
            <div>
                <h2>Select a testing project</h2>
                <p>Choose a project to analyze its collected feedback.</p>
            </div>

            <div class="analysis-icon">✦</div>
        </div>

        @if ($projects->isEmpty())

            <div class="empty-state">
                <h3>No projects found</h3>
                <p>Create a project first before generating an AI analysis.</p>

                <a href="{{ route('projects.create') }}" class="primary-button">
                    Create Project
                </a>
            </div>

        @else

            <form id="analysisForm" method="POST">
                @csrf

                <div class="form-group">
                    <label for="project_id">Testing Project</label>

                    <select
                        id="project_id"
                        name="project_id"
                        required
                        onchange="window.location.href='{{ route('analysis.index') }}?project_id=' + this.value"
                    >
                        <option value="">Choose a project</option>

                        @foreach ($projects as $project)
                            <option
                                value="{{ $project->id }}"
                                {{ $selectedProject && $selectedProject->id === $project->id ? 'selected' : '' }}
                            >
                                {{ $project->name }}
                                ({{ $project->feedback_count }} feedback)
                            </option>
                        @endforeach

                    </select>
                </div>

                <div class="analysis-notice">
                    <strong>Before you analyze</strong>

                    <p>
                        At least two feedback responses with sentiment labels
                        are required to generate a summary.
                    </p>
                </div>

                <button
                    type="submit"
                    id="analyzeButton"
                    class="primary-button"
                    disabled
                >
                    ✦ Analyze Feedback
                </button>
            </form>

        @endif

            {{-- Sentiment breakdown --}}
        @if ($selectedProject)

            <div class="analysis-stats-grid">

                <div class="analysis-stat-card positive">
                    <span class="analysis-stat-label">Positive Feedback</span>
                    <h2>{{ $sentimentCounts['positive'] }}</h2>
                    <p>{{ $sentimentPercentages['positive'] }}% of analyzed feedback</p>
                </div>

                <div class="analysis-stat-card neutral">
                    <span class="analysis-stat-label">Neutral Feedback</span>
                    <h2>{{ $sentimentCounts['neutral'] }}</h2>
                    <p>{{ $sentimentPercentages['neutral'] }}% of analyzed feedback</p>
                </div>

                <div class="analysis-stat-card negative">
                    <span class="analysis-stat-label">Negative Feedback</span>
                    <h2>{{ $sentimentCounts['negative'] }}</h2>
                    <p>{{ $sentimentPercentages['negative'] }}% of analyzed feedback</p>
                </div>

            </div>

        @endif

        {{-- Sentiment Distribution Chart --}}
        @if ($selectedProject)

            <div class="analysis-chart-card">
                <div class="analysis-chart-header">
                    <div>
                        <h2>Sentiment Distribution</h2>
                        <p>
                            Feedback sentiment for
                            {{ $selectedProject->name }}
                        </p>
                    </div>
                </div>

                <div class="analysis-chart-container">
                    <canvas
                        id="sentimentChart"
                        data-positive="{{ $sentimentCounts['positive'] }}"
                        data-neutral="{{ $sentimentCounts['neutral'] }}"
                        data-negative="{{ $sentimentCounts['negative'] }}"
                    ></canvas>
                </div>
            </div>

        @endif

        {{-- AI-generated summary --}}
        @if ($latestAnalysis)

            <div class="analysis-result-card">

                <div class="analysis-result-header">
                    <div>
                        <span class="page-eyebrow">GENERATED INSIGHT</span>

                        <h2>AI-Generated Summary</h2>

                        <p>
                            {{ $latestAnalysis->project->name }}
                        </p>
                    </div>

                    <span class="analysis-result-icon">✦</span>
                </div>

                <div class="analysis-result-content">
                    {{ $latestAnalysis->summary }}
                </div>

                <div class="analysis-result-footer">
                    <span>
                        Based on {{ $latestAnalysis->total_feedback }}
                        feedback responses
                    </span>

                    <span>
                        {{ $latestAnalysis->created_at->format('M d, Y h:i A') }}
                    </span>
                </div>

            </div>

        @endif

    </div>
</x-app-layout>



<script>
    const projectSelect = document.getElementById('project_id');
    const analysisForm = document.getElementById('analysisForm');
    const analyzeButton = document.getElementById('analyzeButton');

    // Project selection and analysis button
    if (projectSelect && analysisForm && analyzeButton) {

        analyzeButton.disabled = !projectSelect.value;

        projectSelect.addEventListener('change', function () {
            analyzeButton.disabled = !this.value;
        });

        analysisForm.addEventListener('submit', function () {
            this.action = `/analysis/${projectSelect.value}`;

            analyzeButton.disabled = true;
            analyzeButton.textContent = 'Analyzing feedback...';
        });
    }
</script>


