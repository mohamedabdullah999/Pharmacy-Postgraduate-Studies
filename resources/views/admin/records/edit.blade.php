@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
    <h2 class="text-2xl font-bold text-[#003366] mb-6 border-b pb-4">تعديل بيانات السجل الأكاديمي للطالب: {{ $program->student->full_name }}</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.records.update', $program) }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
            <div>
                <label class="block text-gray-700 font-bold mb-2">نوع البرنامج</label>
                <select name="program_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
                    <option value="pre_master" {{ $program->program_type == 'pre_master' ? 'selected' : '' }}>تمهيدي ماجستير</option>
                    <option value="master" {{ $program->program_type == 'master' ? 'selected' : '' }}>ماجستير</option>
                    <option value="doctorate" {{ $program->program_type == 'doctorate' ? 'selected' : '' }}>دكتوراه</option>
                </select>
            </div>
            
            <div>
                <label class="block text-gray-700 font-bold mb-2">تاريخ بداية القيد</label>
                <input type="date" name="registration_start_date" value="{{ $program->registration_start_date }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>

            <div>
                <label class="block text-gray-700 font-bold mb-2">مدة القيد (بالأيام)</label>
                <input type="number" name="registration_duration_days" value="{{ $program->registration_duration_days }}" min="1" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
            </div>
        </div>

        <h3 class="text-xl font-bold text-[#800020] mb-4 mt-8 border-b pb-2">بيانات الرسالة ولجنة الإشراف</h3>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">عنوان الرسالة (عربي)</label>
            <input type="text" name="thesis_title_ar" value="{{ $program->thesis_title_ar }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">عنوان الرسالة (إنجليزي)</label>
            <input type="text" name="thesis_title_en" value="{{ $program->thesis_title_en }}" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
        </div>

        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">تشكيل لجنة الإشراف</label>
            <textarea name="supervisory_committee_members_text" rows="4" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">{{ $program->supervisory_committee_members_text }}</textarea>
        </div>

        <div class="mt-8 flex justify-end">
            <a href="{{ route('admin.records.show', $program) }}" class="text-gray-600 px-6 py-2 mr-4 hover:underline">إلغاء</a>
            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition">
                حفظ التعديلات
            </button>
        </div>
    </form>
</div>
@endsection