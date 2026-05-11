<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - PL Deduplicator</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: { extend: { fontFamily: { sans: ['Inter', 'sans-serif'] }, colors: { brand: { 50: '#f4f4f5', 500: '#3b82f6', 600: '#2563eb' } } } }
        }
    </script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
</head>
<body class="antialiased min-h-screen bg-slate-50 flex flex-col justify-center py-12 sm:px-6 lg:px-8 font-sans">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <div class="h-12 w-12 rounded-full bg-brand-600 flex items-center justify-center shadow-lg shadow-brand-500/30">
                <i data-lucide="shield-check" class="h-6 w-6 text-white"></i>
            </div>
        </div>
        <h2 class="mt-6 text-center text-2xl font-bold tracking-tight text-slate-900">Sign in to your account</h2>
        <p class="mt-2 text-center text-sm text-slate-600">
            Secure access to Price List Deduplicator
        </p>
    </div>

    <div class="mt-8 sm:mx-auto sm:w-full sm:max-w-md">
        <div class="bg-white py-8 px-4 shadow-xl shadow-slate-200/50 sm:rounded-xl sm:px-10 border border-slate-100">
            @if($errors->any())
                <div class="rounded-md bg-red-50 p-4 mb-6 border border-red-200">
                    <div class="flex">
                        <div class="flex-shrink-0"><i data-lucide="alert-circle" class="h-5 w-5 text-red-400"></i></div>
                        <div class="ml-3"><h3 class="text-sm font-medium text-red-800">Invalid credentials</h3></div>
                    </div>
                </div>
            @endif

            <form class="space-y-6" action="{{ route('login') }}" method="POST">
                @csrf
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-700">Email address</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="mail" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="email" name="email" type="email" autocomplete="email" required value="admin@example.com" class="block w-full pl-10 sm:text-sm border-slate-300 rounded-md py-2 border focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors" placeholder="you@example.com">
                    </div>
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-700">Password</label>
                    <div class="mt-1 relative rounded-md shadow-sm">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i data-lucide="lock" class="h-5 w-5 text-slate-400"></i>
                        </div>
                        <input id="password" name="password" type="password" autocomplete="current-password" required value="password" class="block w-full pl-10 sm:text-sm border-slate-300 rounded-md py-2 border focus:ring-brand-500 focus:border-brand-500 outline-none transition-colors" placeholder="••••••••">
                    </div>
                </div>

                <div>
                    <button type="submit" class="flex w-full justify-center rounded-md border border-transparent bg-brand-600 py-2 px-4 text-sm font-medium text-white shadow-sm hover:bg-brand-700 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2 transition-all">
                        Sign in
                    </button>
                </div>
            </form>

            <div class="mt-8 pt-6 border-t border-slate-100">
                <p class="text-xs font-semibold text-slate-500 uppercase tracking-wider text-center mb-4">Demo Access</p>
                <div class="grid grid-cols-2 gap-3">
                    <button type="button" onclick="document.getElementById('email').value='admin@example.com'; document.getElementById('password').value='password';" class="inline-flex justify-center rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-500 shadow-sm hover:bg-slate-50">
                        <i data-lucide="shield" class="h-4 w-4 mr-2 text-slate-400"></i> Admin
                    </button>
                    <button type="button" onclick="document.getElementById('email').value='reviewer@example.com'; document.getElementById('password').value='password';" class="inline-flex justify-center rounded-md border border-slate-300 bg-white py-2 px-4 text-sm font-medium text-slate-500 shadow-sm hover:bg-slate-50">
                        <i data-lucide="eye" class="h-4 w-4 mr-2 text-slate-400"></i> Reviewer
                    </button>
                </div>
            </div>
        </div>
    </div>
    <script> lucide.createIcons(); </script>
</body>
</html>
