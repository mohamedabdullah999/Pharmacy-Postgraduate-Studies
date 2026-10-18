<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - جامعة الزقازيق</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1EA] text-gray-900 font-sans min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md border-t-4 border-[#003366] p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#003366]">جامعة الزقازيق</h1>
            <p class="text-sm text-gray-600 mt-1">كلية الصيدلة - الدراسات العليا</p>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm">اسم المستخدم</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required autofocus>
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2 text-sm">الرقم القومي (للتحقق)</label>
                <input type="text" name="national_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required maxlength="14" placeholder="اكتب أي 14 رقم للأدمن">
            </div>

            <button type="submit" class="w-full bg-[#003366] text-white py-2 rounded font-bold hover:bg-blue-900 transition">
                تسجيل الدخول
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('activate') }}" class="text-sm text-[#800020] hover:underline font-bold">تفعيل حساب جديد</a>
        </div>
    </div>
</body>
</html>