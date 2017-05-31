<?php
/**
 * Created by PhpStorm.
 * User: rongself
 * Date: 2017/5/31
 * Time: 上午11:20
 */

namespace Rongself\Luosimao\Providers;

use Illuminate\Support\ServiceProvider;

class LuosimaoSmsProvider extends ServiceProvider
{
    /**
     * 在注册后进行服务的启动。
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../../config/sms.php' => config_path('luosimao-sms.php'),
        ]);
    }

}