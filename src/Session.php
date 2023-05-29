<?php
/**
 * 会话
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method getList($array)
 * @method getC2CUnreadMsgNum($array)
 * @method setUnreadMsgNum($array)
 * @method delete($array)
 * @method createContactGroup($array)
 * @method updateContactGroup($array)
 * @method deleteContactGroup($array)
 * @method markContact($array)
 * @method searchContactGroup($array)
 * @method getContactGroup($array)
 */
class Session extends Client
{
    protected $urlMap = [
        'getList' => '/v4/recentcontact/get_list',             //拉取会话列表
        'getC2CUnreadMsgNum' => '/v4/openim/get_c2c_unread_msg_num',             //查询单聊未读消息计数
        'setUnreadMsgNum' => '/v4/group_open_http_svc/set_unread_msg_num',       //设置群成员未读消息计数
        'delete' => '/v4/recentcontact/delete',           //删除单个会话
        'createContactGroup' => '/v4/recentcontact/create_contact_group',       //创建会话分组数据
        'updateContactGroup' => '/v4/recentcontact/update_contact_group',       //更新会话分组数据
        'deleteContactGroup' => '/v4/recentcontact/del_contact_group',          //删除会话分组数据
        'markContact' => '/v4/recentcontact/mark_contact',                      //创建或更新会话标记数据
        'searchContactGroup' => '/v4/recentcontact/search_contact_group',       //搜索会话分组标记
        'getContactGroup' => '/v4/recentcontact/get_contact_group',             //拉取会话分组标记数据

    ];
}