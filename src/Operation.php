<?php
/**
 * 运营
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method getAppInfo($array)
 * @method getHistory($array)
 * @method getIPList($array)
 * @method forbidIllegalObject($array)
 * @method allowBannedObject($array)
 * @method getCosSig($array)
 *
 */
class Operation extends Client
{
    protected $urlMap = [
        'getAppInfo' => '/v4/openconfigsvr/getappinfo',             //拉取运营数据
        'getHistory' => '/v4/open_msg_svc/get_history',             //下载最近消息记录
        'getIPList' => '/v4/ConfigSvc/GetIPList',                   //获取服务器 IP 地址
        'forbidIllegalObject' => '/v4/im_cos_msg/forbid_illegal_object', //聊天文件封禁
        'allowBannedObject' => '/v4/im_cos_msg/allow_banned_object',     //聊天文件解封
        'getCosSig' => '/v4/im_cos_msg/get_cos_sig',                     //聊天文件签名
    ];
}