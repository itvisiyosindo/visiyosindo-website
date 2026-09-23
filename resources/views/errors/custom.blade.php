<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#3b82f6">
    
    <title>@yield('title') - PT Visi Yosindo Medikal</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('assets/logo/visiyosindo.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/logo/visiyosindo.png') }}">
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        :root {
            --primary: #3b82f6;
            --primary-dark: #1e40af;
            --text-primary: #1e293b;
            --text-secondary: #64748b;
            --text-tertiary: #94a3b8;
            --bg-secondary: #f8fafc;
            --border-color: #e2e8f0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        html, body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', 'Helvetica Neue', sans-serif;
            -webkit-font-smoothing: antialiased;
            -moz-osx-font-smoothing: grayscale;
        }

        body {
            background: linear-gradient(to bottom, #f0f4f8, #ffffff);
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            width: 100vw;
            overflow: hidden;
            padding: 0;
            margin: 0;
        }

        .error-content {
            text-align: center;
            max-width: 500px;
            width: 100%;
            padding: 0 1.5rem;
            overflow: hidden;
        }

        .header {
            margin-bottom: 1.5rem;
        }

        .logo {
            width: 48px;
            height: 48px;
            margin: 0 auto 0.75rem;
            display: block;
        }

        .company-name {
            font-size: 0.92rem;
            font-weight: 600;
            color: var(--text-primary);
            margin-bottom: 0.15rem;
        }

        .company-tagline {
            font-size: 0.75rem;
            color: var(--text-tertiary);
        }

        .error-code {
            font-size: 4rem;
            font-weight: 800;
            color: var(--primary);
            margin: 1.25rem 0 0.75rem;
            line-height: 1;
            letter-spacing: -1px;
        }

        .error-title {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--text-primary);
            margin-bottom: 0.75rem;
            line-height: 1.2;
        }

        .error-message {
            font-size: 0.92rem;
            color: var(--text-secondary);
            line-height: 1.5;
            margin-bottom: 1.25rem;
        }

        .actions {
            display: flex;
            gap: 0.75rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            padding: 0.7rem 1.5rem;
            border-radius: 0.5rem;
            font-size: 0.85rem;
            font-weight: 500;
            text-decoration: none;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            white-space: nowrap;
        }

        .btn-primary {
            background: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background: var(--primary-dark);
        }

        .btn-secondary {
            background: var(--bg-secondary);
            color: var(--text-primary);
            border: 1px solid var(--border-color);
        }

        .btn-secondary:hover {
            background: var(--border-color);
            border-color: var(--text-secondary);
        }

        .footer {
            margin-top: 1.25rem;
            padding-top: 1rem;
            border-top: 1px solid var(--border-color);
            font-size: 0.8rem;
            color: var(--text-secondary);
        }

        .support-link {
            color: var(--primary);
            text-decoration: none;
            font-weight: 500;
        }

        .support-link:hover {
            text-decoration: underline;
        }

        .copyright {
            margin-top: 0.75rem;
            font-size: 0.7rem;
            color: var(--text-tertiary);
        }

        @media (max-width: 640px) {
            body {
                padding: 0;
            }

            .error-content {
                padding: 0 1rem;
            }

            .header {
                margin-bottom: 1rem;
            }

            .logo {
                width: 40px;
                height: 40px;
                margin: 0 auto 0.5rem;
            }

            .company-name {
                font-size: 0.85rem;
            }

            .company-tagline {
                font-size: 0.7rem;
            }

            .error-code {
                font-size: 3rem;
                margin: 1rem 0 0.5rem;
            }

            .error-title {
                font-size: 1.25rem;
                margin-bottom: 0.5rem;
            }

            .error-message {
                font-size: 0.85rem;
                margin-bottom: 1rem;
                line-height: 1.4;
            }

            .actions {
                flex-direction: column;
                gap: 0.5rem;
            }

            .btn {
                width: 100%;
                padding: 0.65rem 1rem;
                font-size: 0.8rem;
            }

            .footer {
                margin-top: 1rem;
                padding-top: 0.75rem;
                font-size: 0.75rem;
            }

            .copyright {
                margin-top: 0.5rem;
                font-size: 0.65rem;
            }
        }

        @media (prefers-color-scheme: dark) {
            :root {
                --primary: #60a5fa;
                --primary-dark: #3b82f6;
                --text-primary: #f1f5f9;
                --text-secondary: #cbd5e0;
                --text-tertiary: #94a3b8;
                --bg-secondary: #0f172a;
                --border-color: #334155;
            }

            body {
                background: linear-gradient(to bottom, #0f172a, #1e293b);
            }

            .error-code {
                color: #60a5fa;
            }

            .btn-secondary {
                background: #1e293b;
                border-color: #334155;
            }

            .btn-secondary:hover {
                background: #334155;
                border-color: #64748b;
            }
        }
    </style>
</head>
<body>
    <div class="error-content">
        <!-- Header -->
        <div class="header">
            <img src="{{ asset('assets/logo/visiyosindo.png') }}" alt="Logo" class="logo">
            <p class="company-name">PT Visi Yosindo Medikal</p>
            <p class="company-tagline">Affordable Healthcare Solutions</p>
        </div>

        <!-- Error -->
        <div class="error-code">@yield('code')</div>
        <h1 class="error-title">@yield('title')</h1>
        <p class="error-message">@yield('message')</p>

        <!-- Actions -->
        <div class="actions">
            <a href="{{ url('/') }}" class="btn btn-primary">← Kembali ke Beranda</a>
            @if(auth()->check())
                <a href="{{ url('/dashboard') }}" class="btn btn-secondary">Dashboard</a>
            @endif
        </div>

        <!-- Footer -->
        <div class="footer">
            <p>Butuh bantuan? <a href="mailto:support@visiyosindo.com" class="support-link">Hubungi tim support kami</a></p>
            <p class="copyright">© 2024 PT Visi Yosindo Medikal</p>
        </div>
    </div>
</body>
</html>