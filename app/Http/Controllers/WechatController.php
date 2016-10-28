<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Config;
use EasyWeChat\Message\News;

class WechatController extends Controller
{
    public function serve(){

        $options =Config::get('wechat');
        $app = new Application($options);

        $server = $app->server;
        $user = $app->user;

        $server->setMessageHandler(function($message) use ($user) {
            switch ($message->MsgType) {
                case 'event':
                    # 事件消息...
                    return '关注朋友圈消息！';
                    break;
                case 'text':
                    # 文字消息...
                    return new News([
                        'title'       => '保险腊肉',
                        'description' => '下面内容就是描述了',
                        'url'         => 'http://www.baidu.com',
                        'image'       => 'https://www.baidu.com/img/bd_logo1.png',
                        // ...
                    ]);
                    break;
                case 'image':
                    # 图片消息...
                    return '你发的是图片：'.$message->picUrl;
                    break;
                case 'voice':
                    # 语音消息...
                    break;
                case 'video':
                    # 视频消息...
                    break;
                case 'location':
                    # 坐标消息...
                    break;
                case 'link':
                    # 链接消息...
                    break;
                // ... 其它消息
                default:
                    # code...
                    break;
            }
        });

        $server->serve()->send();
    }
}
