<?php

namespace App\Notifications;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewJobApplicationNotification extends Notification
{
    use Queueable;

    public $application;

    public function __construct(JobApplication $application)
    {
        $this->application = $application;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toDatabase($notifiable)
    {
        $jobTitle = $this->application->job->title;
        $userName = $this->application->user->name;
        
        return [
            'title' => 'New Job Application',
            'message' => "{$userName} applied for '{$jobTitle}'",
            'icon' => 'fas fa-briefcase',
            'color' => 'primary',
            'application_id' => $this->application->id,
            'job_id' => $this->application->job_id,
            'user_id' => $this->application->user_id,
            'url' => route('admin.applications.show', $this->application->id),
        ];
    }
}