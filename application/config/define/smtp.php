<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------

define('MOD_EMAIL_SEND_ACCOUNT_DJANGO', 100); // 原服务转Django发送类型（后期需要转换指定下列类型）
define('MOD_EMAIL_SEND_ACCOUNT_REGISTER', 101); // 用户注册欢迎通知
define('MOD_EMAIL_SEND_ACCOUNT_UPGRADE', 102); // 用户升级通知
define('MOD_EMAIL_SEND_ACCOUNT_NEWORDERS', 103); // 用户新订单通知
define('MOD_EMAIL_SEND_ACCOUNT_CREATE', 104); // 用户邀请邮件
define('MOD_EMAIL_SEND_ACCOUNT_VERIFY', 105); // 用户邮箱验证
define('MOD_EMAIL_SEND_ACCOUNT_FORGET_PASSWORD', 106); // 用户找回密码邮箱验证
define('MOD_EMAIL_SEND_ACCOUNT_FRIEND', 107);// 发送推荐朋友邮件
define('MOD_EMAIL_SEND_MOTHERDAY', 108);// 发送母亲节获奖邮件
define('MOD_EMAIL_SEND_ORDERS_REJECT', 111); // 发送信用卡风控拒绝邮件
define('MOD_EMAIL_SEND_ORDERS_REVIEW', 112); // 发送信用卡预授权邮件
define('MOD_EMAIL_SEND_ORDERS_REVIEW_SUCCESS', 113); // 发送信用卡预