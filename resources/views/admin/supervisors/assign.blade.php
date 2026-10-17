@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto bg-white p-8 rounded-lg shadow border border-gray-200">
    <h2 class="text-2xl font-bold text-[#003366] mb-6 border-b pb-4">تعيين طالب للمشرف: {{ $supervisor->full_name }}</h2>

    @if($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <ul class="list-disc list-inside">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.supervisors.assign', $supervisor) }}" method="POST">
        @csrf
        <div class="mb-6">
            <label class="block text-gray-700 font-bold mb-2">اختر الطالب (الغير معين له مسبقاً)</label>
            <select name="student_id" class="w-full border rounded px-3 py-2 focus:outline-none focus:border-[#003366]" required>
                <option value="">اختر طالب...</option>
                @foreach($students as $student)
                    <option value="{{ $student->id }}">{{ $student->full_name }} ({{ $student->national_id }})</option>
                @endforeach
            </select>
        </div>
        <div class="flex justify-end mt-6">
            <a href="{{ route('admin.supervisors.index') }}" class="text-gray-600 px-6 py-2 mr-4 hover:underline">إلغاء</a>
            <button type="submit" class="bg-[#800020] text-white px-6 py-2 rounded shadow hover:bg-red-800 transition">
                تعيين الطالب
            </button>
        </div>
    </form>
</div>
@endsection