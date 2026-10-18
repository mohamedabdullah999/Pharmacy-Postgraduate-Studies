@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-[#003366]">تفاصيل السجل الأكاديمي</h2>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:underline">العودة للوحة التحكم</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="col-span-1 bg-white p-6 rounded-lg shadow border-t-4 border-[#800020]">
        <h3 class="font-bold text-lg text-[#003366] mb-4 border-b pb-2">بيانات الطالب</h3>
        <p class="text-sm text-gray-500">الاسم</p>
        <p class="font-bold mb-3">{{ $program->student->full_name }}</p>
        <p class="text-sm text-gray-500">الرقم القومي</p>
        <p class="font-bold mb-3">{{ $program->student->national_id }}</p>
        <p class="text-sm text-gray-500">الكود</p>
        <p class="font-bold mb-3">{{ $program->student->student_code ?? '-' }}</p>
    </div>

    <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow border-t-4 border-[#003366]">
        <h3 class="font-bold text-lg text-[#003366] mb-4 border-b pb-2">بيانات القيد والمدة</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">البرنامج</p>
                <p class="font-bold">{{ $program->program_type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">بداية القيد</p>
                <p class="font-bold">{{ $program->registration_start_date }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">المدة الأساسية</p>
                <p class="font-bold">{{ $program->registration_duration_days }} يوم</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">المد المضاف</p>
                <p class="font-bold text-[#800020]">{{ $program->extension_days }} يوم</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="font-bold text-lg text-[#003366] mb-4">تسجيل مد جديد</h3>
        <form action="{{ route('admin.records.extensions.store', $program) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold mb-1">رقم المد (1-5)</label>
                    <input type="number" name="extension_number" min="1" max="5" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">عدد الأيام</label>
                    <input type="number" name="granted_days" min="1" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">السبب</label>
                <input type="text" name="reason" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">موافقة الجامعة</label>
                <input type="date" name="university_council_approval_date" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-[#003366] text-white px-4 py-2 rounded w-full">إضافة المد</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="font-bold text-lg text-[#800020] mb-4">تسجيل إيقاف قيد</h3>
        <form action="{{ route('admin.records.suspensions.store', $program) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">رقم الإيقاف (1-5)</label>
                <input type="number" name="suspension_number" min="1" max="5" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">السبب</label>
                <input type="text" name="reason" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">موافقة الجامعة</label>
                <input type="date" name="university_council_approval_date" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-[#800020] text-white px-4 py-2 rounded w-full">إضافة الإيقاف</button>
        </form>
    </div>

</div>
@endsection