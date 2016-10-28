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
                    return '关注朋友圈餐厅系统消息！';
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

    public function user(){

        $openId ='oaIG2w0qavCHovOg8YwGkrswZg58';

        $options =Config::get('wechat');

        $app = new Application($options);

        $userService = $app->user;

        $userService->remark($openId, "小龙哥");

        dd($userService->get($openId));

    }

    //第二步
    public function login(){

        $options =Config::get('wechat');
        $app = new Application($options);
        $oauth = $app->oauth;

        // 未登录
        if (!session()->has('target_user')) {

            session(['target_url'=>'user/profile']);

            return $oauth->redirect();
            // 这里不一定是return，如果你的框架action不是返回内容的话你就得使用
            // $oauth->redirect()->send();
        }

        // 已经登录过
        $user = session('wechat_user');

        dd($user);

    }


    //第一步
    public function oauth_callback(){

        $options =Config::get('wechat');

        $app = new Application($options);

        $oauth = $app->oauth;

        // 获取 OAuth 授权结果用户信息
        $user = $oauth->user();

        session(['wechat_user' => $user->toArray()]);

        //$targetUrl = session()->has('target_url') ? '/' :session('target_url');
        $targetUrl = session()->has('target_url') ? session('target_url'): '/';

        //dd($targetUrl);
        dd(session('wechat_user'));

       // header('location:'. $targetUrl); // 跳转到 user/profile
    }

}
