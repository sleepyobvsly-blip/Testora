
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
                <h2>Select a testing product</h2>
                <p>Choose a product to analyze its collected feedback.</p>
            </div>

            <div class="analysis-icon">✦</div>
        </div>

        @if ($products->isEmpty())

            <div class="empty-state">
                <h3>No products found</h3>
                <p>Create a product first before generating an AI analysis.</p>

                <a href="{{ route('products.create') }}" class="primary-button">
                    Create Product
                </a>
            </div>

        @else

            <form id="analysisForm" method="POST">
                @csrf

                <div class="form-group">
                    <label for="product_id">Testing Product</label>

                    <select
                        id="product_id"
                        name="product_id"
                        required
                        onchange="window.location.href='{{ route('analysis.index') }}?product_id=' + this.value"
                    >
                        <option value="">Choose a product</option>

                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                {{ $selectedProduct && $selectedProduct->id === $product->id ? 'selected' : '' }}
                            >
                                {{ $product->name }}
                                ({{ $product->feedback_count }} feedback)
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
        @if ($selectedProduct)

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
        @if ($selectedProduct)

            <div class="analysis-chart-card">
                <div class="analysis-chart-header">
                    <div>
                        <h2>Sentiment Distribution</h2>
                        <p>
                            Feedback sentiment for
                            {{ $selectedProduct->name }}
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
                            {{ $latestAnalysis->product->name }}
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
    const productSelect = document.getElementById('product_id');
    const analysisForm = document.getElementById('analysisForm');
    const analyzeButton = document.getElementById('analyzeButton');

    // Product selection and analysis button
    if (productSelect && analysisForm && analyzeButton) {

        analyzeButton.disabled = !productSelect.value;

        productSelect.addEventListener('change', function () {
            analyzeButton.disabled = !this.value;
        });

        analysisForm.addEventListener('submit', function () {
            this.action = `/analysis/${productSelect.value}`;

            analyzeButton.disabled = true;
            analyzeButton.textContent = 'Analyzing feedback...';
        });
    }
</script>


