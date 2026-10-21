<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>إدارة الدراسات العليا - جامعة الزقازيق</title>
    
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        zu: {
                            blue: '#132a4f',
                            maroon: '#800020',
                            green: '#2E8B57',
                            beige: '#F5F5DC',
                            gold: '#FEDA31'
                        }
                    },
                    fontFamily: {
                        cairo: ['Cairo', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Cairo', sans-serif; background-color: #F9FAFB; }
        .zu-pattern {
            background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(19, 42, 79, 0.05) 10px, rgba(19, 42, 79, 0.05) 20px);
        }
    </style>
</head>
<body class="text-gray-800 antialiased">
    
    <nav class="bg-zu-blue text-white shadow-md border-b-4 border-zu-maroon">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center gap-4">
                    <!-- لوجو الجامعة (نصي مؤقتاً) -->
                    <div class="font-bold text-xl flex items-center gap-2">
                        <span class="text-zu-gold">جامعة الزقازيق</span> | الدراسات العليا
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    @auth
                        <span class="text-sm">مرحباً، {{ auth()->user()->name }}</span>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="bg-zu-maroon hover:bg-red-800 px-3 py-1 rounded text-sm transition">خروج</button>
                        </form>
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="flex max-w-7xl mx-auto mt-6 px-4 gap-6">
        @auth
            @if(auth()->user()->role === 'admin')
            <aside class="w-64 shrink-0 hidden md:block">
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-4 zu-pattern">
                    <ul class="space-y-2">
                        <li><a href="{{ route('dashboard') }}" class="block p-2 rounded hover:bg-zu-beige text-zu-blue font-semibold">لوحة الإحصائيات</a></li>
                        <li><a href="{{ route('enrollments.index', 'pre_master') }}" class="block p-2 rounded hover:bg-zu-beige text-zu-blue">تمهيدي ماجستير</a></li>
                        <li><a href="{{ route('enrollments.index', 'master') }}" class="block p-2 rounded hover:bg-zu-beige text-zu-blue">الماجستير</a></li>
                        <li><a href="{{ route('enrollments.index', 'phd') }}" class="block p-2 rounded hover:bg-zu-beige text-zu-blue">الدكتوراه</a></li>
                    </ul>
                </div>
            </aside>
            @endif
        @endauth

        <main class="flex-1 bg-white rounded-lg shadow-sm border border-gray-200 p-6 relative">
            <!-- Alert Messages -->
            @if (session('success'))
                <div class="bg-zu-green text-white p-3 rounded mb-4 text-sm">{{ session('success') }}</div>
            @endif
            
            @yield('content')
        </main>
    </div>

</body>
</html>