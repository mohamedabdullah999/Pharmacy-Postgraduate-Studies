<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>جامعة الزقازيق - إدارة السجلات الأكاديمية</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1EA] text-gray-900 font-sans min-h-screen flex flex-col">
    <header class="bg-[#003366] text-white shadow-md border-b-4 border-[#800020]">
        <div class="container mx-auto px-6 py-4 flex justify-between items-center">
            <div class="flex items-center gap-4">
                <h1 class="text-xl font-bold">جامعة الزقازيق - الدراسات العليا</h1>
            </div>
            <nav class="flex items-center gap-4">
                <span class="font-medium">{{ Auth::user()->username }}</span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="bg-[#800020] hover:bg-red-800 text-white px-4 py-2 rounded transition">
                        تسجيل الخروج
                    </button>
                </form>
            </nav>
        </div>
    </header>

    <main class="flex-grow container mx-auto px-6 py-8">
        @yield('content')
    </main>

    <footer class="bg-[#003366] text-white text-center py-4 mt-auto border-t-4 border-[#800020]">
        <p class="text-sm">كلية الصيدلة - جامعة الزقازيق &copy; {{ date('Y') }}</p>
    </footer>
</body>
</html>