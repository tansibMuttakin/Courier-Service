<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Notifications\MerchantDisapprovalNotification;
use App\Models\User;

class ExpireUserAccounts extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'expire:user';
    private $user;

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This will expire the user based on package expire date';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $administrator = User::where('type','admin')->first();

        $users = User::whereHas('packages',function($query){
            $query->where('name','15-Days Package');
        })->get();

        foreach ($users as $user) {
            if ($user->approved == 1) {

                $user->approved = 0;
                $user->save();
                $user->notify(new MerchantDisapprovalNotification($administrator));
                echo "operation done";
            }
        }
        
    }
}
