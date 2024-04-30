<?php

namespace App\Mail;

use App\Enums\ApplyJobStatus;
use App\Models\ApplyJob;
use App\Models\Candidate;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobDetail;
use App\Models\JobRequirement;
use App\Models\JobSalary;
use App\Models\Major;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ActionMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public function __construct(protected ApplyJob $applyJob)
    {

    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'MAIL TRẢ THÔNG BÁO ỨNG TUYỂN CÔNG VIỆC',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $jobDetail = JobDetail::where('job_id', $this->applyJob->job_id)->first();
        $candidate = Candidate::find($this->applyJob->candidate_id);
        $job = Job::where('id', $this->applyJob->job_id)->first();
        $user = User::where('id', $candidate['user_id'])->first();
        $company = Company::where('id', $job['company_id'])->first();
        $requirements = JobRequirement::where('job_id', $this->applyJob->job_id)->first();
        $salary = JobSalary::where('job_id', $this->applyJob->job_id)->first();
        $major = Major::where('id', $requirements['major_id'])->first();
    return new Content(
        view: 'emails.active_action_mail',
        with: [
            'job_title' => $jobDetail['title'],
            'job_major' => $major['name'],
            'job_created_at' => $jobDetail['created_at'],
            'salary_min' => $salary['min_salary'],
            'salary_max' => $salary['max_salary'],
            'status' => $this->applyJob->status === ApplyJobStatus::Success ? 'Chấp Nhận' : 'Từ Chối',
            'username' => $user['name'],
            'company_name' => $company['company_name'],
            'company_address' => $company['company_address'],
            'company_website' => $company['website'],
            'company_size' => $company['company_size'],
            'company_type' => $company['company_type'],
            'company_industry' => $company['company_industry']
        ],

        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
