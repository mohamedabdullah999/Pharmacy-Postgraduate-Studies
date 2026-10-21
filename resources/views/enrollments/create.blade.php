@extends('layouts.app')

@section('content')
<div class="border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-2xl font-bold text-zu-blue">
        إضافة طالب جديد - 
        @if($programType == 'pre_master') تمهيدي ماجستير
        @elseif($programType == 'master') الماجستير
        @else الدكتوراه @endif
    </h1>
    <p class="text-gray-500 text-sm mt-1">يرجى ملء البيانات التالية بدقة. سيتم توليد رمز تفعيل للطالب تلقائياً بعد الحفظ.</p>
</div>

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-zu-maroon p-4 rounded mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('enrollments.store', $programType) }}" id="studentForm">
    @csrf
    <input type="hidden" name="program_type" value="{{ $programType }}">

    <div class="border-b border-gray-200 mb-6 flex gap-4 overflow-x-auto">
        <button type="button" class="tab-btn active pb-2 border-b-2 border-zu-maroon text-zu-maroon font-bold px-2" data-target="personal-info">البيانات الشخصية</button>
        <button type="button" class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 hover:text-zu-blue px-2" data-target="academic-info">المؤهلات</button>
        <button type="button" class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 hover:text-zu-blue px-2" data-target="enrollment-info">القيد والتسجيل</button>
        <button type="button" class="tab-btn pb-2 border-b-2 border-transparent text-gray-500 hover:text-zu-blue px-2" data-target="thesis-info">الرسالة</button>
    </div>

    <div id="personal-info" class="tab-content block">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الاسم الرباعي <span class="text-red-500">*</span></label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الرقم القومي (14 رقم) <span class="text-red-500">*</span></label>
                <input type="text" name="national_id" value="{{ old('national_id') }}" required maxlength="14" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">كود الطالب <span class="text-red-500">*</span></label>
                <input type="text" name="student_code" value="{{ old('student_code') }}" required class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ الميلاد</label>
                <input type="date" name="dob" value="{{ old('dob') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">محافظة الميلاد</label>
                <input type="text" name="birth_governorate" value="{{ old('birth_governorate') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">رقم المحمول</label>
                <input type="text" name="mobile_number" value="{{ old('mobile_number') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">البريد الإلكتروني</label>
                <input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">الوظيفة الحالية</label>
                <input type="text" name="current_job" value="{{ old('current_job') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
            </div>
            <div class="md:col-span-2">
                <label class="block text-sm font-bold text-gray-700 mb-2">العنوان الحالي</label>
                <textarea name="current_address" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">{{ old('current_address') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-end">
            <button type="button" class="next-btn bg-zu-blue text-white px-6 py-2 rounded" data-next="academic-info">التالي</button>
        </div>
    </div>

    <div id="academic-info" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">المؤهل الدراسي</label>
                <input type="text" name="academic_degree" value="{{ old('academic_degree') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">سنة الحصول على المؤهل</label>
                <input type="number" name="degree_year" value="{{ old('degree_year') }}" placeholder="مثال: 2020" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">جهة الحصول على المؤهل</label>
                <input type="text" name="degree_institution" value="{{ old('degree_institution') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">التقدير العام</label>
                <input type="text" name="general_grade" value="{{ old('general_grade') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تقدير مادة التخصص</label>
                <input type="text" name="specialization_grade" value="{{ old('specialization_grade') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
        </div>
        <div class="mt-6 flex justify-between">
            <button type="button" class="prev-btn border border-gray-300 text-gray-700 px-6 py-2 rounded" data-prev="personal-info">السابق</button>
            <button type="button" class="next-btn bg-zu-blue text-white px-6 py-2 rounded" data-next="enrollment-info">التالي</button>
        </div>
    </div>

    <div id="enrollment-info" class="tab-content hidden">
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="md:col-span-2 bg-zu-beige p-4 rounded border-r-4 border-zu-gold">
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ بدء القيد (حقل النظام الأساسي لحساب المدة)</label>
                <input type="date" name="enrollment_start_date" value="{{ old('enrollment_start_date') }}" class="w-1/2 border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>

            @if(in_array($programType, ['pre_master', 'master']))
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة مجلس القسم على القيد</label>
                    <input type="date" name="enroll_dept_approval_date" value="{{ old('enroll_dept_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة لجنة الدراسات على القيد</label>
                    <input type="date" name="enroll_studies_approval_date" value="{{ old('enroll_studies_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة مجلس الكلية على القيد</label>
                    <input type="date" name="enroll_faculty_approval_date" value="{{ old('enroll_faculty_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة الجامعة على القيد</label>
                    <input type="date" name="enroll_univ_approval_date" value="{{ old('enroll_univ_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ الانتهاء من المقررات التمهيدية</label>
                    <input type="date" name="preliminary_courses_end_date" value="{{ old('preliminary_courses_end_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
                </div>
            @endif

            <div class="md:col-span-2 pt-4 border-t border-gray-200 mt-2">
                <h3 class="font-bold text-zu-maroon mb-4">موافقات التسجيل</h3>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة مجلس القسم على التسجيل</label>
                <input type="date" name="reg_dept_approval_date" value="{{ old('reg_dept_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة لجنة الدراسات على التسجيل</label>
                <input type="date" name="reg_studies_approval_date" value="{{ old('reg_studies_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة مجلس الكلية على التسجيل</label>
                <input type="date" name="reg_faculty_approval_date" value="{{ old('reg_faculty_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">تاريخ موافقة مجلس الجامعة على التسجيل</label>
                <input type="date" name="reg_univ_approval_date" value="{{ old('reg_univ_approval_date') }}" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">
            </div>
        </div>
        <div class="mt-6 flex justify-between">
            <button type="button" class="prev-btn border border-gray-300 text-gray-700 px-6 py-2 rounded" data-prev="academic-info">السابق</button>
            <button type="button" class="next-btn bg-zu-blue text-white px-6 py-2 rounded" data-next="thesis-info">التالي</button>
        </div>
    </div>

    <div id="thesis-info" class="tab-content hidden">
        <div class="grid grid-cols-1 gap-6">
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الرسالة باللغة العربية</label>
                <textarea name="thesis_title_ar" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue">{{ old('thesis_title_ar') }}</textarea>
            </div>
            <div>
                <label class="block text-sm font-bold text-gray-700 mb-2">عنوان الرسالة باللغة الإنجليزية</label>
                <textarea name="thesis_title_en" rows="2" class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue text-left" dir="ltr">{{ old('thesis_title_en') }}</textarea>
            </div>
        </div>
        <div class="mt-6 flex justify-between">
            <button type="button" class="prev-btn border border-gray-300 text-gray-700 px-6 py-2 rounded" data-prev="enrollment-info">السابق</button>
            <button type="submit" class="bg-zu-green hover:bg-green-700 text-white px-8 py-2 rounded font-bold shadow">حفظ السجل الأكاديمي</button>
        </div>
    </div>
</form>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.tab-btn');
        const nextBtns = document.querySelectorAll('.next-btn');
        const prevBtns = document.querySelectorAll('.prev-btn');
        const contents = document.querySelectorAll('.tab-content');

        function showTab(targetId) {
            contents.forEach(content => content.classList.add('hidden'));
            document.getElementById(targetId).classList.remove('hidden');

            tabBtns.forEach(btn => {
                if(btn.dataset.target === targetId) {
                    btn.classList.add('border-zu-maroon', 'text-zu-maroon', 'font-bold');
                    btn.classList.remove('border-transparent', 'text-gray-500');
                } else {
                    btn.classList.remove('border-zu-maroon', 'text-zu-maroon', 'font-bold');
                    btn.classList.add('border-transparent', 'text-gray-500');
                }
            });
        }

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => showTab(btn.dataset.target));
        });

        nextBtns.forEach(btn => {
            btn.addEventListener('click', () => showTab(btn.dataset.next));
        });

        prevBtns.forEach(btn => {
            btn.addEventListener('click', () => showTab(btn.dataset.prev));
        });
    });
</script>
@endsection