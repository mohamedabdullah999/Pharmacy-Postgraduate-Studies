@extends('layouts.app')

@section('content')
<div class="border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-2xl font-bold text-zu-blue">إضافة مشرف أكاديمي جديد</h1>
    <p class="text-sm text-gray-500 mt-1">سيتم توليد كود تفعيل خاص بالمشرف لإنشاء حسابه الخاص لاحقاً.</p>
</div>

@if ($errors->any())
    <div class="bg-red-50 border border-red-200 text-zu-maroon p-4 rounded mb-6">
        <ul class="list-disc list-inside text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('supervisors.store') }}" class="bg-white border border-gray-200 rounded p-6 shadow-sm max-w-2xl mx-auto">
    @csrf
    <div class="space-y-6">
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">اسم المشرف (الدرجة العلمية والاسم) <span class="text-red-500">*</span></label>
            <input type="text" name="name" value="{{ old('name') }}" placeholder="أ.د. / د. ..." required class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
        </div>
        <div>
            <label class="block text-sm font-bold text-gray-700 mb-2">الرقم القومي (14 رقم) <span class="text-red-500">*</span></label>
            <input type="text" name="national_id" value="{{ old('national_id') }}" maxlength="14" required class="w-full border border-gray-300 rounded px-3 py-2 focus:border-zu-blue focus:ring-1 focus:ring-zu-blue">
        </div>
        
        <div class="flex justify-end gap-2 pt-4 border-t border-gray-100">
            <a href="{{ route('supervisors.index') }}" class="px-6 py-2 border border-gray-300 text-gray-700 rounded">إلغاء</a>
            <button type="submit" class="px-6 py-2 bg-zu-blue text-white rounded font-bold">تسجيل المشرف</button>
        </div>
    </div>
</form>
@endsection