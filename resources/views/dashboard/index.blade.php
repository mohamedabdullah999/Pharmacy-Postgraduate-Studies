@extends('layouts.app')

@section('content')
<div class="border-b border-gray-200 pb-4 mb-6">
    <h1 class="text-2xl font-bold text-zu-blue">لوحة الإحصائيات العامة</h1>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
    <div class="bg-zu-beige border-t-4 border-zu-blue p-6 rounded shadow-sm text-center">
        <h3 class="text-gray-600 text-sm font-bold">تمهيدي ماجستير</h3>
        <p class="text-4xl text-zu-blue mt-2 font-bold">{{ $stats['pre_master'] }}</p>
    </div>
    <div class="bg-zu-beige border-t-4 border-zu-maroon p-6 rounded shadow-sm text-center">
        <h3 class="text-gray-600 text-sm font-bold">الماجستير</h3>
        <p class="text-4xl text-zu-maroon mt-2 font-bold">{{ $stats['master'] }}</p>
    </div>
    <div class="bg-zu-beige border-t-4 border-zu-gold p-6 rounded shadow-sm text-center">
        <h3 class="text-gray-600 text-sm font-bold">الدكتوراه</h3>
        <p class="text-4xl text-yellow-700 mt-2 font-bold">{{ $stats['phd'] }}</p>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <div class="bg-white border border-gray-200 p-6 rounded shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-gray-600 font-bold">إجمالي المشرفين</h3>
            <p class="text-sm text-gray-500">المسجلين بالنظام</p>
        </div>
        <p class="text-3xl text-zu-blue font-bold">{{ $stats['supervisors'] }}</p>
    </div>
    
    <div class="bg-red-50 border border-red-200 p-6 rounded shadow-sm flex items-center justify-between">
        <div>
            <h3 class="text-red-800 font-bold">حسابات غير مفعلة</h3>
            <p class="text-sm text-red-600">طلاب بانتظار التفعيل</p>
        </div>
        <p class="text-3xl text-zu-maroon font-bold">{{ $stats['inactive_accounts'] }}</p>
    </div>
</div>
@endsection