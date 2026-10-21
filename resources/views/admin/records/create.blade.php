@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
    <h2 class="text-2xl font-bold text-[#003366] mb-6 border-b pb-4">إضافة طالب جديد وسجل أكاديمي</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4 text-sm">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.records.store') }}" method="POST">
        @csrf
        
        <!-- قسم البيانات الشخصية -->
        <h3 class="text-xl font-bold text-[#003366] mb-4 border-b pb-2">البيانات الشخصية للطالب</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">الاسم الرباعي</label>
                <input type="text" name="full_name" value="{{ old('full_name') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">الرقم القومي (14 رقم)</label>
                <input type="text" name="national_id" value="{{ old('national_id') }}" maxlength="14" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">كود الطالب</label>
                <input type="text" name="student_code" value="{{ old('student_code') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">رقم المحمول</label>
                <input type="text" name="mobile" value="{{ old('mobile') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
            </div>

            <div class="md:col-span-2">
                <label class="block text-gray-700 font-bold mb-2 text-sm">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
            </div>
        </div>

        <!-- قسم المؤهل الدراسي -->
        <h3 class="text-xl font-bold text-[#003366] mb-4 mt-8 border-b pb-2">المؤهل الدراسي السابق</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">المؤهل الدراسي</label>
                <input type="text" name="previous_qualification" value="{{ old('previous_qualification') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" placeholder="بكالوريوس العلوم الصيدلية">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">سنة الحصول عليه</label>
                <input type="number" name="qualification_year" value="{{ old('qualification_year') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" placeholder="2020">
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">التقدير العام</label>
                <input type="text" name="overall_grade" value="{{ old('overall_grade') }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" placeholder="جيد جداً">
            </div>
        </div>

        <!-- قسم بيانات البرنامج والقيد -->
        <h3 class="text-xl font-bold text-[#800020] mb-4 mt-8 border-b pb-2">بيانات البرنامج والقيد</h3>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">نوع البرنامج الأكاديمي</label>
                <select name="program_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
                    <option value="pre_master">تمهيدي ماجستير</option>
                    <option value="master">ماجستير</option>
                    <option value="doctorate">دكتوراه</option>
                </select>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">تاريخ بدء القيد (موافقة المجلس)</label>
                <input type="date" name="registration_start_date" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">مدة القيد (بالأيام)</label>
                <input type="number" name="registration_duration_days" value="365" min="1" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>
            <div>
                <label class="block text-gray-700 font-bold mb-2 text-sm">مد القيد (أيام إضافية)</label>
                <input type="number" name="extension_days" value="0" min="0" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
            </div>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.dashboard') }}" class="text-gray-600 px-6 py-2 mr-4 hover:underline">إلغاء</a>
            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition font-bold">
                حفظ الطالب والسجل الأكاديمي
            </button>
        </div>
    </form>
</div>
@endsection