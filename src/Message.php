<?php
/**
 * 消息
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method sendMsg($array)
 * @method batchSendMsg($array)
 * @method sendGroupMsg($array)
 * @method sendGroupSystemNotification($array)
 * @method sendBroadCastMsg($array)
 * @method importGroupMsg($array)
 * @method importMsg($array)
 * @method modifyC2CMsg($array)
 * @method modifyGroupMsg($array)
 * @method getGroupMsg($array)
 * @method deleteGroupMsgBySender($array)
 * @method recallMsg($array)
 * @method recallGroupMsg($array)
 * @method setMsgRead($array)
 * @method getGroupMsgReceiptDetail($array)
 * @method getGroupMsgReceipt($array)
 * @method getRoamMsg($array)
 * @method getKeyValues($array)
 * @method setKeyValues($array)
 * @method getGroupKeyValues($array)
 * @method setGroupKeyValues($array)
 * @method push($array)
 * @method setAttrName($array)
 * @method getAttrName($array)
 * @method getAttr($array)
 * @method setAttr($array)
 * @method removeAttr($array)
 * @method getTag($array)
 * @method addTag($array)
 * @method removeTag($array)
 * @method removeAllTags($array)
 *
 */
class Message extends Client
{
    protected $urlMap = [
        'sendMsg' => '/v4/openim/sendmsg',             //单发单聊消息
        'batchSendMsg' => '/v4/openim/batchsendmsg',   //批量发单聊消息
        'sendGroupMsg' => '/v4/group_open_http_svc/send_group_msg',             //在群组中发送普通消息
        'sendGroupSystemNotification' => '/v4/group_open_http_svc/send_group_system_notification',               //在群组中发送系统通知
        'sendBroadCastMsg' => '/v4/group_open_http_svc/send_broadcast_msg',                     //直播群广播消息
        'importGroupMsg' => '/v4/group_open_http_svc/import_group_msg',                     //导入群消息
        'importMsg' => '/v4/openim/importmsg',          //导入单聊消息
        'modifyC2CMsg' => '/v4/openim/modify_c2c_msg',      //修改单聊历史消息
        'modifyGroupMsg' => '/v4/openim/modify_group_msg',      //修改群聊历史消息
        'getGroupMsg' => '/v4/group_open_http_svc/group_msg_get_simple',    //拉取群历史消息
        'deleteGroupMsgBySender' => '/v4/group_open_http_svc/delete_group_msg_by_sender',     //删除指定用户发送的消息
        'recallMsg' => '/v4/openim/admin_msgwithdraw',        //撤回单聊消息
        'recallGroupMsg' => '/v4/group_open_http_svc/group_msg_recall', //撤回群消息
        'setMsgRead' => '/v4/openim/admin_set_msg_read',      //设置单聊消息已读
        'getGroupMsgReceiptDetail' => '/v4/group_open_http_svc/get_group_msg_receipt_detail',   //拉取群消息已读回执详情
        'getGroupMsgReceipt' => '/v4/group_open_http_svc/get_group_msg_receipt',        //拉取群消息已读回执信息
        'getRoamMsg' => '/v4/openim/admin_getroammsg',      //查询单聊消息
        'getKeyValues' => '/v4/openim_msg_ext_http_svc/get_key_values',     //拉取单聊消息扩展
        'setKeyValues' => '/v4/openim_msg_ext_http_svc/set_key_values',     //设置单聊消息扩展
        'getGroupKeyValues' => '/v4/openim_msg_ext_http_svc/group_get_key_values',  //拉取群消息扩展
        'setGroupKeyValues' => '/v4/openim_msg_ext_http_svc/group_set_key_values',  //设置群消息扩展
        'push' => '/v4/all_member_push/im_push',        //全员推送
        'setAttrName' => '/v4/all_member_push/im_set_attr_name',   //设置应用属性名称
        'getAttrName' => '/v4/all_member_push/im_get_attr_name',   //获取应用属性名称
        'getAttr' => '/v4/all_member_push/im_get_attr',            //获取用户属性
        'setAttr' => '/v4/all_member_push/im_set_attr',            //设置用户属性
        'removeAttr' => '/v4/all_member_push/im_remove_attr',      //删除用户属性
        'getTag' => '/v4/all_member_push/im_get_tag',              //获取用户标签
        'addTag' => '/v4/all_member_push/im_add_tag',              //添加用户标签
        'removeTag' => '/v4/all_member_push/im_remove_tag',        //删除用户标签
        'removeAllTags' => '/v4/all_member_push/im_remove_all_tags', //删除所有用户标签
    ];
}