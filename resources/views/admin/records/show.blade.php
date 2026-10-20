@extends('layouts.app')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-3xl font-bold text-[#003366]">تفاصيل السجل الأكاديمي</h2>
    <a href="{{ route('admin.dashboard') }}" class="text-gray-600 hover:underline">العودة للوحة التحكم</a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">
    <div class="col-span-1 bg-white p-6 rounded-lg shadow border-t-4 border-[#800020]">
        <h3 class="font-bold text-lg text-[#003366] mb-4 border-b pb-2">بيانات الطالب</h3>
        <p class="text-sm text-gray-500">الاسم</p>
        <p class="font-bold mb-3">{{ $program->student->full_name }}</p>
        <p class="text-sm text-gray-500">الرقم القومي</p>
        <p class="font-bold mb-3">{{ $program->student->national_id }}</p>
        <p class="text-sm text-gray-500">الكود</p>
        <p class="font-bold mb-3">{{ $program->student->student_code ?? '-' }}</p>
    </div>

    <div class="col-span-1 md:col-span-2 bg-white p-6 rounded-lg shadow border-t-4 border-[#003366]">
        <h3 class="font-bold text-lg text-[#003366] mb-4 border-b pb-2">بيانات القيد والمدة</h3>
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="text-sm text-gray-500">البرنامج</p>
                <p class="font-bold">{{ $program->program_type }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">بداية القيد</p>
                <p class="font-bold">{{ $program->registration_start_date }}</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">المدة الأساسية</p>
                <p class="font-bold">{{ $program->registration_duration_days }} يوم</p>
            </div>
            <div>
                <p class="text-sm text-gray-500">المد المضاف</p>
                <p class="font-bold text-[#800020]">{{ $program->extension_days }} يوم</p>
            </div>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
    
    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="font-bold text-lg text-[#003366] mb-4">تسجيل مد جديد</h3>
        <form action="{{ route('admin.records.extensions.store', $program) }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-bold mb-1">رقم المد (1-5)</label>
                    <input type="number" name="extension_number" min="1" max="5" class="w-full border rounded px-3 py-2" required>
                </div>
                <div>
                    <label class="block text-sm font-bold mb-1">عدد الأيام</label>
                    <input type="number" name="granted_days" min="1" class="w-full border rounded px-3 py-2" required>
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">السبب</label>
                <input type="text" name="reason" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">موافقة الجامعة</label>
                <input type="date" name="university_council_approval_date" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-[#003366] text-white px-4 py-2 rounded w-full">إضافة المد</button>
        </form>
    </div>

    <div class="bg-white p-6 rounded-lg shadow border border-gray-200">
        <h3 class="font-bold text-lg text-[#800020] mb-4">تسجيل إيقاف قيد</h3>
        <form action="{{ route('admin.records.suspensions.store', $program) }}" method="POST">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">رقم الإيقاف (1-5)</label>
                <input type="number" name="suspension_number" min="1" max="5" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">السبب</label>
                <input type="text" name="reason" class="w-full border rounded px-3 py-2" required>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-bold mb-1">موافقة الجامعة</label>
                <input type="date" name="university_council_approval_date" class="w-full border rounded px-3 py-2">
            </div>
            <button type="submit" class="bg-[#800020] text-white px-4 py-2 rounded w-full">إضافة الإيقاف</button>
        </form>
    </div>

</div>

<div class="mt-8 bg-white p-6 rounded-lg shadow border-t-4 border-[#003366]">
    <h3 class="font-bold text-xl text-[#003366] mb-6 border-b pb-2">السجلات المالية والرسوم</h3>
    
    <form action="{{ route('admin.records.fees.store', $program) }}" method="POST" class="mb-8 bg-[#F4F1EA] p-4 rounded border border-gray-200">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-5 gap-4 items-end">
            <div>
                <label class="block text-sm font-bold mb-1">نوع الرسوم</label>
                <select name="fee_type" class="w-full border rounded px-3 py-2" required>
                    <option value="tuition">رسوم دراسية</option>
                    <option value="extension">رسوم مد</option>
                    <option value="suspension">رسوم إيقاف</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">رقم الفترة / السنة</label>
                <input type="number" name="period_number" min="1" class="w-full border rounded px-3 py-2" required placeholder="مثال: 1">
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">المبلغ</label>
                <input type="number" step="0.01" name="amount" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">تاريخ الدفع</label>
                <input type="date" name="payment_date" class="w-full border rounded px-3 py-2" required>
            </div>
            <div>
                <label class="block text-sm font-bold mb-1">رقم الإيصال</label>
                <input type="text" name="receipt_number" class="w-full border rounded px-3 py-2" required>
            </div>
        </div>
        <div class="mt-4 text-left">
            <button type="submit" class="bg-[#003366] text-white px-6 py-2 rounded font-bold hover:bg-blue-900">إضافة الإيصال</button>
        </div>
    </form>

    <div class="overflow-x-auto">
        <table class="w-full text-right border-collapse border border-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="p-3 border-b">نوع الرسوم</th>
                    <th class="p-3 border-b">الفترة/السنة</th>
                    <th class="p-3 border-b">المبلغ</th>
                    <th class="p-3 border-b">تاريخ الدفع</th>
                    <th class="p-3 border-b">رقم الإيصال</th>
                </tr>
            </thead>
            <tbody>
                @forelse($program->feePayments as $fee)
                <tr class="hover:bg-gray-50">
                    <td class="p-3 border-b">
                        @if($fee->fee_type === 'tuition') رسوم دراسية
                        @elseif($fee->fee_type === 'extension') رسوم مد
                        @elseif($fee->fee_type === 'suspension') رسوم إيقاف
                        @endif
                    </td>
                    <td class="p-3 border-b">{{ $fee->period_number }}</td>
                    <td class="p-3 border-b">{{ $fee->amount }} ج.م</td>
                    <td class="p-3 border-b">{{ $fee->payment_date }}</td>
                    <td class="p-3 border-b font-bold">{{ $fee->receipt_number }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="p-6 text-center text-gray-500">لا توجد سجلات مالية مسجلة.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection