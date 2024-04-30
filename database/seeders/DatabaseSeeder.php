<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder{

    /**
     * Seed the application's database.
     */
    public function run()
    : void{
        $this->call([
            ProvinceSeeder::class,
            DistrictSeeder::class,
            WardSeeder::class,
            UserSeeder::class,
            MajorSeeder::class,
            ResumeSeeder::class,
            CandidateSeeder::class,
            CandidateAddressSeeder::class,
            SkillSeeder::class,
            CandidateSkillSeeder::class,
            LanguageSeeder::class,
            CandidateLanguageSeeder::class,
            DegreeSeeder::class,
            EducationSeeder::class,
            EducationDegreeSeeder::class,
            CandidateEducationSeeder::class,
            CandidateMajorSeeder::class,
            ExperienceSeeder::class,
            CompanySeeder::class,
            CompanyAddressSeeder::class,
            CompanyTrackingSeeder::class,
            CategorySeeder::class,
            PostSeeder::class,
            JobTypeSeeder::class,
            JobStatusSeeder::class,
            JobSeeder::class,
            JobSalarySeeder::class,
            JobAttributeSeeder::class,
            JobDetailSeeder::class,
            JobRequirementSeeder::class,
//            ApplyJobSeeder::class,
        ]);
    }
}
