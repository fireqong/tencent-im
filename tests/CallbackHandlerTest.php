<?php
/**
 * 文件名称
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

use PHPUnit\Framework\TestCase;

class CallbackHandlerTest extends TestCase
{
    public function testHandle()
    {
        $this->app = new \Church\TencentIm\App($_ENV['IM_SDK_APPID'], $_ENV['IM_SECRET_KEY'], $_ENV['IM_ADMIN_USER_ID']);
        $callbackHandler = $this->app->callbackHandler;

        $json = <<< EOF
{
    "CallbackCommand": "Group.CallbackAfterNewMemberJoin", 
    "GroupId": "@TGS#2J4SZEAEL", 
    "Type": "Public", 
    "JoinType": "Apply", 
    "Operator_Account": "leckie", 
    "NewMemberList": [
        {
            "Member_Account": "jared"
        }, 
        {
            "Member_Account": "tommy"
        }
    ]
}
EOF;

        $callbackHandler->setAuthWay(\Church\TencentIm\Callbackhandler::AUTH_TOKEN);
        $callbackHandler->setToken($_ENV['IM_CALLBACK_AUTH_TOKEN']);

        $curr = time();
            $callbackHandler->handle(json_decode($json, true), $_ENV['IM_SDK_APPID'], 'State.StateChange', 'json', '127.0.0.1', 'web', $curr, hash('sha256', $_ENV['IM_CALLBACK_AUTH_TOKEN'].$curr));
    }
}
