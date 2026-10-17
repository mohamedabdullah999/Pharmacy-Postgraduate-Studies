@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
    <h2 class="text-2xl font-bold text-[#003366] mb-6 border-b pb-4">إضافة سجل أكاديمي جديد</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.records.store') }}" method="POST">
        @csrf
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">الطالب</label>
                <select name="student_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
                    <option value="">اختر الطالب...</option>
                    @foreach($students as $student)
                        <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->national_id }})</option>
                    @endforeach
                </select>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">نوع البرنامج</label>
                <select name="program_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
                    <option value="pre_master">تمهيدي ماجستير</option>
                    <option value="master">ماجستير</option>
                    <option value="doctorate">دكتوراه</option>
                </select>
            </div>
        </div>

        <h3 class="text-xl font-bold text-[#800020] mb-4 mt-8 border-b pb-2">بيانات القيد والمدة</h3>
        <p class="text-sm text-gray-500 mb-4">سيتم حساب تاريخ الانتهاء تلقائياً بناءً على تاريخ البدء، المدة، والمد المضاف.</p>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">تاريخ موافقة المجلس على القيد</label>
                <input type="date" name="registration_start_date" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">مدة القيد بالأيام</label>
                <input type="number" name="registration_duration_days" min="1" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">مد القيد (أيام إضافية)</label>
                <input type="number" name="extension_days" min="0" value="0" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 px-6 py-2 mr-4 hover:underline">إلغاء</a>
            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition">
                حفظ السجل
            </button>
        </div>
    </form>
</div>
@endsection