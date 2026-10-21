@extends('layouts.app')

@section('content')
<div class="flex justify-between items-center border-b border-gray-200 pb-4 mb-6">
    <div>
        <h1 class="text-2xl font-bold text-zu-blue flex items-center gap-2">
            ملف الطالب: {{ $enrollment->student->name }}
            @if($enrollment->enrollment_status === 'ساري')
                <span class="bg-green-100 text-zu-green px-3 py-1 rounded-full text-sm font-bold shadow-sm">ساري</span>
            @else
                <span class="bg-red-100 text-zu-maroon px-3 py-1 rounded-full text-sm font-bold shadow-sm">منتهي</span>
            @endif
        </h1>
        <p class="text-sm text-gray-500 mt-1">
            كود الطالب: <span class="font-bold">{{ $enrollment->student->student_code }}</span> | 
            البرنامج: 
            <span class="font-bold text-zu-maroon">
                @if($enrollment->program_type == 'pre_master') تمهيدي ماجستير
                @elseif($enrollment->program_type == 'master') الماجستير
                @else الدكتوراه @endif
            </span>
        </p>
    </div>
    
    @if(auth()->user()->role === 'admin')
    <div class="flex gap-2">
        <a href="#" class="bg-zu-gold hover:bg-yellow-500 text-zu-blue font-bold px-4 py-2 rounded shadow text-sm">تعديل السجل</a>
    </div>
    @endif
</div>

