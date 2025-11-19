<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Mail\ActivationMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ResendActivationEmail extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'email:resend-activation {email : The email address of the user}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Resend activation email to unactivated users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        
        $user = User::where('email', $email)->first();
        
        if (!$user) {
            $this->error("User with email {$email} not found.");
            return Command::FAILURE;
        }
        
        if ($user->status === 'aktif' && $user->email_verified_at) {
            $this->info("User {$email} is already activated.");
            return Command::SUCCESS;
        }
        
        // Generate new activation token if not exists
        if (!$user->activation_token) {
            $user->update(['activation_token' => Str::random(64)]);
        }
        
        try {
            Mail::to($user->email)->send(new ActivationMail($user));
            $this->info("Activation email sent successfully to {$email}");
            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->error("Failed to send activation email: " . $e->getMessage());
            return Command::FAILURE;
        }
    }
}
