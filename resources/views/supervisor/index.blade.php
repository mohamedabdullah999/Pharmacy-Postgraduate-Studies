@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-2xl font-bold text-zu-blue">إدارة هيئة الإشراف الأكاديمي</h1>
    <a href="{{ route('supervisors.create') }}" class="bg-zu-blue hover:bg-blue-900 text-white px-4 py-2 rounded shadow text-sm">
        + إضافة مشرف جديد
    </a>
</div>

<form method="GET" action="{{ route('supervisors.index') }}" class="mb-6 flex gap-2">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="ابحث باسم المشرف أو الرقم القومي..." class="border border-gray-300 rounded px-4 py-2 w-1/2 focus:outline-none focus:border-zu-blue">
    <button type="submit" class="bg-zu-maroon text-white px-4 py-2 rounded">بحث</button>
</form>

<div class="overflow-x-auto bg-white border border-gray-200 rounded shadow-sm">
    <table class="w-full text-right text-sm">
        <thead class="bg-zu-beige text-zu-blue border-b border-gray-200">
            <tr>
                <th class="p-3">اسم المشرف</th>
                <th class="p-3">الرقم القومي</th>
                <th class="p-3">الطلاب تحت الإشراف</th>
                <th class="p-3">حالة الحساب</th>
                <th class="p-3">إجراءات</th>
            </tr>
        </thead>
        <tbody>
            @forelse($supervisors as $supervisor)
            <tr class="border-b border-gray-100 hover:bg-gray-50">
                <td class="p-3 font-bold text-gray-700">{{ $supervisor->name }}</td>
                <td class="p-3">{{ $supervisor->national_id }}</td>
                <td class="p-3">
                    <span class="bg-blue-100 text-blue-800 py-1 px-2 rounded-full text-xs font-bold">{{ $supervisor->enrollments_count }} طلاب</span>
                </td>
                <td class="p-3">
                    @if($supervisor->activation_token)
                        <span class="text-orange-600 text-xs font-bold">كود التفعيل: {{ $supervisor->activation_token }}</span>
                    @else
                        <span class="text-zu-green text-xs font-bold">مفعل</span>
                    @endif
                </td>
                <td class="p-3">
                    <a href="{{ route('supervisors.show', $supervisor->id) }}" class="text-zu-blue hover:underline font-bold">إدارة الطلاب المرتبطين</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="p-6 text-center text-gray-500">لا يوجد مشرفين مسجلين.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $supervisors->links() }}
</div>
@endsection