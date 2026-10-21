<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Student;
use App\Models\StudentProgram;
use App\Models\ProgramExtension;
use App\Models\ProgramSuspension;
use App\Models\ProgramFeePayment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. إنشاء حساب الأدمن الرئيسي
        User::firstOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('password123'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        // 2. إنشاء بيانات وهمية متكاملة لجميع البرامج والأعمدة المطلوبة
        $programs = ['pre_master', 'master', 'doctorate'];

        foreach ($programs as $index => $progType) {
            $nationalId = '2990101' . rand(1000000, 9999999);
            
            // إنشاء الطالب (البيانات الشخصية والمؤهل)
            $student = Student::create([
                'legacy_serial_number' => (string)($index + 1),
                'full_name' => 'طالب تجريبي ' . ($progType == 'pre_master' ? 'تمهيدي ماجستير' : ($progType == 'master' ? 'ماجستير' : 'دكتوراه')),
                'national_id' => $nationalId,
                'student_code' => 'PUL-' . rand(1000, 9999),
                'birth_date' => '1995-05-15',
                'birth_governorate' => 'الشرقية',
                'current_address' => 'الزقازيق، شارع البوسطة',
                'mobile' => '01012345678',
                'email' => "student{$index}@zu.edu.eg",
                'current_job' => 'صيدلي حر',
                'previous_qualification' => 'بكالوريوس في العلوم الصيدلية',
                'qualification_year' => 2018,
                'qualification_institution' => 'جامعة الزقازيق',
                'overall_grade' => 'جيد جداً',
                'specialization_grade' => 'ممتاز',
            ]);

            // إنشاء السجل الأكاديمي والموافقات والرسالة
            $program = StudentProgram::create([
                'student_id' => $student->id,
                'program_type' => $progType,
                'department_enrollment_approval_date' => '2023-01-10',
                'postgraduate_enrollment_approval_date' => '2023-01-20',
                'faculty_enrollment_approval_date' => '2023-01-25',
                'university_enrollment_approval_date' => '2023-02-05',
                'preparatory_courses_completion_date' => $progType == 'pre_master' ? '2023-08-15' : null,
                'department_registration_approval_date' => '2023-09-01',
                'postgraduate_registration_approval_date' => '2023-09-10',
                'faculty_registration_approval_date' => '2023-09-15',
                'university_registration_approval_date' => '2023-09-25',
                'thesis_title_ar' => 'دراسة صيدلانية تحليلية متقدمة على المركبات الدوائية الحديثة',
                'thesis_title_en' => 'Advanced Pharmaceutical Analytical Study on Modern Drug Compounds',
                'supervisory_committee_members_text' => 'أ.د. أحمد محمد (مشرف رئيسي)، أ.د. محمود حسن (مشرف مشارك)',
                'examining_committee_text' => 'أ.د. محمد إبراهيم، أ.د. خالد عبد الله، أ.د. سعيد علي',
                'examining_dept_approval_date' => '2025-01-10',
                'grant_dept_approval_date' => '2025-02-01',
                'registration_start_date' => '2023-02-05',
                'registration_duration_days' => 730,
                'extension_days' => 90,
                'academic_status' => 'active',
            ]);

            // إنشاء سجلات المد (مد أول وثان)
            for ($i = 1; $i <= 2; $i++) {
                ProgramExtension::create([
                    'student_program_id' => $program->id,
                    'extension_number' => $i,
                    'reason' => 'ظروف بحثية وتأخر توريد الكيماويات رقم ' . $i,
                    'department_council_approval_date' => '2024-01-10',
                    'faculty_council_approval_date' => '2024-01-20',
                ]);
            }

            // إنشاء سجلات الإيقاف (إيقاف أول)
            ProgramSuspension::create([
                'student_program_id' => $program->id,
                'suspension_number' => 1,
                'reason' => 'إيقاف قيد لأسباب شخصية',
                'department_council_approval_date' => '2023-06-01',
                'faculty_council_approval_date' => '2023-06-15',
            ]);

            // إنشاء سجلات الرسوم الدراسية (للنوات الأولى كمثال)
            for ($year = 1; $year <= 3; $year++) {
                ProgramFeePayment::create([
                    'student_program_id' => $program->id,
                    'fee_type' => 'tuition',
                    'period_number' => $year,
                    'amount' => 1500.00,
                    'payment_date' => "2023-09-{$year}0",
                    'receipt_number' => 'REC-2023-' . rand(1000, 9999),
                ]);
            }
        }
    }
}