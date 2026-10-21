@extends('layouts.app')

@section('content')
<div class="border-b border-gray-200 pb-4 mb-6 flex justify-between items-end">
    <div>
        <h1 class="text-2xl font-bold text-zu-blue">ملف المشرف: {{ $supervisor->name }}</h1>
        <p class="text-sm text-gray-500 mt-1">الرقم القومي: {{ $supervisor->national_id }}</p>
    </div>
    <div class="text-left">
        @if($supervisor->activation_token)
            <span class="bg-orange-100 text-orange-800 px-3 py-1 rounded text-sm">الحساب غير مفعل - كود: {{ $supervisor->activation_token }}</span>
        @else
            <span class="bg-green-100 text-green-800 px-3 py-1 rounded text-sm">الحساب مفعل ومربوط بنظام الدخول</span>
        @endif
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    
    <div class="md:col-span-2 bg-white border border-gray-200 rounded shadow-sm p-4">
        <h2 class="text-lg font-bold text-zu-maroon mb-4 border-b pb-2">الطلاب المسندين للإشراف ({{ $supervisor->enrollments->count() }})</h2>
        
        @if($supervisor->enrollments->count() > 0)
            <div class="space-y-3">
                @foreach($supervisor->enrollments as $enrollment)
                    <div class="flex justify-between items-center bg-gray-50 border border-gray-200 p-3 rounded">
                        <div>
                            <p class="font-bold text-zu-blue text-sm">
                                {{ $enrollment->student->name }} 
                                <span class="text-xs text-gray-500 ml-2">({{ $enrollment->student->student_code }})</span>
                            </p>
                            <p class="text-xs text-gray-500 mt-1">
                                البرنامج: 
                                @if($enrollment->program_type == 'pre_master') تمهيدي 
                                @elseif($enrollment->program_type == 'master') ماجستير 
                                @else دكتوراه @endif
                            </p>
                        </div>
                        <div class="flex gap-2">
                            <a href="{{ route('enrollments.show', $enrollment->id) }}" class="text-xs bg-zu-beige text-zu-blue px-2 py-1 rounded hover:bg-gray-200">عرض الملف</a>
                            <form method="POST" action="{{ route('supervisors.remove_student', [$supervisor->id, $enrollment->id]) }}" onsubmit="return confirm('هل أنت متأكد من فك ارتباط هذا الطالب؟');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-xs bg-red-100 text-red-700 px-2 py-1 rounded hover:bg-red-200">فك الارتباط</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <p class="text-gray-500 italic p-4 text-center bg-gray-50 rounded">لا يوجد طلاب مسندين لهذا المشرف حالياً.</p>
        @endif
    </div>

    <div class="bg-zu-beige border border-gray-200 rounded shadow-sm p-4 h-fit">
        <h2 class="text-lg font-bold text-zu-blue mb-4 border-b pb-2 border-gray-300">إسناد طلاب جدد</h2>
        
        <form method="POST" action="{{ route('supervisors.assign', $supervisor->id) }}">
            @csrf
            <div class="mb-4">
                <label class="block text-sm text-gray-700 font-bold mb-2">اختر الطلاب (يمكن اختيار أكثر من طالب)</label>
                <select name="enrollment_ids[]" multiple class="w-full border border-gray-300 rounded p-2 text-sm h-64 focus:border-zu-maroon" required>
                    @foreach($availableEnrollments as $avail)
                        <option value="{{ $avail->id }}">
                            {{ $avail->student->name }} - 
                            @if($avail->program_type == 'pre_master') (تمهيدي) 
                            @elseif($avail->program_type == 'master') (ماجستير) 
                            @else (دكتوراه) @endif
                        </option>
                    @endforeach
                </select>
                <p class="text-xs text-gray-500 mt-2">اضغط على Ctrl أو Cmd لتحديد أكثر من طالب.</p>
            </div>
            
            <button type="submit" class="w-full bg-zu-green hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow">
                ربط الطلاب المحددين
            </button>
        </form>
    </div>
</div>
@endsection