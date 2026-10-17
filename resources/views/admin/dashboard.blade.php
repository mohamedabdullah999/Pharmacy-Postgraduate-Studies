@extends('layouts.app')

@section('content')
<div class="mb-8 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
    <h2 class="text-3xl font-bold text-[#003366]">لوحة تحكم الإدارة</h2>
    <a href="{{ route('admin.records.create') }}" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition whitespace-nowrap">
        إضافة سجل جديد
    </a>
</div>

<div class="bg-white p-4 rounded-lg shadow-sm border border-gray-200 mb-6">
    <form action="{{ route('admin.dashboard') }}" method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="بحث بالاسم، الرقم القومي، أو الكود..." class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
        </div>
        <div>
            <select name="program_type" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
                <option value="">كل البرامج</option>
                <option value="pre_master" {{ request('program_type') == 'pre_master' ? 'selected' : '' }}>تمهيدي ماجستير</option>
                <option value="master" {{ request('program_type') == 'master' ? 'selected' : '' }}>ماجستير</option>
                <option value="doctorate" {{ request('program_type') == 'doctorate' ? 'selected' : '' }}>دكتوراه</option>
            </select>
        </div>
        <div>
            <select name="expiry_status" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]">
                <option value="">كل حالات القيد</option>
                <option value="ساري القيد" {{ request('expiry_status') == 'ساري القيد' ? 'selected' : '' }}>ساري القيد</option>
                <option value="القيد اقترب من الانتهاء" {{ request('expiry_status') == 'القيد اقترب من الانتهاء' ? 'selected' : '' }}>القيد اقترب من الانتهاء</option>
                <option value="انتهى القيد" {{ request('expiry_status') == 'انتهى القيد' ? 'selected' : '' }}>انتهى القيد</option>
                <option value="بيانات القيد غير مكتملة" {{ request('expiry_status') == 'بيانات القيد غير مكتملة' ? 'selected' : '' }}>بيانات القيد غير مكتملة</option>
            </select>
        </div>
        <div class="flex gap-2">
            <button type="submit" class="bg-[#800020] text-white px-4 py-2 rounded shadow hover:bg-red-800 transition w-full">
                تصفية
            </button>
            <a href="{{ route('admin.dashboard') }}" class="bg-gray-200 text-gray-700 px-4 py-2 rounded shadow hover:bg-gray-300 transition text-center w-full">
                إلغاء
            </a>
        </div>
    </form>
</div>

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead class="bg-[#003366] text-white">
                <tr>
                    <th class="p-4 font-semibold">الكود</th>
                    <th class="p-4 font-semibold">الاسم</th>
                    <th class="p-4 font-semibold">البرنامج</th>
                    <th class="p-4 font-semibold">تاريخ بداية القيد</th>
                    <th class="p-4 font-semibold">تاريخ الانتهاء</th>
                    <th class="p-4 font-semibold">حالة القيد</th>
                    <th class="p-4 font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($programs as $program)
                <tr class="hover:bg-[#F4F1EA] transition duration-150">
                    <td class="p-4">{{ $program->student->student_code ?? '-' }}</td>
                    <td class="p-4 font-medium">{{ $program->student->full_name }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-sm bg-gray-200 text-gray-800">
                            @if($program->program_type === 'pre_master') تمهيدي ماجستير
                            @elseif($program->program_type === 'master') ماجستير
                            @else دكتوراه
                            @endif
                        </span>
                    </td>
                    <td class="p-4">{{ $program->registration_start_date ?? 'غير محدد' }}</td>
                    <td class="p-4">{{ $program->expiry_info['end_date'] ?? 'غير محدد' }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-sm text-white
                            @if($program->expiry_info['status'] === 'ساري القيد') bg-[#578B2E]
                            @elseif($program->expiry_info['status'] === 'القيد اقترب من الانتهاء') bg-yellow-600
                            @elseif($program->expiry_info['status'] === 'انتهى القيد') bg-[#800020]
                            @else bg-gray-500 @endif">
                            {{ $program->expiry_info['status'] }}
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="#" class="text-[#003366] hover:underline">عرض التفاصيل</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="p-8 text-center text-gray-500">
                        لا توجد سجلات مطابقة للبحث.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200">
        {{ $programs->links() }}
    </div>
</div>
@endsection