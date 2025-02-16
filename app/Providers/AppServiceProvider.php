<?php

namespace App\Providers;

use App\Interfaces\IAdminRepository;
use App\Interfaces\IBackupFileRepository;
use App\Interfaces\IFileRepository;
use App\Interfaces\IGroupRepository;
use App\Interfaces\IHistoryRepository;
use App\Interfaces\IUserRepository;
use App\Repositories\AdminRepository;
use App\Repositories\BackupFileRepository;
use App\Repositories\FileRepository;
use App\Repositories\GroupRepository;
use App\Repositories\HistoryRepository;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(IBackupFileRepository::class, BackupFileRepository::class);
        $this->app->bind(IFileRepository::class, FileRepository::class);
        $this->app->bind(IHistoryRepository::class, HistoryRepository::class);
        $this->app->bind(IUserRepository::class, UserRepository::class);
        $this->app->bind(IGroupRepository::class, GroupRepository::class);
        $this->app->bind(IAdminRepository::class, AdminRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
