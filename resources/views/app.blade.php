<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SCA Laundry') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.jsx'])

    <style>
        body { font-family: 'Poppins', sans-serif; transition: background-color 0.3s ease, color 0.3s ease; }
        
        html, body { 
            background-color: #f8fafc;
            color: #1e293b;
        }
        
        body .bg-white { 
            background-color: white; 
            color: #1e293b; 
        }
        
        body .text-slate-800 { color: #1e293b; }
        body .text-slate-700 { color: #334155; }
        body .text-slate-600 { color: #475569; }
        body .text-slate-500 { color: #64748b; }
        body .text-slate-400 { color: #94a3b8; }
        
        .glass-mode { 
            background-color: #0f172a !important; 
            color: white !important; 
        }
        
        .glass-mode body {
            background-color: #0f172a !important;
            color: white !important;
        }
        
        .glass-mode .bg-white { 
            background-color: #1e293b !important; 
            color: white !important; 
            border-color: #334155 !important; 
        }
        
        .glass-mode .bg-slate-50 {
            background-color: #0f172a !important;
        }
        
        .glass-mode .text-slate-800 { color: white !important; }
        .glass-mode .text-slate-700 { color: white !important; }
        .glass-mode .text-slate-600 { color: #cbd5e1 !important; }
        .glass-mode .text-slate-500 { color: #94a3b8 !important; }
        .glass-mode .text-slate-400 { color: #cbd5e1 !important; }
        
    
    </style>

    
    <script>

        function initializeTheme() {
            const theme = localStorage.getItem('theme') || 'glass';
            const html = document.documentElement;
            const body = document.body;
            
            if (theme === 'glass') {
                html.classList.add('glass-mode');
                body.classList.add('glass-mode');
            } else {
                html.classList.remove('glass-mode');
                body.classList.remove('glass-mode');
            }
        }
  
        window.toggleTheme = function() {
            const html = document.documentElement;
            const body = document.body;
            const currentTheme = localStorage.getItem('theme') || 'glass';
            const newTheme = currentTheme === 'glass' ? 'normal' : 'glass';
            
            if (newTheme === 'glass') {
                html.classList.add('glass-mode');
                body.classList.add('glass-mode');
            } else {
                html.classList.remove('glass-mode');
                body.classList.remove('glass-mode');
            }
            
            const lightIcons = document.querySelectorAll('.light-icon');
            const darkIcons = document.querySelectorAll('.dark-icon');
            
            if (newTheme === 'glass') {
                lightIcons.forEach(el => el.classList.add('hidden'));
                darkIcons.forEach(el => el.classList.remove('hidden'));
            } else {
                lightIcons.forEach(el => el.classList.remove('hidden'));
                darkIcons.forEach(el => el.classList.add('hidden'));
            }
            
            localStorage.setItem('theme', newTheme);
        };
        
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', initializeTheme);
        } else {
            initializeTheme();
        }
    </script>
</head>
<body class="bg-slate-50 text-slate-800">

    <main>
        @yield('content')
    </main>

</body>
</html>