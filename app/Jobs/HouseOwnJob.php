<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Message;
use Mail;

class HouseOwnJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    private $info; 

    public function __construct($info)
    {
        $this->info = $info;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::raw('添加你的信息成功，稍后会有工作人员联系', function (Message $message) {
            $message->subject('租房网通知邮件');
            $message->to($this->info->email, $this->info->name);
        });
    }
}
