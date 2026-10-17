@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-[#003366]">لوحة تحكم الإدارة</h2>
    <button class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition">
        إضافة سجل جديد
    </button>
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
                        لا توجد سجلات أكاديمية حتى الآن.
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