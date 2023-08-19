<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\UserSimilarities;
use App\Http\Controllers\UserSimilaritiesController;

class CalculateUserSimilarities extends Command
{
    protected $signature = 'calculate:user-similarities';
    protected $description = 'Calculate user similarities';

    public function handle()
    {
        $userSimilaritiesController = new UserSimilarities();
        $userSimilaritiesController->calculateUserSimilarities();
    }
}
