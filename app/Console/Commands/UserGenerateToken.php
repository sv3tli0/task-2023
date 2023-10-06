<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

use function Laravel\Prompts\multiselect;
use function Laravel\Prompts\select;

class UserGenerateToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generating valid token for users - with prompting.';

    /**
     * Execute the console command.
     */
    public function handle(): void
    {
        $id = select(
            'Pick the user that you want to generate token for:',
            User::query()->pluck('name', 'id')->all()
        );

        // Although it is not possible, keep checking for the user's existence.
        // In case the user is deleted after the select prompt - failback to reset the task or leave.
        try {
            $user = User::findOrFail($id);
        } catch (\Throwable $th) {
            $this->error(':( User not found! :(');

            $this->ask('Do you want to try again?') ? $this->handle() : $this->info('Bye!');

            return;
        }

        $this->info('Generating token for user: '.$user->name);
        $abilities = multiselect(
            'Pick the abilities that you want to assign to the token (can be empty):',
            ['read', 'write', 'delete', 'update']
        );

        $token = $user->createToken('token', $abilities)->plainTextToken;

        $this->info('Token generated successfully!');
        $this->info('Token: '.$token);
    }
}
