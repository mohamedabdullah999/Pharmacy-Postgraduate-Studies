@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-2xl font-bold text-zu-blue">
        إدارة طلاب: 
        @if($programType == 'pre_master') تمهيدي ماجستير
        @elseif($programType == 'master') الماجستير
        @else الدكتوراه @endif
    </h1>
    <a href="{{ route('enrollments.create', $programType) }}" class="bg-zu-blue hover:bg-blue-900 text-white px-4 py-2 rounded shadow text-sm">
        + إضافة طالب جديد
    </a>
</div>

<form method="GET" action="{{ route('enrollments.index', $programType) }}" class="mb-6 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث بالاسم، الرقم القومي، أو الكود..." class="border border-gray-300 rounded px-4 py-2 w-1/2 focus:outline-none focus:border-zu-blue">
    <button type="submit" class="bg-zu-maroon text-white px-4 py-2 rounded">بحث</button>
</form>

<div class="overflow-x-auto bg-white border border-gray-200 rounded">
    <table class="w-full text-right text-sm">
        <thead class="bg-zu-beige text-zu-blue border-b border-gray-200">
            <tr>
                <th class="p-3">الكود</th>
                <th class="p-3">اسم الطالب</th>
                <th class="p-3">الرقم القومي</th>
                <th class="p-3">حالة القيد</th>
                <th class="p-3">التفعيل</th>
                <th class="p-3">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($enrollments as $enrollment)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-3">{{ $enrollment->student->student_code }}</td>
                <td class="p-3 font-semibold">{{ $enrollment->student->name }}</td>
                <td class="p-3">{{ $enrollment->student->national_id }}</td>
                <td class="p-3">
                    @if($enrollment->enrollment_status === 'ساري')
                        <span class="bg-green-100 text-zu-green px-2 py-1 rounded text-xs font-bold">ساري</span>
                    @else
                        <span class="bg-red-100 text-zu-maroon px-2 py-1 rounded text-xs font-bold">منتهي</span>
                    @endif
                </td>
                <td class="p-3">
                    @if($enrollment->activation_token)
                        <span class="text-orange-600 text-xs">كود التفعيل: {{ $enrollment->activation_token }}</span>
                    @else
                        <span class="text-zu-green text-xs">مفعل</span>
                    @endif
                </td>
                <td class="p-3">
                    <a href="{{ route('enrollments.show', $enrollment->id) }}" class="text-zu-blue hover:underline">عرض التفاصيل</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="p-6 text-center text-gray-500">لا توجد سجلات مطابقة.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $enrollments->links() }}
</div>
@endsection