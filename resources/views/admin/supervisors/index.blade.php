@extends('layouts.app')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-[#003366]">إدارة المشرفين</h2>
    <a href="{{ route('admin.supervisors.create') }}" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition">
        إضافة مشرف جديد
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse">
            <thead class="bg-[#003366] text-white">
                <tr>
                    <th class="p-4 font-semibold">الاسم</th>
                    <th class="p-4 font-semibold">الرقم القومي</th>
                    <th class="p-4 font-semibold">عدد الطلاب المعينين</th>
                    <th class="p-4 font-semibold">الإجراءات</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($supervisors as $supervisor)
                <tr class="hover:bg-[#F4F1EA] transition duration-150">
                    <td class="p-4 font-medium">{{ $supervisor->full_name }}</td>
                    <td class="p-4">{{ $supervisor->national_id }}</td>
                    <td class="p-4">
                        <span class="px-3 py-1 rounded-full text-sm bg-gray-200 text-gray-800">
                            {{ $supervisor->students_count }} طالب
                        </span>
                    </td>
                    <td class="p-4">
                        <a href="{{ route('admin.supervisors.assign.form', $supervisor) }}" class="text-[#800020] hover:underline font-bold">تعيين طالب</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-8 text-center text-gray-500">
                        لا يوجد مشرفين مسجلين حتى الآن.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="p-4 border-t border-gray-200">
        {{ $supervisors->links() }}
    </div>
</div>
@endsection