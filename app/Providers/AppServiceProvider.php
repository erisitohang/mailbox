<?php

namespace App\Providers;

use App\Entities\Message;
use App\Repositories\MessageRepository;
use App\Repositories\MessageRepositoryContract;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MessageRepositoryContract::class, function($app) {
            return new MessageRepository(
                $app['em'],
                $app['em']->getClassMetaData(Message::class)
            );
        });
    }
}
