<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تفعيل الحساب - جامعة الزقازيق</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F4F1EA] text-gray-900 font-sans min-h-screen flex items-center justify-center">
    <div class="max-w-md w-full bg-white rounded-lg shadow-md border-t-4 border-[#800020] p-8">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-[#003366]">جامعة الزقازيق</h1>
            <p class="text-sm text-gray-600 mt-1">كلية الصيدلة - الدراسات العليا</p>
            <h2 class="text-lg font-bold text-[#800020] mt-4">تفعيل الحساب الأكاديمي</h2>
        </div>

        @if($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('activate') }}" method="POST">
            @csrf
            
            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm">الرقم القومي (14 رقم)</label>
                <input type="text" name="national_id" value="{{ old('national_id') }}" maxlength="14" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required autofocus placeholder="أدخل الرقم القومي المسجل لدى الإدارة">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm">اسم المستخدم الجديد</label>
                <input type="text" name="username" value="{{ old('username') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required placeholder="اختر اسم مستخدم لتسجيل الدخول">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 font-bold mb-2 text-sm">كلمة المرور</label>
                <input type="password" name="password" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required placeholder="أدخل كلمة مرور قوية">
            </div>

            <div class="mb-6">
                <label class="block text-gray-700 font-bold mb-2 text-sm">تأكيد كلمة المرور</label>
                <input type="password" name="password_confirmation" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required placeholder="أعد إدخال كلمة المرور">
            </div>

            <button type="submit" class="w-full bg-[#003366] text-white py-2 rounded font-bold hover:bg-blue-900 transition shadow">
                تفعيل الحساب الآن
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-[#003366] hover:underline font-bold">لديك حساب بالفعل؟ سجل دخولك من هنا</a>
        </div>
    </div>
</body>
</html>