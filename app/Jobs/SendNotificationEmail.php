<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendNotificationEmail implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $email, $data;


    /**
     * Create a new job instance.
     */
    public function __construct($email, $data)
    {
        $this->email = $email;
        $this->data = $data;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::send('backend.admin-views.send-notification.msg', $this->data, function ($message) {
                $message->to($this->email, 'Like Wise Bd')
                    ->subject('Notification Message');
            });
        } catch (\Exception $e) {
            Log::error("Failed to send email to {$this->email}: " . $e->getMessage());
            // Optionally, you can throw the exception to retry the job
            // throw $e;
        }
    }
}
