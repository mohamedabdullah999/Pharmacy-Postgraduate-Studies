@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-[#003366]">مرحباً، {{ $student->full_name }}</h2>
    <p class="text-gray-600 mt-2">الكود: <span class="font-bold">{{ $student->student_code ?? 'غير محدد' }}</span></p>
</div>

<div class="grid grid-cols-1 gap-6">
    @forelse($student->programs as $program)
    <div class="bg-white rounded-lg shadow-sm border-t-4 border-[#800020] p-6">
        <div class="flex justify-between items-start mb-6 border-b pb-4">
            <div>
                <h3 class="text-xl font-bold text-[#003366]">
                    برنامج: 
                    @if($program->program_type === 'pre_master') تمهيدي ماجستير
                    @elseif($program->program_type === 'master') ماجستير
                    @else دكتوراه
                    @endif
                </h3>
            </div>
            <span class="px-4 py-2 rounded-full text-sm font-bold text-white
                @if($program->expiry_info['status'] === 'ساري القيد') bg-[#578B2E]
                @elseif($program->expiry_info['status'] === 'القيد اقترب من الانتهاء') bg-yellow-600
                @elseif($program->expiry_info['status'] === 'انتهى القيد') bg-[#800020]
                @else bg-gray-500 @endif">
                {{ $program->expiry_info['status'] }}
            </span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <p class="text-gray-500 text-sm">تاريخ بداية القيد</p>
                <p class="font-semibold">{{ $program->registration_start_date ?? 'غير محدد' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">تاريخ انتهاء القيد</p>
                <p class="font-semibold">{{ $program->expiry_info['end_date'] ?? 'غير محدد' }}</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">المدة بالأيام</p>
                <p class="font-semibold">{{ $program->registration_duration_days ?? 0 }} يوم</p>
            </div>
            <div>
                <p class="text-gray-500 text-sm">المد الإضافي</p>
                <p class="font-semibold">{{ $program->extension_days ?? 0 }} يوم</p>
            </div>
            @if($program->thesis_title_ar)
            <div class="col-span-1 md:col-span-2 mt-4 pt-4 border-t">
                <p class="text-gray-500 text-sm">عنوان الرسالة</p>
                <p class="font-bold text-[#003366]">{{ $program->thesis_title_ar }}</p>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
        لا توجد سجلات أكاديمية مسجلة حالياً.
    </div>
    @endforelse
</div>
@endsection