<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'EDV Integration Dr. Setz')</title>
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('img/logo_transl.gif') }}">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Import Google Fonts */
        @import url('https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Cinzel:wght@400;600;700&family=Cormorant+Garamond:wght@600&family=Libre+Baskerville:wght@700&family=Montserrat:wght@600&family=Lora:wght@400;600;700&family=Merriweather:wght@700&display=swap');

        body {
            background: url({{ asset('img/tan_paper.gif') }});
            font-family: 'Lora', serif;
            font-weight: 400;
            font-size: 110%;
        }
        /* Ensure tan background is visible everywhere */
        .bg-gray-50,
        .bg-white,
        .bg-gray-100 {
            background-color: transparent !important;
        }
        /* Keep specific accent backgrounds slightly tinted */
        .bg-blue-50 {
            background-color: rgba(239, 246, 255, 0.5) !important;
        }

        /* Font Options - Uncomment ONE to activate */

        /* Option 1: Playfair Display - Elegant serif, classic */
        .header-option-1 {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            letter-spacing: 0.02em;
            transform: scale(3);
        }

        /* Option 2: Cinzel - Roman-inspired, authoritative */
        .header-option-2 {
            font-family: 'Cinzel', serif;
            font-weight: 600;
            letter-spacing: 0.05em;
            transform: scale(3);
        }

        /* Responsive header sizing */
        .header-main {
            font-size: clamp(0.75rem, 1.5vw, 3rem);
        }

        .header-subtitle {
            font-size: clamp(0.5rem, 1vw, 2rem);
        }

        /* Option 3: Cormorant Garamond - Refined, traditional */
        .header-option-3 {
            font-family: 'Cormorant Garamond', serif;
            font-weight: 600;
            letter-spacing: 0.03em;
            transform: scale(3);
        }

        /* Option 4: Libre Baskerville - Professional, readable */
        .header-option-4 {
            font-family: 'Libre Baskerville', serif;
            font-weight: 700;
            letter-spacing: 0.01em;
            transform: scale(3);
        }

        /* Option 5: Montserrat - Modern, clean */
        .header-option-5 {
            font-family: 'Montserrat', sans-serif;
            font-weight: 600;
            letter-spacing: 0.04em;
            transform: scale(3);
        }

        /* Heading Styles */
        h1 {
            font-family: 'Cinzel', serif;
            font-weight: 600;
            letter-spacing: 0.02em;
        }

        h2 {
            font-family: 'Lora', serif;
            font-weight: 600;
        }

        h3 {
            font-family: 'Merriweather', serif;
            font-weight: 700;
        }
    </style>
</head>
<body class="h-full text-gray-800 font-sans antialiased">
    <div class="flex flex-col min-h-screen">
        <!-- Header Area -->
        <div class="relative" style="padding-top: 48px; padding-bottom: 100px;">
             <a href="{{ route('home') }}">
                 <img src="{{ asset('img/logo_transl.gif') }}" style="position:absolute;left:20px;top:10px;width:clamp(58px, 5.75vw, 138px);height:auto;" alt="EDV Beratung Dr.-Ing. Setz">
             </a>
             <a href="{{ route('home') }}">
                 <img src="{{ asset('img/logo_transr.gif') }}" style="position:absolute;right:20px;top:10px;width:clamp(69px, 6.9vw, 173px);height:auto;" alt="logo">
             </a>
             <div class="text-center px-40">
                 <h1 class="header-option-2 header-main text-gray-900 mb-8">
                    EDV INTEGRATION DR. SETZ
                 </h1>
                 <p class="header-option-2 header-subtitle text-gray-700">Ihr Partner am Netz</p>
             </div>
        </div>


        <!-- Main Content Area -->
        <div class="flex flex-1">
        <!-- Sidebar Navigation -->
        <aside class="w-64 border-r border-gray-400 p-6" style="background: transparent; padding-top: 50px;">
            <nav class="space-y-6">
                <div>
                    <ul class="space-y-2">
                        <li>
                            <a href="{{ route('home') }}" class="text-base text-gray-700 hover:text-gray-900 {{ request()->routeIs('home') ? 'font-semibold' : '' }}">
                                Home
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('about') }}" class="text-base text-gray-700 hover:text-gray-900 {{ request()->routeIs('about') ? 'font-semibold' : '' }}">
                                Über Uns
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('contact') }}" class="text-base text-gray-700 hover:text-gray-900 {{ request()->routeIs('contact') ? 'font-semibold' : '' }}">
                                Kontakt
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Restricted Access</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="https://nc.setz.de" target="_blank" rel="noopener" class="text-base text-gray-700 hover:text-gray-900">
                                Nextcloud
                            </a>
                        </li>
                        <li>
                            <a href="https://coder.setz.de" target="_blank" rel="noopener" class="text-base text-gray-700 hover:text-gray-900">
                                Coder Zugang
                            </a>
                        </li>
                    </ul>
                </div>

                <div>
                    <h2 class="text-sm font-semibold text-gray-500 uppercase tracking-wider mb-3">Weitere Bereiche</h2>
                    <ul class="space-y-2">
                        <li>
                            <a href="https://www.coursera.org" target="_blank" rel="noopener" class="text-base text-gray-700 hover:text-gray-900">
                                Coursera
                            </a>
                        </li>
                        <li>
                            <a href="https://www.semigator.de" target="_blank" rel="noopener" class="text-base text-gray-700 hover:text-gray-900">
                                Semigator
                            </a>
                        </li>
                    </ul>
                </div>
            </nav>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8" style="padding-top: 20px;">
            <div class="max-w-4xl mx-auto">
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="mt-16 pt-8 border-t border-gray-400 max-w-4xl mx-auto">
                <div class="flex justify-between items-center text-sm text-gray-600">
                    <div>
                        <p>&copy; {{ date('Y') }} EDV Integration Dr. Setz</p>
                        <p class="text-xs mt-1">Version: {{ trim(file_get_contents(base_path('VERSION.txt'))) }}</p>
                    </div>
                    <div class="space-x-4">
                        <a href="{{ route('impressum') }}" class="hover:text-gray-900">Impressum</a>
                        <a href="{{ route('datenschutz') }}" class="hover:text-gray-900">Datenschutz</a>
                    </div>
                </div>
            </footer>
        </main>
        </div>
    </div>
</body>
</html>
