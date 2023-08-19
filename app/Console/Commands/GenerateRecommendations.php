<?php

namespace App\Console\Commands;

use App\Http\Controllers\UserSimilarities;
use Illuminate\Console\Command;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserSimilaritiesController;

class GenerateRecommendations extends Command
{
    protected $signature = 'generate:recommendations';
    protected $description = 'Generate recommendations';

    public function handle()
    {
        $userSimilaritiesController = new UserSimilarities();
        $users = User::all();
        foreach ($users as $user) {
            $userSimilaritiesController->generateRecommendations($user->id);
        }
    }
}