<div class="flex flex-col md:flex-row gap-6">
    
    <aside class="w-full md:w-64 shrink-0 bg-white border border-gray-200 rounded shadow-sm">
        <nav class="flex flex-col p-2 space-y-1" id="details-tabs">
            <button class="detail-tab-btn active text-right w-full px-4 py-3 rounded bg-zu-beige text-zu-blue font-bold border-r-4 border-zu-maroon transition-all" data-target="sec-personal">البيانات الشخصية والمؤهل</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-enrollment">القيد والموافقات</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-thesis">الرسالة والمشرفين</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-extensions">المدود ({{ $enrollment->extensions->count() }})</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-suspensions">الإيقافات ({{ $enrollment->suspensions->count() }})</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-committee">المناقشة والمنح</button>
            <button class="detail-tab-btn text-right w-full px-4 py-3 rounded text-gray-600 hover:bg-gray-50 border-r-4 border-transparent hover:border-gray-300 transition-all" data-target="sec-fees">الرسوم الدراسية ({{ $enrollment->fees->count() }})</button>
        </nav>
    </aside>

    <div class="flex-1 bg-white border border-gray-200 rounded shadow-sm p-6 min-h-[500px]">
        
        <div id="sec-personal" class="detail-content block">
            <h2 class="text-xl font-bold text-zu-blue border-b-2 border-zu-gold pb-2 mb-6">البيانات الشخصية والمؤهل</h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8">
                <div><span class="text-gray-500 block text-sm">الرقم القومي</span><span class="font-bold">{{ $enrollment->student->national_id }}</span></div>
                <div><span class="text-gray-500 block text-sm">تاريخ الميلاد</span><span class="font-bold">{{ $enrollment->student->dob ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">محافظة الميلاد</span><span class="font-bold">{{ $enrollment->student->birth_governorate ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">رقم المحمول</span><span class="font-bold">{{ $enrollment->student->mobile_number ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">البريد الإلكتروني</span><span class="font-bold">{{ $enrollment->student->email ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">الوظيفة الحالية</span><span class="font-bold">{{ $enrollment->student->current_job ?? 'غير مدخل' }}</span></div>
                <div class="md:col-span-2"><span class="text-gray-500 block text-sm">العنوان الحالي</span><span class="font-bold">{{ $enrollment->student->current_address ?? 'غير مدخل' }}</span></div>
            </div>

            <h3 class="text-lg font-bold text-zu-maroon mt-8 mb-4">بيانات المؤهل السابق</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-4 gap-x-8 bg-zu-beige p-4 rounded">
                <div><span class="text-gray-500 block text-sm">المؤهل</span><span class="font-bold">{{ $enrollment->student->academic_degree ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">جهة الحصول عليه</span><span class="font-bold">{{ $enrollment->student->degree_institution ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">سنة الحصول</span><span class="font-bold">{{ $enrollment->student->degree_year ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">التقدير العام</span><span class="font-bold">{{ $enrollment->student->general_grade ?? 'غير مدخل' }}</span></div>
                <div><span class="text-gray-500 block text-sm">تقدير التخصص</span><span class="font-bold">{{ $enrollment->student->specialization_grade ?? 'غير مدخل' }}</span></div>
            </div>
        </div>

        <div id="sec-enrollment" class="detail-content hidden">
            <h2 class="text-xl font-bold text-zu-blue border-b-2 border-zu-gold pb-2 mb-6">موافقات القيد والتسجيل</h2>
            
            <div class="bg-gray-50 p-4 rounded border border-gray-200 mb-6 flex justify-between items-center">
                <div>
                    <span class="text-gray-500 block text-sm">تاريخ بدء القيد النظامي</span>
                    <span class="font-bold text-lg text-zu-blue">{{ $enrollment->enrollment_start_date ? $enrollment->enrollment_start_date->format('Y-m-d') : 'غير محدد' }}</span>
                </div>
                <div class="text-left">
                    <span class="text-gray-500 block text-sm">تاريخ الانتهاء المحسوب</span>
                    <span class="font-bold text-lg text-zu-maroon">{{ $enrollment->enrollment_end_date ?? 'غير محدد' }}</span>
                </div>
            </div>

            @if(in_array($enrollment->program_type, ['pre_master', 'master']))
            <h3 class="text-lg font-bold text-zu-maroon mb-4">مرحلة القيد</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                <div class="border p-3 rounded">موافقة القسم: <span class="font-bold float-left">{{ $enrollment->enroll_dept_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الدراسات: <span class="font-bold float-left">{{ $enrollment->enroll_studies_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الكلية: <span class="font-bold float-left">{{ $enrollment->enroll_faculty_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الجامعة: <span class="font-bold float-left">{{ $enrollment->enroll_univ_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded md:col-span-2 bg-yellow-50">انتهاء المقررات التمهيدية: <span class="font-bold float-left">{{ $enrollment->preliminary_courses_end_date ?? '---' }}</span></div>
            </div>
            @endif

            <h3 class="text-lg font-bold text-zu-maroon mb-4">مرحلة التسجيل</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="border p-3 rounded">موافقة القسم: <span class="font-bold float-left">{{ $enrollment->reg_dept_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الدراسات: <span class="font-bold float-left">{{ $enrollment->reg_studies_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الكلية: <span class="font-bold float-left">{{ $enrollment->reg_faculty_approval_date ?? '---' }}</span></div>
                <div class="border p-3 rounded">موافقة الجامعة: <span class="font-bold float-left">{{ $enrollment->reg_univ_approval_date ?? '---' }}</span></div>
            </div>
        </div>

        <div id="sec-thesis" class="detail-content hidden">
            <h2 class="text-xl font-bold text-zu-blue border-b-2 border-zu-gold pb-2 mb-6">بيانات الرسالة ولجنة الإشراف</h2>
            
            <div class="bg-zu-beige p-6 rounded shadow-inner mb-6">
                <div class="mb-4">
                    <span class="text-gray-500 block text-sm mb-1">عنوان الرسالة (عربي)</span>
                    <p class="font-bold text-lg">{{ $enrollment->thesis_title_ar ?? 'لم يتم تحديد العنوان بعد' }}</p>
                </div>
                <div>
                    <span class="text-gray-500 block text-sm mb-1">عنوان الرسالة (إنجليزي)</span>
                    <p class="font-bold text-lg" dir="ltr">{{ $enrollment->thesis_title_en ?? 'Title not set yet' }}</p>
                </div>
            </div>

            <h3 class="text-lg font-bold text-zu-maroon mb-4">لجنة الإشراف المسجلة</h3>
            @if($enrollment->supervisors->count() > 0)
                <ul class="list-disc list-inside space-y-2 bg-white border border-gray-200 p-4 rounded">
                    @foreach($enrollment->supervisors as $supervisor)
                        <li class="font-bold text-gray-700">{{ $supervisor->name }}</li>
                    @endforeach
                </ul>
            @else
                <p class="text-gray-500 italic">لم يتم ربط مشرفين بهذا الطالب حتى الآن.</p>
            @endif
        </div>

        <div id="sec-extensions" class="detail-content hidden">
            <div class="flex justify-between items-center border-b-2 border-zu-gold pb-2 mb-6">
                <h2 class="text-xl font-bold text-zu-blue">حركات المد</h2>
                @if(auth()->user()->role === 'admin')
                    <button class="bg-zu-blue text-white px-3 py-1 rounded text-sm shadow">إضافة مد جديد</button>
                @endif
            </div>

            @forelse($enrollment->extensions as $extension)
                <div class="border border-gray-200 rounded p-4 mb-4">
                    <h3 class="font-bold text-zu-maroon mb-2 border-b pb-2">مد رقم ({{ $extension->extension_number }}) - السبب: {{ $extension->reason ?? 'غير محدد' }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm">
                        <div><span class="text-gray-500 block text-xs">القسم</span><span class="font-bold">{{ $extension->dept_approval_date ?? '---' }}</span></div>
                        <div><span class="text-gray-500 block text-xs">الدراسات</span><span class="font-bold">{{ $extension->studies_approval_date ?? '---' }}</span></div>
                        <div><span class="text-gray-500 block text-xs">الكلية</span><span class="font-bold">{{ $extension->faculty_approval_date ?? '---' }}</span></div>
                        <div><span class="text-gray-500 block text-xs">الجامعة</span><span class="font-bold">{{ $extension->univ_approval_date ?? '---' }}</span></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic text-center p-6 bg-gray-50 rounded border">لا توجد حركات مد مسجلة لهذا الطالب.</p>
            @endforelse
        </div>

        <div id="sec-suspensions" class="detail-content hidden">
            <div class="flex justify-between items-center border-b-2 border-zu-gold pb-2 mb-6">
                <h2 class="text-xl font-bold text-zu-blue">حركات الإيقاف</h2>
                @if(auth()->user()->role === 'admin')
                    <button class="bg-zu-blue text-white px-3 py-1 rounded text-sm shadow">إضافة إيقاف جديد</button>
                @endif
            </div>

            @forelse($enrollment->suspensions as $suspension)
                <div class="border border-red-200 bg-red-50 rounded p-4 mb-4">
                    <h3 class="font-bold text-red-800 mb-2 border-b border-red-200 pb-2">إيقاف رقم ({{ $suspension->suspension_number }}) - السبب: {{ $suspension->reason ?? 'غير محدد' }}</h3>
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-2 text-sm text-red-900">
                        <div><span class="opacity-70 block text-xs">القسم</span><span class="font-bold">{{ $suspension->dept_approval_date ?? '---' }}</span></div>
                        <div><span class="opacity-70 block text-xs">الدراسات</span><span class="font-bold">{{ $suspension->studies_approval_date ?? '---' }}</span></div>
                        <div><span class="opacity-70 block text-xs">الكلية</span><span class="font-bold">{{ $suspension->faculty_approval_date ?? '---' }}</span></div>
                        <div><span class="opacity-70 block text-xs">الجامعة</span><span class="font-bold">{{ $suspension->univ_approval_date ?? '---' }}</span></div>
                    </div>
                </div>
            @empty
                <p class="text-gray-500 italic text-center p-6 bg-gray-50 rounded border">لا توجد حركات إيقاف مسجلة لهذا الطالب.</p>
            @endforelse
        </div>

        <div id="sec-committee" class="detail-content hidden">
            <h2 class="text-xl font-bold text-zu-blue border-b-2 border-zu-gold pb-2 mb-6">لجنة الحكم والمناقشة والمنح</h2>
            
            <div class="mb-6">
                <label class="text-gray-500 block text-sm mb-2">أعضاء لجنة الحكم والمناقشة</label>
                <div class="bg-gray-50 border border-gray-200 p-4 rounded min-h-[100px]">
                    {!! nl2br(e($enrollment->discussion_committee ?? 'لم يتم تشكيل لجنة بعد.')) !!}
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-zu-maroon mb-4">موافقات التشكيل</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between border-b pb-1"><span>القسم:</span> <strong>{{ $enrollment->form_dept_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الدراسات:</span> <strong>{{ $enrollment->form_studies_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الكلية:</span> <strong>{{ $enrollment->form_faculty_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الجامعة:</span> <strong>{{ $enrollment->form_univ_approval_date ?? '---' }}</strong></li>
                    </ul>
                </div>
                <div>
                    <h3 class="text-lg font-bold text-zu-green mb-4">موافقات المنح</h3>
                    <ul class="space-y-3">
                        <li class="flex justify-between border-b pb-1"><span>القسم:</span> <strong>{{ $enrollment->grant_dept_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الدراسات:</span> <strong>{{ $enrollment->grant_studies_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الكلية:</span> <strong>{{ $enrollment->grant_faculty_approval_date ?? '---' }}</strong></li>
                        <li class="flex justify-between border-b pb-1"><span>الجامعة:</span> <strong>{{ $enrollment->grant_univ_approval_date ?? '---' }}</strong></li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="sec-fees" class="detail-content hidden">
            <div class="flex justify-between items-center border-b-2 border-zu-gold pb-2 mb-6">
                <h2 class="text-xl font-bold text-zu-blue">سجل سداد الرسوم</h2>
                @if(auth()->user()->role === 'admin')
                    <button class="bg-zu-blue text-white px-3 py-1 rounded text-sm shadow">إضافة إيصال جديد</button>
                @endif
            </div>

            @if($enrollment->fees->count() > 0)
                <table class="w-full text-right text-sm border border-gray-200">
                    <thead class="bg-gray-100 text-gray-700">
                        <tr>
                            <th class="p-3 border-b">بيان الرسوم (النوع)</th>
                            <th class="p-3 border-b">رقم الإيصال</th>
                            <th class="p-3 border-b">تاريخ السداد</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($enrollment->fees as $fee)
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3 font-bold text-zu-blue">{{ $fee->fee_type }}</td>
                            <td class="p-3">{{ $fee->receipt_number ?? '---' }}</td>
                            <td class="p-3">{{ $fee->payment_date ?? '---' }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-gray-500 italic text-center p-6 bg-gray-50 rounded border">لا توجد إيصالات رسوم مسجلة.</p>
            @endif
        </div>

    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.detail-tab-btn');
        const contents = document.querySelectorAll('.detail-content');

        tabBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                contents.forEach(content => content.classList.add('hidden'));
                
                const targetId = btn.dataset.target;
                document.getElementById(targetId).classList.remove('hidden');

                tabBtns.forEach(b => {
                    b.classList.remove('bg-zu-beige', 'text-zu-blue', 'border-r-4', 'border-zu-maroon');
                    b.classList.add('text-gray-600', 'border-transparent');
                });
                
                btn.classList.remove('text-gray-600', 'border-transparent');
                btn.classList.add('bg-zu-beige', 'text-zu-blue', 'border-r-4', 'border-zu-maroon');
            });
        });
    });
</script>


<div id="extensionModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-lg p-6">
        <h3 class="text-xl font-bold text-zu-blue mb-4 border-b pb-2">إضافة حركة مد جديدة</h3>
        <form method="POST" action="{{ route('extensions.store', $enrollment->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">سبب المد <span class="text-red-500">*</span></label>
                    <input type="text" name="reason" required class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">موافقة القسم</label>
                        <input type="date" name="dept_approval_date" class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">موافقة الدراسات</label>
                        <input type="date" name="studies_approval_date" class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">موافقة الكلية</label>
                        <input type="date" name="faculty_approval_date" class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                    <div>
                        <label class="block text-sm text-gray-700 mb-1">موافقة الجامعة</label>
                        <input type="date" name="univ_approval_date" class="w-full border border-gray-300 rounded px-3 py-2">
                    </div>
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('extensionModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded text-gray-700">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-zu-blue text-white rounded">حفظ المد</button>
            </div>
        </form>
    </div>
</div>

<div id="feeModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex justify-center items-center">
    <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
        <h3 class="text-xl font-bold text-zu-blue mb-4 border-b pb-2">تسجيل إيصال رسوم</h3>
        <form method="POST" action="{{ route('fees.store', $enrollment->id) }}">
            @csrf
            <div class="space-y-4">
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">بيان الرسوم (النوع) <span class="text-red-500">*</span></label>
                    <select name="fee_type" required class="w-full border border-gray-300 rounded px-3 py-2">
                        <option value="year_1">رسوم عام أول</option>
                        <option value="year_2">رسوم عام ثان</option>
                        <option value="year_3">رسوم عام ثالث</option>
                        <option value="ext_1">رسوم مد أول</option>
                        <option value="susp_1">رسوم إيقاف أول</option>
                        <option value="other">أخرى...</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">رقم الإيصال <span class="text-red-500">*</span></label>
                    <input type="text" name="receipt_number" required class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-bold text-gray-700 mb-1">تاريخ السداد <span class="text-red-500">*</span></label>
                    <input type="date" name="payment_date" required class="w-full border border-gray-300 rounded px-3 py-2">
                </div>
            </div>
            <div class="mt-6 flex justify-end gap-2">
                <button type="button" onclick="document.getElementById('feeModal').classList.add('hidden')" class="px-4 py-2 border border-gray-300 rounded text-gray-700">إلغاء</button>
                <button type="submit" class="px-4 py-2 bg-zu-green text-white rounded">حفظ الإيصال</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const addExtensionBtn = document.querySelector('button[onclick="openExtensionModal()"]');
        if(addExtensionBtn) {
            addExtensionBtn.onclick = function() { document.getElementById('extensionModal').classList.remove('hidden'); }
        }
        
        const addFeeBtn = document.querySelector('#sec-fees button');
        if(addFeeBtn) {
            addFeeBtn.onclick = function() { document.getElementById('feeModal').classList.remove('hidden'); }
        }
        
        const addExtBtn = document.querySelector('#sec-extensions button');
        if(addExtBtn) {
            addExtBtn.onclick = function() { document.getElementById('extensionModal').classList.remove('hidden'); }
        }
    });
</script>
@endsection