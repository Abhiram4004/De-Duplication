<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PL Deduplicator Enterprise</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Outfit', 'sans-serif'] },
                    colors: {
                        brand: { 50: '#eff6ff', 100: '#dbeafe', 400: '#60a5fa', 500: '#3b82f6', 600: '#2563eb', 900: '#1e3a8a' },
                        accent: { 400: '#f472b6', 500: '#ec4899', 600: '#db2777' }
                    }
                }
            }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { 
            background: linear-gradient(135deg, #f0f4ff 0%, #fdf4ff 100%);
            background-attachment: fixed;
            color: #1e293b; 
        }
        ::-webkit-scrollbar { width: 8px; height: 8px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
        ::-webkit-scrollbar-thumb:hover { background: #94a3b8; }
        
        .glass-header { 
            background: rgba(255, 255, 255, 0.75); 
            backdrop-filter: blur(16px); 
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.5); 
        }
        
        .colorful-sidebar {
            background: linear-gradient(180deg, #1e1b4b 0%, #312e81 100%);
            border-right: 1px solid rgba(255,255,255,0.1);
        }
        
        .sidebar-link {
            color: rgba(255, 255, 255, 0.7);
            transition: all 0.3s ease;
        }
        .sidebar-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            transform: translateX(4px);
        }
        .sidebar-link.active {
            background: linear-gradient(90deg, rgba(99, 102, 241, 0.4) 0%, rgba(99, 102, 241, 0) 100%);
            color: #ffffff;
            border-left: 4px solid #818cf8;
            font-weight: 600;
        }

        /* Redefine buttons globally */
        .btn-primary {
            background: linear-gradient(135deg, #4f46e5 0%, #ec4899 100%);
            color: white;
            border: none;
            box-shadow: 0 4px 15px rgba(236, 72, 153, 0.3);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            box-shadow: 0 6px 20px rgba(236, 72, 153, 0.5);
            transform: translateY(-2px);
        }

        /* Page Load Animation */
        .page-enter {
            animation: fadeSlideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }
        @keyframes fadeSlideUp {
            from { opacity: 0; transform: translateY(30px) scale(0.98); filter: blur(4px); }
            to { opacity: 1; transform: translateY(0) scale(1); filter: blur(0); }
        }

        /* Touch / Ripple Animation */
        .sidebar-link { position: relative; overflow: hidden; }
        .ripple-effect {
            position: absolute;
            background: rgba(255, 255, 255, 0.4);
            transform: translate(-50%, -50%);
            pointer-events: none;
            border-radius: 50%;
            animation: animateRipple 0.6s linear;
        }
        @keyframes animateRipple {
            0% { width: 0px; height: 0px; opacity: 0.8; }
            100% { width: 400px; height: 400px; opacity: 0; }
        }
    </style>
</head>
<body class="antialiased min-h-screen flex text-sm">

    @auth
    <!-- Sidebar -->
    <aside class="w-64 colorful-sidebar flex flex-col fixed inset-y-0 z-20 shadow-2xl">
        <div class="h-20 flex items-center px-6 border-b border-white/10 relative overflow-hidden">
            <div class="absolute -right-6 -top-6 w-24 h-24 bg-accent-500 rounded-full blur-2xl opacity-40"></div>
            <div class="absolute -left-6 -bottom-6 w-24 h-24 bg-brand-500 rounded-full blur-2xl opacity-40"></div>
            
            <i data-lucide="layers" class="text-white mr-3 h-8 w-8 relative z-10"></i>
            <span class="font-extrabold text-xl tracking-tight text-white relative z-10">Deduplicator</span>
        </div>
        
        <nav class="flex-1 overflow-y-auto py-6 px-3 space-y-1 relative z-10">
            <a href="{{ route('dashboard') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i data-lucide="layout-dashboard" class="h-5 w-5 mr-3 {{ request()->routeIs('dashboard') ? 'text-white' : 'opacity-70' }}"></i> Dashboard
            </a>
            <a href="{{ route('upload.create') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('upload.*') ? 'active' : '' }}">
                <i data-lucide="upload-cloud" class="h-5 w-5 mr-3 {{ request()->routeIs('upload.*') ? 'text-white' : 'opacity-70' }}"></i> Import Data
            </a>
            
            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-bold text-indigo-300 uppercase tracking-widest opacity-80">Management</p>
            </div>
            <a href="{{ route('price_lists.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('price_lists.*') ? 'active' : '' }}">
                <i data-lucide="database" class="h-5 w-5 mr-3 {{ request()->routeIs('price_lists.*') ? 'text-white' : 'opacity-70' }}"></i> Price Lists
            </a>
            <a href="{{ route('duplicates.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('duplicates.*') ? 'active' : '' }}">
                <i data-lucide="git-merge" class="h-5 w-5 mr-3 {{ request()->routeIs('duplicates.*') ? 'text-white' : 'opacity-70' }}"></i> Review Duplicates
            </a>
            <a href="{{ route('reports.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i data-lucide="bar-chart-2" class="h-5 w-5 mr-3 {{ request()->routeIs('reports.*') ? 'text-white' : 'opacity-70' }}"></i> Reports
            </a>

            <div class="pt-6 pb-2">
                <p class="px-4 text-xs font-bold text-indigo-300 uppercase tracking-widest opacity-80">System Logs</p>
            </div>
            <a href="{{ route('merge_logs.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('merge_logs.*') ? 'active' : '' }}">
                <i data-lucide="history" class="h-5 w-5 mr-3 {{ request()->routeIs('merge_logs.*') ? 'text-white' : 'opacity-70' }}"></i> Merge History
            </a>
            <a href="{{ route('audit_logs.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('audit_logs.*') ? 'active' : '' }}">
                <i data-lucide="shield-alert" class="h-5 w-5 mr-3 {{ request()->routeIs('audit_logs.*') ? 'text-white' : 'opacity-70' }}"></i> Audit Logs
            </a>
            <a href="{{ route('settings.index') }}" class="flex items-center px-4 py-3 rounded-lg sidebar-link {{ request()->routeIs('settings.*') ? 'active' : '' }}">
                <i data-lucide="settings" class="h-5 w-5 mr-3 {{ request()->routeIs('settings.*') ? 'text-white' : 'opacity-70' }}"></i> Settings
            </a>
        </nav>

        <div class="p-4 border-t border-white/10 relative z-10 bg-black/20">
            <div class="flex items-center w-full">
                <div class="flex-shrink-0">
                    <span class="inline-flex items-center justify-center h-10 w-10 rounded-xl bg-gradient-to-br from-pink-500 to-orange-400 shadow-lg">
                        <span class="text-sm font-bold leading-none text-white">{{ substr(auth()->user()->name, 0, 1) }}</span>
                    </span>
                </div>
                <div class="ml-3 truncate flex-1">
                    <p class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</p>
                    <p class="text-xs font-medium text-indigo-200 truncate">{{ ucfirst(auth()->user()->role ?? 'Admin') }}</p>
                </div>
                <form method="POST" action="{{ route('logout') }}" class="ml-2">
                    @csrf
                    <button type="submit" class="p-2 rounded-lg bg-white/5 text-indigo-200 hover:text-white hover:bg-red-500/80 transition-all" title="Logout">
                        <i data-lucide="log-out" class="h-4 w-4"></i>
                    </button>
                </form>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col ml-64 min-w-0">
        <!-- Topbar -->
        <header class="h-20 glass-header sticky top-0 z-10 flex items-center justify-between px-10 shadow-sm">
            <div class="flex items-center text-slate-600 text-sm font-medium">
                @yield('breadcrumbs')
            </div>
            <div class="flex items-center space-x-4">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-white text-emerald-600 border border-emerald-100 shadow-sm">
                    <span class="w-2 h-2 mr-2 bg-emerald-500 rounded-full animate-pulse shadow-[0_0_8px_rgba(16,185,129,0.8)]"></span>
                    System Online
                </span>
            </div>
        </header>

        <!-- Page Content -->
        <div class="flex-1 p-10 overflow-y-auto page-enter">
            @if(session('success'))
                <div class="mb-8 rounded-xl bg-white p-5 border border-emerald-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center border-l-4 border-l-emerald-500">
                    <div class="flex-shrink-0 bg-emerald-100 rounded-full p-2"><i data-lucide="check" class="h-5 w-5 text-emerald-600"></i></div>
                    <div class="ml-4"><p class="text-sm font-bold text-slate-800">{{ session('success') }}</p></div>
                </div>
            @endif
            @if(session('error'))
                <div class="mb-8 rounded-xl bg-white p-5 border border-red-200 shadow-[0_8px_30px_rgb(0,0,0,0.04)] flex items-center border-l-4 border-l-red-500">
                    <div class="flex-shrink-0 bg-red-100 rounded-full p-2"><i data-lucide="alert-triangle" class="h-5 w-5 text-red-600"></i></div>
                    <div class="ml-4"><p class="text-sm font-bold text-slate-800">{{ session('error') }}</p></div>
                </div>
            @endif

            <div class="max-w-7xl mx-auto">
                @yield('content')
            </div>
        </div>
    </main>
    @else
        <!-- Guest Layout -->
        <div class="min-h-screen w-full flex items-center justify-center bg-[linear-gradient(135deg,#f0f4ff_0%,#fdf4ff_100%)]">
            @yield('content')
        </div>
    @endauth

    <script>
        lucide.createIcons();

        // Touch Ripple Logic
        document.querySelectorAll('.sidebar-link, .btn-primary').forEach(button => {
            button.addEventListener('click', function(e) {
                let rect = e.target.getBoundingClientRect();
                let x = e.clientX - rect.left;
                let y = e.clientY - rect.top;
                let ripples = document.createElement('span');
                ripples.style.left = x + 'px';
                ripples.style.top = y + 'px';
                ripples.classList.add('ripple-effect');
                this.appendChild(ripples);
                setTimeout(() => { ripples.remove() }, 600);
            });
        });
    </script>
</body>
</html>
