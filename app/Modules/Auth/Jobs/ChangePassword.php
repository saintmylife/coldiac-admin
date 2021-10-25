<?php

namespace App\Modules\Auth\Jobs;

use App\Modules\User\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ChangePassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $password;
    protected $id;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($password, $id)
    {
        $this->password = $password;
        $this->id = $id;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = User::find($this->id);
        $user->password = $this->password;
        $user->save();
    }
}
