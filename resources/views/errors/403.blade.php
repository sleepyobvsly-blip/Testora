
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>403 - Access Restricted | Sentra</title>

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
            background: #f7f7fc;
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        .error-container {
            width: 100%;
            max-width: 520px;
            text-align: center;
        }

        .brand {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 45px;
        }

        .brand-icon {
            background: #7965e8;
            color: white;
            width: 38px;
            height: 38px;
            border-radius: 11px;
            display: grid;
            place-items: center;
        }

        .error-code {
            font-size: 100px;
            font-weight: 800;
            line-height: 1;
            color: #7965e8;
            margin-bottom: 15px;
        }

        h1 {
            font-size: 28px;
            margin-bottom: 12px;
        }

        .description {
            color: #64748b;
            line-height: 1.7;
            margin-bottom: 30px;
        }

        .info-card {
            background: white;
            border: 1px solid #e8e7f2;
            border-radius: 16px;
            padding: 22px;
            text-align: left;
            margin-bottom: 28px;
        }

        .info-card h2 {
            font-size: 15px;
            margin-bottom: 8px;
        }

        .info-card p {
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
        }

        .back-button {
            display: inline-block;
            background: #7965e8;
            color: white;
            text-decoration: none;
            padding: 13px 24px;
            border-radius: 10px;
            font-weight: 600;
            transition: 0.2s;
        }

        .back-button:hover {
            background: #6651d5;
        }

        .footer {
            margin-top: 35px;
            color: #94a3b8;
            font-size: 12px;
        }

        @media (max-width: 480px) {
            .error-code {
                font-size: 78px;
            }

            h1 {
                font-size: 23px;
            }
        }
    </style>
</head>
<body>

    <div class="error-container">

        <div class="brand">
            <div class="brand-icon">S</div>
            Sentra
        </div>

        <div class="error-code">403</div>

        <h1>Access Restricted</h1>

        <p class="description">
            Sorry, you don't have permission to perform this action.
        </p>

        <div class="info-card">
            <h2>Why am I seeing this?</h2>
            <p>
                This project may have been completed, or your account
                may not have permission to access this resource.
                Please contact your administrator if you believe
                this is a mistake.
            </p>
        </div>

        <a href="{{ route('dashboard') }}" class="back-button">
            Return to Dashboard
        </a>

        <div class="footer">
            © {{ date('Y') }} Sentra. All rights reserved.
        </div>

    </div>

</body>
</html>
