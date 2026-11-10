
<x-app-layout>

    @php
        $isTester = Auth::user()->hasRole('tester');

        $collectingProducts = $products->where('status', 'collecting')->count();

        $pendingFeedback = $totalFeedback - $analyzedFeedback;

        $positive = $sentimentCounts->get('positive', 0);
        $neutral = $sentimentCounts->get('neutral', 0);
        $negative = $sentimentCounts->get('negative', 0);

        $positivePercent = $analyzedFeedback > 0
            ? round(($positive / $analyzedFeedback) * 100, 1)
            : 0;

        $neutralPercent = $analyzedFeedback > 0
            ? round(($neutral / $analyzedFeedback) * 100, 1)
            : 0;

        $negativePercent = $analyzedFeedback > 0
            ? round(($negative / $analyzedFeedback) * 100, 1)
            : 0;

        $positiveEnd = $positivePercent;
        $neutralEnd = $positiveEnd + $neutralPercent;
        $negativeEnd = $neutralEnd + $negativePercent;

        $chartStyle = $analyzedFeedback > 0
            ? "conic-gradient(#16a34a 0% {$positiveEnd}%, #f59e0b {$positiveEnd}% {$neutralEnd}%, #ef4444 {$neutralEnd}% {$negativeEnd}%, #e5e7eb {$negativeEnd}% 100%)"
            : "conic-gradient(#e5e7eb 0% 100%)";
    @endphp

    <!-- Dashboard Heading -->
    <section class="dashboard-heading">
        <div class="dashboard-welcome">
            <h1>Hello, {{ Auth::user()->name }}!</h1>
            <p>
                {{ $isTester
                    ? 'Your assigned products and feedback activity.'
                    : 'Your testing pulse. Clearer feedback, more confident launches.' }}
            </p>
        </div>

        @if (!$isTester)
            <a href="{{ route('products.create') }}" class="sentra-primary-button">
                <span>+</span>
                Create New Product
            </a>
        @endif
    </section>

    <!-- Workspace Overview -->
    <section class="workspace-overview">
        <div class="overview-heading">
            <h2>
                ▣ &nbsp; {{ $isTester ? 'My Testing Overview' : 'Workspace overview' }}
            </h2>
            <span>All time ⌄</span>
        </div>
    </section>

    <!-- Statistics Cards -->
    <section class="dashboard-stats">

        <div class="stat-card">
            <p>Total products</p>
            <h2>{{ number_format($totalProducts) }}</h2>
            <span>{{ $collectingProducts }} actively collecting</span>
        </div>

        <div class="stat-card">
            <p>Feedback responses</p>
            <h2>{{ number_format($totalFeedback) }}</h2>
            <span>Across your testing products</span>
        </div>

        <div class="stat-card">
            <p>Analyzed responses</p>
            <h2>{{ number_format($analyzedFeedback) }}</h2>
            <span>{{ number_format($pendingFeedback) }} pending analysis</span>
        </div>

        <div class="stat-card">
            <p>Overall sentiment</p>
            <h2>{{ $positivePercent }}%</h2>
            <span>Positive · of analyzed responses</span>
        </div>

    </section>

    <!-- Analytics and AI Insights -->
    <section class="dashboard-middle">

        <!-- Sentiment Overview -->
        <div class="sentiment-card">

            <div class="card-heading">
                <h2>Sentiment at a glance</h2>
                <p>
                    {{ $isTester ? 'My feedback' : 'All products' }}
                    · {{ number_format($analyzedFeedback) }} analyzed responses
                </p>
            </div>

            <div class="sentiment-content">

                <div class="sentiment-chart">
                    <div class="donut-chart" style="background: {{ $chartStyle }};">
                        <div class="donut-center">
                            <h3>{{ number_format($analyzedFeedback) }}</h3>
                            <span>analyzed</span>
                        </div>
                    </div>
                </div>

                <div class="sentiment-legend">

                    <div class="legend-item">
                        <span class="legend-dot positive"></span>
                        <span>Positive</span>
                        <strong>{{ number_format($positive) }} · {{ $positivePercent }}%</strong>
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot neutral"></span>
                        <span>Neutral</span>
                        <strong>{{ number_format($neutral) }} · {{ $neutralPercent }}%</strong>
                    </div>

                    <div class="legend-item">
                        <span class="legend-dot negative"></span>
                        <span>Negative</span>
                        <strong>{{ number_format($negative) }} · {{ $negativePercent }}%</strong>
                    </div>

                </div>

            </div>

            <div class="sentiment-footer">
                ◷ &nbsp; {{ number_format($pendingFeedback) }} responses pending · not included in sentiment
            </div>

        </div>

        <!-- AI Insights -->
        <div class="insights-card">

            <div class="insights-header">
                <div>
                    <h2>Recent AI insights</h2>
                    <span>AI-generated summaries</span>
                </div>
            </div>

            @forelse ($recentInsights as $insight)
                <div class="insight-item">
                    <span class="insight-icon insight-neutral">✦</span>

                    <div>
                        <h3>{{ $insight->product->name }}</h3>

                        <p>
                            {{ \Illuminate\Support\Str::limit($insight->summary, 180) }}
                        </p>

                        <small>
                            Generated {{ $insight->created_at->format('M d, Y') }}
                        </small>
                    </div>
                </div>
            @empty
                <div class="insight-item">
                    <span class="insight-icon insight-neutral">✦</span>

                    <div>
                        <h3>No AI insights yet</h3>
                        <p>
                            Generated product summaries will appear here
                            once feedback analysis is completed.
                        </p>
                    </div>
                </div>
            @endforelse

        </div>

    </section>

    <!-- Recent Testing Products -->
    <section class="recent-products-card">

        <div class="projects-header">
            <div>
                <h2>Recent testing products</h2>
                <p>Private testing, before your next release.</p>
            </div>

            @if ($isTester)
                <a href="{{ route('tester.products.index') }}">View all products →</a>
            @else
                <a href="{{ route('products.index') }}">View all products →</a>
            @endif
        </div>

        <div class="projects-table-wrapper">
            <table class="projects-table">

                <thead>
                    <tr>
                        <th>PRODUCT</th>
                        <th>STATUS</th>
                        <th>RESPONSES</th>
                        <th>CREATED</th>
                        <th></th>
                    </tr>
                </thead>

                <tbody>

                    @forelse ($products->take(5) as $product)
                        <tr>
                            <td>
                                <div class="project-info">
                                    <div class="project-icon">◉</div>
                                    <div>
                                        <strong>{{ $product->name }}</strong>
                                        <span>{{ $product->category }}</span>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="project-status">
                                    {{ ucfirst($product->status) }}
                                </span>
                            </td>

                            <td>
                                <strong>{{ number_format($product->feedback_count) }}</strong>
                            </td>

                            <td>{{ $product->created_at->format('M d, Y') }}</td>

                            <td>
                                @if ($isTester)
                                    <a href="{{ route('tester.products.show', $product->id) }}">↗</a>
                                @else
                                    <a href="{{ route('products.show', $product) }}">↗</a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px;">
                                {{ $isTester
                                ? 'No products have been assigned to you yet.'
                                : 'No products yet. Create your first testing product!' }}
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </section>

    <!-- Dashboard Disclaimer -->
    <footer class="dashboard-disclaimer">
        Sentiment results are AI-generated and should be reviewed against original feedback.
    </footer>

</x-app-layout>
