<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use App\Mail\WelcomeEmail;
use Http;

class SendEmailJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;
    protected $emailData;

    /**
     * Create a new job instance.
     */
    public function __construct($emailData)
    {
        $this->emailData = $emailData;
        // dd($user);
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $sendData = [
            'email' => $this->emailData['email'],
            'subject' => $this->emailData['subject'],
            'message' => $this->emailData['message'],
        ];
    
        Http::post("https://connect.pabbly.com/workflow/sendwebhookdata/IjU3NjYwNTZkMDYzZTA0MzQ1MjY4NTUzMDUxMzQi_pc", $sendData);

    
    }
}
