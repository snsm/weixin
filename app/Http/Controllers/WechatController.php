<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use EasyWeChat\Foundation\Application;
use Illuminate\Support\Facades\Config;

class WechatController extends Controller
{
    public function serve(){

        $options =Config::get('wechat');
        $app = new Application($options);

        $server = $app->server;
        $user = $app->user;

        $server->setMessageHandler(function() use ($user) {
            return '关注朋友圈消息！';
        });

        $server->serve()->send();
    }
}
