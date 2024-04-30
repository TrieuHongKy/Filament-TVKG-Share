<?php

namespace App\Providers;

use App\Interfaces\AddressRepositoryInterface;
use App\Interfaces\ApplyJobRepositoryInterface;
use App\Interfaces\CandidateRepositoryInterface;
use App\Interfaces\CategoryRepositoryInterface;
use App\Interfaces\CompanyRepositoryInterface;
use App\Interfaces\ContactRepositoryInterface;
use App\Interfaces\EducationRepositoryInterface;
use App\Interfaces\JobRepositoryInterface;
use App\Interfaces\LanguageRepositoryInterface;
use App\Interfaces\PostCommentRepositoryInterface;
use App\Interfaces\PostLikeRepositoryInterface;
use App\Interfaces\PostRepositoryInterface;
use App\Interfaces\ResumeRepositoryInterface;
use App\Interfaces\SavedJobRepositoryInterface;
use App\Interfaces\SkillRepositoryInterface;
use App\Interfaces\UserRepositoryInterface;
use App\Interfaces\WidgetRepositoryInterface;
use App\Repositories\AddressRepository;
use App\Repositories\ApplyJobRepository;
use App\Repositories\CandidateRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CompanyRepository;
use App\Repositories\ContactRepository;
use App\Repositories\EducationRepository;
use App\Repositories\JobRepository;
use App\Repositories\LanguageRepository;
use App\Repositories\PostCommentRepository;
use App\Repositories\PostLikeRepository;
use App\Repositories\PostRepository;
use App\Repositories\ResumeRepository;
use App\Repositories\SavedJobRepository;
use App\Repositories\SkillRepository;
use App\Repositories\UserRepository;
use App\Repositories\WidgetRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider{

    /**
     * Register any application services.
     */
    public function register()
    : void{
        $this->app->bind(WidgetRepositoryInterface::class, WidgetRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
        $this->app->bind(LanguageRepositoryInterface::class, LanguageRepository::class);
        $this->app->bind(EducationRepositoryInterface::class, EducationRepository::class);
        $this->app->bind(CandidateRepositoryInterface::class, CandidateRepository::class);
        $this->app->bind(ResumeRepositoryInterface::class, ResumeRepository::class);
        $this->app->bind(PostRepositoryInterface::class, PostRepository::class);
        $this->app->bind(ApplyJobRepositoryInterface::class, ApplyJobRepository::class);
        $this->app->bind(JobRepositoryInterface::class, JobRepository::class);
        $this->app->bind(SkillRepositoryInterface::class, SkillRepository::class);
        $this->app->bind(CompanyRepositoryInterface::class, CompanyRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ContactRepositoryInterface::class, ContactRepository::class);
        $this->app->bind(PostCommentRepositoryInterface::class, PostCommentRepository::class);
        $this->app->bind(PostLikeRepositoryInterface::class, PostLikeRepository::class);
        $this->app->bind(SavedJobRepositoryInterface::class, SavedJobRepository::class);
        $this->app->bind(AddressRepositoryInterface::class, AddressRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot()
    : void{
        //
    }
}
