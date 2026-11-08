<x-app-layout>
    <div class="dashboard-heading">
        <div>
            <h1>Feedback Responses</h1>
            <p>
                {{ Auth::user()->hasRole('tester')
                    ? 'Review and manage your submitted feedback.'
                    : 'Review feedback collected from your testing projects.' }}
            </p>
        </div>

        @if (Auth::user()->hasRole('tester'))
            <a href="{{ route('feedback.create') }}" class="primary-button">
                + Submit Feedback
            </a>
        @endif
    </div>

    @if (session('success'))
        <div class="success-message">
            {{ session('success') }}
        </div>
    @endif

    <section class="projects-section">
        <div class="section-heading">
            <div>
                <h2>All Feedback</h2>
                <p>View the responses submitted to your projects.</p>
            </div>

            <span class="project-count">
                {{ $feedback->count() }} Responses
            </span>
        </div>

        @forelse ($feedback as $item)
            <div class="project-row">
                <div class="project-details">
                    <h3>{{ $item->project->name }}</h3>

                    <p>
                        {{ \Illuminate\Support\Str::limit($item->feedback_text, 100) }}
                    </p>

                    <p>
                        Submitted {{ $item->created_at->format('M d, Y') }}
                    </p>
                </div>

                
                <div class="project-status">
                    @if ($item->sentiment)
                        @php
                            $sentiment = strtolower(trim($item->sentiment));

                            $sentimentClass = match ($sentiment) {
                                'positive' => 'status-positive',
                                'neutral' => 'status-neutral',
                                'negative' => 'status-negative',
                                default => 'status-draft',
                            };
                        @endphp

                        <span class="{{ $sentimentClass }}">
                            {{ ucfirst($sentiment) }}
                        </span>
                    @else
                        <span class="status-draft">
                            Pending Analysis
                        </span>
                    @endif
                </div>


                <div>
                    <a href="{{ route('feedback.show', $item) }}"
                    class="view-project-link">
                        View →
                    </a>

                    <a href="{{ route('feedback.edit', $item) }}"
                    class="view-project-link">
                        Edit →
                    </a>
                </div>
            </div>
        @empty
            <div class="empty-projects">
                <h3>No feedback responses yet</h3>
                <p>Feedback submitted to your testing projects will appear here.</p>
            </div>
        @endforelse
    </section>
</x-app-layout>