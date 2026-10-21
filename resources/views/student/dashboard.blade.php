@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto py-8 px-4">
    <!-- Header Card -->
    <div class="bg-[#003366] text-white p-6 rounded-lg shadow-md mb-8 border-b-4 border-[#800020]">
        <h1 class="text-3xl font-bold">لوحة تحكم الطالب الأكاديمية</h1>
        <p class="text-sm text-gray-200 mt-1">كلية الصيدلة - جامعة الزقازيق</p>
    </div>

    @if(!$student || !$program)
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-700 px-4 py-3 rounded">
            لا توجد بيانات أكاديمية مرتبطة بهذا الحساب حالياً. يرجى مراجعة الإدارة.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <!-- Basic Info -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200 md:col-span-2">
                <h3 class="text-xl font-bold text-[#003366] mb-4 border-b pb-2">البيانات الشخصية والمؤهل</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div><span class="font-bold text-gray-600">الاسم:</span> {{ $student->full_name }}</div>
                    <div><span class="font-bold text-gray-600">الرقم القومي:</span> {{ $student->national_id }}</div>
                    <div><span class="font-bold text-gray-600">كود الطالب:</span> {{ $student->student_code }}</div>
                    <div><span class="font-bold text-gray-600">المحمول:</span> {{ $student->mobile }}</div>
                    <div><span class="font-bold text-gray-600">البريد الإلكتروني:</span> {{ $student->email }}</div>
                    <div><span class="font-bold text-gray-600">المؤهل الدراسي:</span> {{ $student->previous_qualification }} ({{ $student->qualification_year }})</div>
                    <div><span class="font-bold text-gray-600">جهة الحصول:</span> {{ $student->qualification_institution }}</div>
                    <div><span class="font-bold text-gray-600">التقدير العام:</span> {{ $student->overall_grade }}</div>
                </div>
            </div>

           <!-- Program Status -->
            <div class="bg-[#F4F1EA] p-6 rounded-lg shadow border border-gray-300">
                <h3 class="text-xl font-bold text-[#800020] mb-4 border-b pb-2">حالة القيد والبرنامج</h3>
                <div class="text-sm space-y-3">
                    <div><span class="font-bold">نوع البرنامج:</span> 
                        <span class="bg-[#003366] text-white px-2 py-1 rounded text-xs">
                            @if($program->program_type == 'pre_master') تمهيدي ماجستير
                            @elseif($program->program_type == 'master') ماجستير
                            @else دكتوراه @endif
                        </span>
                    </div>
                    <div><span class="font-bold">تاريخ بداية القيد:</span> {{ $program->registration_start_date }}</div>
                    <div><span class="font-bold">مدة القيد (أيام):</span> {{ $program->registration_duration_days }}</div>
                    <div><span class="font-bold">مد القيد الإضافي:</span> {{ $program->extension_days }} يوم</div>
                    
                    <!-- تاريخ الانتهاء المحسوب -->
                    <div><span class="font-bold">تاريخ انتهاء القيد:</span> <span class="text-blue-900 font-bold">{{ $endDate ? $endDate->toDateString() : 'غير متوفر' }}</span></div>
                    
                    <!-- الحالة الديناميكية -->
                    <div><span class="font-bold">الحالة الأكاديمية:</span> <span class="{{ $statusColor }}">{{ $statusText }}</span></div>
                </div>
            </div>
        <!-- Approvals & Thesis -->
        <div class="bg-white p-6 rounded-lg shadow border border-gray-200 mb-8">
            <h3 class="text-xl font-bold text-[#003366] mb-4 border-b pb-2">الموافقات الأكاديمية وبيانات الرسالة</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm mb-6">
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">تاريخ موافقة المجالس على القيد:</h4>
                    <ul class="list-disc list-inside space-y-1 text-gray-600">
                        <li>مجلس القسم: {{ $program->department_enrollment_approval_date ?? 'غير متوفر' }}</li>
                        <li>لجنة الدراسات: {{ $program->postgraduate_enrollment_approval_date ?? 'غير متوفر' }}</li>
                        <li>مجلس الكلية: {{ $program->faculty_enrollment_approval_date ?? 'غير متوفر' }}</li>
                        <li>مجلس الجامعة: {{ $program->university_enrollment_approval_date ?? 'غير متوفر' }}</li>
                    </ul>
                </div>
                <div>
                    <h4 class="font-bold text-gray-800 mb-2">عنوان الرسالة ولجنة الإشراف:</h4>
                    <p class="mb-2"><span class="font-bold">عربي:</span> {{ $program->thesis_title_ar }}</p>
                    <p class="mb-2"><span class="font-bold">إنجليزي:</span> {{ $program->thesis_title_en }}</p>
                    <p><span class="font-bold">لجنة الإشراف:</span> {{ $program->supervisory_committee_members_text }}</p>
                </div>
            </div>
        </div>

        <!-- Extensions & Financials -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Extensions -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="text-xl font-bold text-[#003366] mb-4 border-b pb-2">سجلات المد والإيقاف</h3>
                @if($program->extensions->count() > 0)
                    <div class="space-y-3 text-sm">
                        @foreach($program->extensions as $ext)
                            <div class="p-3 bg-gray-50 rounded border">
                                <span class="font-bold text-[#800020]">مد رقم {{ $ext->extension_number }}:</span> {{ $ext->reason }}
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">لا توجد سجلات مد مسجلة.</p>
                @endif
            </div>

            <!-- Fees -->
            <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
                <h3 class="text-xl font-bold text-[#003366] mb-4 border-b pb-2">الرسوم الدراسية والإيصالات</h3>
                @if($program->feePayments->count() > 0)
                    <div class="space-y-3 text-sm">
                        @foreach($program->feePayments as $fee)
                            <div class="p-3 bg-gray-50 rounded border flex justify-between items-center">
                                <span>السنة الدراسية ({{ $fee->period_number }}): <b>{{ $fee->amount }} ج.م</b></span>
                                <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded">إيصال: {{ $fee->receipt_number }}</span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <p class="text-sm text-gray-500">لا توجد مدفوعات مسجلة.</p>
                @endif
            </div>
        </div>
    @endif
</div>
@endsection