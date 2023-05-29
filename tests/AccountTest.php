<?php
/**
 * 文件名称
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

use Church\TencentIm\App;
use PHPUnit\Framework\TestCase;

class AccountTest extends TestCase
{
    protected $app;

    public function setUp(): void
    {
        $this->app = new App($_ENV['IM_SDK_APPID'], $_ENV['IM_SECRET_KEY'], $_ENV['IM_ADMIN_USER_ID']);
    }

    public function testImport()
    {
        $app = $this->app;
        $res = $app->account->importAccount([
            'UserID' => '762488',
        ]);
        $this->assertEquals($res['ErrorCode'], 0);
    }

    public function testMultiImport()
    {
        $app = $this->app;
        $res = $app->account->importMultiAccount([
            'Accounts' => [
                '70001',
                '70002',
                '70003',
            ]
        ]);
        $this->assertEquals($res['ErrorCode'], 0);
    }

    public function testDelete()
    {
        $app = $this->app;
        $res = $app->account->deleteAccount([
            'DeleteItem' => [
                [
                    'UserID' => '762488'
                ]
            ]
        ]);
        $this->assertEquals($res['ErrorCode'], 0);
    }

    public function testQuery()
    {
        $app = $this->app;
        $res = $app->account->checkAccount([
            'CheckItem' => [
                [
                    'UserID' => '762488'
                ]
            ]
        ]);
        $this->assertEquals($res['ErrorCode'], 0);
    }

    public function tearDown(): void
    {
        unset($this->app);
    }
}
