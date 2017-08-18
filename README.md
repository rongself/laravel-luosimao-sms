## 螺丝帽短信 Laravel Channel 支持

[螺丝帽](http://luosimao.com) 短信 Channel for laravel 5.4.*

### 安装

```bash
composer require 'rongself/laravel-luosimao-sms'
```

### 配置

- 编辑`config/app.php`注册provider:

```php
'providers' => [
        Rongself\Luosimao\Providers\LuosimaoSmsProvider::class
],
```
- 生成配置文件
```bash
php artisan vendor:publish 
```
编辑`config/luosimao-sms.php`填入`app_key`

- 通知模板via中使用Channel

```php
<?php

namespace App\Notifications;

use Illuminate\Notifications\Notification;
use Rongself\Luosimao\Channels\SmsChannel;

/**
 * Class ChargeResult
 * @package App\Notifications
 */
class ChargeResult extends Notification 
{

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return [SmsChannel::class];
    }
    
    //定义短信内容
    public function toSmsMessage($notifiable)
    {
        return '验证码：19272【铁壳测试】';
    }
}

```

- 自定义电话字段

```php
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class User extends Model
{
    use Notifiable;
    
    //添加getPhone方法返回相应字段
    public function getPhone()
    {
        return $this->Tel;
    }

}

```

- 发送

```php
<?php
//发送通知消息
$user = User::find(1);
$message = new ChargeResult();
$user->notify($message);

```

关于通知消息使用详情参考 [laravel官方文档](http://d.laravel-china.org/docs/5.4/notifications)
