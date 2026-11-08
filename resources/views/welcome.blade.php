
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Testora | Understand Your Customers</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Figtree', sans-serif;
            background: #faf9ff;
            color: #25213a;
        }

        a {
            text-decoration: none;
        }

        .navbar {
            height: 78px;
            padding: 0 8%;
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff;
            border-bottom: 1px solid #eeeaf7;
        }

        .brand {
            color: #7955dc;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: -1px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 32px;
        }

        .nav-links a {
            color: #625e72;
            font-size: 14px;
            font-weight: 600;
        }

        .nav-links a:hover {
            color: #7955dc;
        }

        .nav-actions {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .login-link {
            color: #625e72;
            font-size: 14px;
            font-weight: 600;
            padding: 11px 16px;
        }

        .primary-button {
            display: inline-block;
            background: #7955dc;
            color: #fff;
            padding: 13px 22px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
            transition: .2s;
        }

        .primary-button:hover {
            background: #6241c4;
            transform: translateY(-2px);
        }

        .hero {
            padding: 100px 8% 90px;
            display: grid;
            grid-template-columns: 1.05fr .95fr;
            align-items: center;
            gap: 55px;
        }

        .hero-label {
            display: inline-block;
            color: #7955dc;
            background: #f0ebff;
            padding: 9px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .hero h1 {
            font-size: clamp(40px, 5vw, 61px);
            line-height: 1.12;
            letter-spacing: -2px;
            margin-bottom: 22px;
            color: #25213a;
        }

        .hero h1 span {
            color: #7955dc;
        }

        .hero-description {
            color: #777287;
            font-size: 16px;
            line-height: 1.8;
            max-width: 520px;
            margin-bottom: 30px;
        }

        .hero-buttons {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .secondary-button {
            color: #7955dc;
            border: 1px solid #dcd3f5;
            padding: 12px 21px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 700;
        }

        .hero-visual {
            background: linear-gradient(145deg, #eee8ff, #f8f5ff);
            border-radius: 25px;
            padding: 30px;
            min-height: 350px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .preview-card {
            width: 100%;
            max-width: 390px;
            background: #fff;
            border: 1px solid #eeeaf7;
            border-radius: 17px;
            padding: 25px;
            box-shadow: 0 15px 45px rgba(66, 44, 125, .10);
        }

        .preview-heading {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 5px;
        }

        .preview-subtitle {
            color: #9993a9;
            font-size: 12px;
            margin-bottom: 25px;
        }

        .sentiment-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 17px 0 8px;
            font-size: 13px;
            font-weight: 600;
        }

        .sentiment-bar {
            height: 9px;
            background: #f0eef5;
            border-radius: 20px;
            overflow: hidden;
        }

        .sentiment-fill {
            height: 100%;
            border-radius: 20px;
        }

        .positive { background: #20a779; width: 75%; }
        .neutral { background: #e0a43b; width: 45%; }
        .negative { background: #e05b68; width: 25%; }

        .preview-note {
            background: #f7f4ff;
            border-radius: 11px;
            padding: 15px;
            margin-top: 24px;
        }

        .preview-note strong {
            display: block;
            color: #7955dc;
            font-size: 12px;
            margin-bottom: 6px;
        }

        .preview-note p {
            color: #777287;
            font-size: 12px;
            line-height: 1.6;
        }

        .section {
            padding: 85px 8%;
        }

        .section-heading {
            text-align: center;
            max-width: 650px;
            margin: 0 auto 45px;
        }

        .section-heading span {
            color: #7955dc;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 1.5px;
        }

        .section-heading h2 {
            font-size: 34px;
            margin: 12px 0;
            letter-spacing: -1px;
        }

        .section-heading p {
            color: #777287;
            font-size: 15px;
            line-height: 1.7;
        }

        .about-section {
            background: #fff;
        }

        .about-content {
            max-width: 850px;
            margin: auto;
            text-align: center;
        }

        .about-content p {
            color: #777287;
            font-size: 16px;
            line-height: 1.9;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .feature-card {
            background: #fff;
            border: 1px solid #eeeaf7;
            border-radius: 15px;
            padding: 25px;
        }

        .feature-icon {
            width: 47px;
            height: 47px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #f0ebff;
            color: #7955dc;
            border-radius: 12px;
            font-size: 22px;
            margin-bottom: 20px;
        }

        .feature-card h3 {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .feature-card p {
            color: #858196;
            font-size: 13px;
            line-height: 1.7;
        }

        .steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
        }

        .step-card {
            text-align: center;
            padding: 25px;
        }

        .step-number {
            width: 48px;
            height: 48px;
            margin: 0 auto 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            background: #7955dc;
            color: #fff;
            font-weight: 800;
        }

        .step-card h3 {
            font-size: 17px;
            margin-bottom: 10px;
        }

        .step-card p {
            color: #858196;
            font-size: 13px;
            line-height: 1.7;
        }

        .cta-section {
            margin: 30px 8% 80px;
            padding: 65px 25px;
            text-align: center;
            background: linear-gradient(120deg, #7955dc, #6241c4);
            border-radius: 22px;
            color: #fff;
        }

        .cta-section h2 {
            font-size: 32px;
            margin-bottom: 14px;
        }

        .cta-section p {
            color: #eee8ff;
            font-size: 15px;
            margin-bottom: 25px;
        }

        .cta-section .primary-button {
            background: #fff;
            color: #7955dc;
        }

        footer {
            background: #fff;
            border-top: 1px solid #eeeaf7;
            padding: 28px 8%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            color: #858196;
            font-size: 12px;
        }

        footer strong {
            color: #7955dc;
            font-size: 19px;
        }

        @media (max-width: 950px) {
            .hero {
                grid-template-columns: 1fr;
            }

            .features-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 650px) {
            .navbar {
                height: auto;
                padding: 20px 6%;
                flex-wrap: wrap;
                gap: 18px;
            }

            .nav-links {
                order: 3;
                width: 100%;
                gap: 18px;
                flex-wrap: wrap;
            }

            .nav-actions {
                margin-left: auto;
            }

            .hero, .section {
                padding: 60px 6%;
            }

            .hero-visual {
                padding: 18px;
            }

            .features-grid, .steps-grid {
                grid-template-columns: 1fr;
            }

            .cta-section {
                margin: 20px 6% 55px;
            }

            footer {
                flex-direction: column;
                gap: 12px;
                text-align: center;
            }
        }
    </style>
</head>
<body>

    <nav class="navbar">
        <a href="{{ url('/') }}" class="brand">Testora.</a>

        <div class="nav-links">
            <a href="#home">Home</a>
            <a href="#about">About</a>
            <a href="#features">Features</a>
            <a href="#how-it-works">How It Works</a>
        </div>

        <div class="nav-actions">
            @auth
                <a href="{{ route('dashboard') }}" class="login-link">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="login-link">Login</a>
                <a href="{{ route('register') }}" class="primary-button">Get Started</a>
            @endauth
        </div>
    </nav>

    <section class="hero" id="home">
        <div>
            <span class="hero-label">AI-POWERED FEEDBACK ANALYSIS</span>

            <h1>
                Turn Customer Feedback Into <span>Better Insights.</span>
            </h1>

            <p class="hero-description">
                Testora helps you understand customer opinions through
                AI-powered sentiment analysis and feedback summarization.
                Discover what people think and make more informed decisions.
            </p>

            <div class="hero-buttons">
                @auth
                    <a href="{{ route('dashboard') }}" class="primary-button">Go to Dashboard</a>
                @else
                    <a href="{{ route('register') }}" class="primary-button">Get Started</a>
                    <a href="#features" class="secondary-button">Explore Features</a>
                @endauth
            </div>
        </div>

        <div class="hero-visual">
            <div class="preview-card">
                <div class="preview-heading">Feedback Overview</div>
                <div class="preview-subtitle">Illustrative sentiment breakdown</div>

                <div class="sentiment-row">
                    <span>Positive</span>
                    <span>75%</span>
                </div>
                <div class="sentiment-bar">
                    <div class="sentiment-fill positive"></div>
                </div>

                <div class="sentiment-row">
                    <span>Neutral</span>
                    <span>45%</span>
                </div>
                <div class="sentiment-bar">
                    <div class="sentiment-fill neutral"></div>
                </div>

                <div class="sentiment-row">
                    <span>Negative</span>
                    <span>25%</span>
                </div>
                <div class="sentiment-bar">
                    <div class="sentiment-fill negative"></div>
                </div>

                <div class="preview-note">
                    <strong>AI Feedback Summary</strong>
                    <p>
                        Understand customer opinions and identify areas
                        that may need improvement.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <section class="section about-section" id="about">
        <div class="section-heading">
            <span>ABOUT TESTORA</span>
            <h2>Understand What Your Customers Are Saying</h2>
        </div>

        <div class="about-content">
            <p>
                Testora is a feedback analysis system designed to help users
                collect and understand customer opinions about products and
                services. Through natural language processing, Testora
                classifies feedback by sentiment and generates summaries
                that make responses easier to understand.
            </p>
        </div>
    </section>

    <section class="section" id="features">
        <div class="section-heading">
            <span>WHAT TESTORA OFFERS</span>
            <h2>Features That Make Feedback Easier to Understand</h2>
            <p>Organize customer responses and turn written opinions into useful information.</p>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon">▤</div>
                <h3>Feedback Collection</h3>
                <p>Gather customer responses and organize them by project.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">✧</div>
                <h3>Sentiment Analysis</h3>
                <p>Classify feedback into positive, neutral, and negative sentiments.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">☷</div>
                <h3>AI Summarization</h3>
                <p>Generate concise summaries from multiple feedback responses.</p>
            </div>

            <div class="feature-card">
                <div class="feature-icon">▥</div>
                <h3>Visual Reports</h3>
                <p>View sentiment distributions and feedback statistics through charts.</p>
            </div>
        </div>
    </section>

    <section class="section about-section" id="how-it-works">
        <div class="section-heading">
            <span>HOW IT WORKS</span>
            <h2>Three Simple Steps</h2>
            <p>From collecting feedback to understanding customer opinions.</p>
        </div>

        <div class="steps-grid">
            <div class="step-card">
                <div class="step-number">1</div>
                <h3>Create a Project</h3>
                <p>Set up a project for the product or service you want to evaluate.</p>
            </div>

            <div class="step-card">
                <div class="step-number">2</div>
                <h3>Collect Feedback</h3>
                <p>Gather written responses from customers or product testers.</p>
            </div>

            <div class="step-card">
                <div class="step-number">3</div>
                <h3>Analyze Results</h3>
                <p>Use AI-powered sentiment analysis and summaries to understand the responses.</p>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <h2>Make Feedback More Meaningful</h2>
        <p>Start organizing and understanding customer opinions with Testora.</p>

        @auth
            <a href="{{ route('dashboard') }}" class="primary-button">Go to Dashboard</a>
        @else
            <a href="{{ route('register') }}" class="primary-button">Get Started</a>
        @endauth
    </section>

    <footer>
        <strong>Testora.</strong>
        <span>AI-Powered Feedback Analysis System</span>
        <span>© {{ date('Y') }} Testora. All rights reserved.</span>
    </footer>

</body>
</html>
