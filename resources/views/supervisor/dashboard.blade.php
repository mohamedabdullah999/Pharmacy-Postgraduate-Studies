@extends('layouts.app')

@section('content')
<div class="mb-8">
    <h2 class="text-3xl font-bold text-[#003366]">لوحة المشرف: {{ $supervisor->full_name }}</h2>
    <p class="text-gray-600 mt-2">الطلاب المعينين تحت إشرافك.</p>
</div>

<div class="grid grid-cols-1 gap-6">
    @forelse($supervisor->students as $student)
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="bg-[#F4F1EA] px-6 py-4 border-b flex justify-between items-center">
            <h3 class="text-lg font-bold text-[#003366]">{{ $student->full_name }}</h3>
            <span class="text-sm text-gray-600">كود: {{ $student->student_code ?? '-' }}</span>
        </div>
        
        <div class="p-6">
            @forelse($student->programs as $program)
            <div class="mb-4 last:mb-0 pb-4 last:pb-0 border-b last:border-b-0">
                <div class="flex justify-between mb-2">
                    <span class="font-semibold text-gray-800">
                        @if($program->program_type === 'pre_master') تمهيدي ماجستير
                        @elseif($program->program_type === 'master') ماجستير
                        @else دكتوراه
                        @endif
                    </span>
                    <span class="text-sm font-bold text-[#800020]">{{ $program->expiry_info['status'] }}</span>
                </div>
                <div class="text-sm text-gray-600 grid grid-cols-2 gap-2">
                    <p>بداية القيد: {{ $program->registration_start_date ?? '-' }}</p>
                    <p>الانتهاء: {{ $program->expiry_info['end_date'] ?? '-' }}</p>
                </div>
            </div>
            @empty
            <p class="text-sm text-gray-500">لا توجد برامج مسجلة لهذا الطالب.</p>
            @endforelse
        </div>
    </div>
    @empty
    <div class="bg-white p-8 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
        لم يتم تعيين طلاب لك حتى الآن.
    </div>
    @endforelse
</div>
@endsection