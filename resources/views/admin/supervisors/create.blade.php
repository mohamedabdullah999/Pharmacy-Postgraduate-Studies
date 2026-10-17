@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
    <h2 class="text-2xl font-bold text-[#003366] mb-6 border-b pb-4">إضافة مشرف جديد</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.supervisors.store') }}" method="POST">
        @csrf
        <div class="mb-4">
            <label class="block text-gray-700 font-bold mb-2">الاسم الرباعي</label>
            <input type="text" name="full_name" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
        </div>
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">الرقم القومي</label>
            <input type="text" name="national_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required maxlength="14">
            <p class="text-sm text-gray-500 mt-1">يُستخدم للتحقق أثناء تفعيل حساب المشرف.</p>
        </div>
        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.supervisors.index') }}" class="text-gray-600 px-6 py-2 mr-4 hover:underline">إلغاء</a>
            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded shadow hover:bg-blue-900 transition">
                حفظ المشرف
            </button>
        </div>
    </form>
</div>
@endsection