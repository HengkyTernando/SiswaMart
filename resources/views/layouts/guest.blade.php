<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="light">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SiswaMart') }} - Login</title>

    <!-- Google Fonts: Inter & Outfit -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&family=Outfit:wght@500;600;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --bg-body: #f8f9fa;
            --bg-surface: #ffffff;
            --text-main: #202124;
            --text-muted: #5f6368;
            --border-color: #e8eaed;
            --primary-color: #1a73e8;
            --primary-hover: #174ea6;
            --focus-ring: rgba(26, 115, 232, 0.3);
            --bg-input: #f1f3f4;
        }

        .dark {
            --bg-body: #202124;
            --bg-surface: #2d2e30;
            --text-main: #e8eaed;
            --text-muted: #9aa0a6;
            --border-color: #3c4043;
            --primary-color: #8ab4f8;
            --primary-hover: #aecbfa;
            --focus-ring: rgba(138, 180, 248, 0.3);
            --bg-input: #202124;
        }

        body {
            font-family: 'Inter', sans-serif;
            background-color: var(--bg-body);
            color: var(--text-main);
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .auth-card {
            background-color: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            transition: all 0.3s ease;
        }

        .form-input {
            width: 100%;
            background-color: var(--bg-input);
            border: 1px solid transparent;
            color: var(--text-main);
            border-radius: 12px;
            padding: 0.75rem 1rem;
            font-size: 0.875rem;
            transition: all 0.2s ease;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary-color);
            background-color: var(--bg-surface);
            box-shadow: 0 0 0 4px var(--focus-ring);
        }

        .btn-primary {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary-color);
            color: #ffffff;
            font-weight: 600;
            font-size: 0.875rem;
            padding: 0.75rem 1.5rem;
            border-radius: 9999px;
            transition: all 0.2s ease;
            border: none;
            cursor: pointer;
            width: 100%;
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            box-shadow: 0 4px 12px var(--focus-ring);
            transform: translateY(-1px);
        }
        
        .dark .btn-primary {
            color: #202124;
        }
    </style>
</head>
<body class="antialiased min-h-screen flex flex-col justify-center items-center p-4">

    <!-- Theme Toggle (Optional, top right) -->
    <button id="themeToggleBtnAuth" class="fixed top-6 right-6 p-2.5 rounded-full bg-[var(--bg-surface)] border border-[var(--border-color)] text-[var(--text-muted)] hover:text-var(--primary-color) shadow-sm transition-all focus:outline-none focus:ring-4 focus:ring-[var(--focus-ring)] z-50">
        <!-- Sun Icon (Light Mode) -->
        <svg id="themeIconLightAuth" class="w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
        <!-- Moon Icon (Dark Mode) -->
        <svg id="themeIconDarkAuth" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path></svg>
    </button>

    <div class="w-full max-w-[420px]">
        <!-- Logo -->
        <div class="flex justify-center mb-8">
            <a href="/" class="flex items-center justify-center">
                <img src="{{ asset('images/logo.png') }}" alt="SiswaMart Logo" class="h-16 w-auto drop-shadow-md">
            </a>
        </div>

        <!-- Card Container -->
        <div class="auth-card p-8 sm:p-10">
            {{ $slot }}
        </div>
        
        <!-- Footer info -->
        <p class="text-center text-xs text-[var(--text-muted)] mt-8">
            &copy; {{ date('Y') }} SiswaMart. Khusus untuk media promosi internal sekolah.
        </p>
    </div>

    <script>
        // Theme logic
        const themeBtnAuth = document.getElementById('themeToggleBtnAuth');
        const iconLightAuth = document.getElementById('themeIconLightAuth');
        const iconDarkAuth = document.getElementById('themeIconDarkAuth');

        // Check local storage or OS preference
        if (localStorage.getItem('theme') === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }

        function updateThemeIconAuth() {
            if (document.documentElement.classList.contains('dark')) {
                iconLightAuth?.classList.remove('hidden');
                iconDarkAuth?.classList.add('hidden');
            } else {
                iconDarkAuth?.classList.remove('hidden');
                iconLightAuth?.classList.add('hidden');
            }
        }
        updateThemeIconAuth();

        themeBtnAuth?.addEventListener('click', () => {
            document.documentElement.classList.toggle('dark');
            if (document.documentElement.classList.contains('dark')) {
                localStorage.setItem('theme', 'dark');
            } else {
                localStorage.setItem('theme', 'light');
            }
            updateThemeIconAuth();
        });
    </script>
</body>
</html>
