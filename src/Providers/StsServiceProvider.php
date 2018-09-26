<?php

namespace Yoruchiaki\Sts\Providers;

use RuntimeException;
use Illuminate\Support\ServiceProvider;

class StsServiceProvider extends ServiceProvider
{
    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            realpath(__DIR__ . '/../../config/sts.php') => config_path('sts.php'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(realpath(__DIR__ . '/../../config/sts.php'), 'sts');

        $config = $this->app['config']['sts'];
        if (!$this->app->runningInConsole() && (empty($config['key']) || empty($config['secret']) || empty($config['role_arn']))) {
            throw new RuntimeException('缺少必要配置项无法注册StsProvider,请在.env 文件设置STS_KEY , STS_SECRET, STS_ROLE_ARN');
        }
    }
}
