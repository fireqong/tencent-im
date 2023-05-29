<?php
/**
 * 群组
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method createGroup($array)
 * @method destroyGroup($array)
 * @method getJoinedGroupList($array)
 * @method getAppIDGroupList($array)
 * @method getGroupInfo($array)
 * @method modifyGroupBaseInfo($array)
 * @method importGroup($array)
 * @method addGroupMember($array)
 * @method deleteGroupMember($array)
 * @method banGroupMember($array)
 * @method unbanGroupMember($array)
 * @method forbidSendMsg($array)
 * @method getGroupMutedAccount($array)
 * @method changeGroupOwner($array)
 * @method getRoleInGroup($array)
 * @method importGroupMember($array)
 * @method getGroupMemberInfo($array)
 * @method modifyGroupMemberInfo($array)
 * @method getGroupAttr($array)
 * @method modifyGroupAttr($array)
 * @method clearGroupAttr($array)
 * @method setGroupAttr($array)
 * @method getOnlineMemberNum($array)
 * @method getMembers($array)
 * @method modifyUserInfo($array)
 * @method getGroupBanMember($array)
 * @method createTopic($array)
 * @method destroyTopic($array)
 * @method getTopic($array)
 * @method modifyTopic($array)
 * @method importTopic($array)
 * @method getGroupCounter($array)
 * @method updateGroupCounter($array)
 * @method deleteGroupCounter($array)
 */
class Group extends Client
{
    protected $urlMap = [
        'createGroup' => '/v4/group_open_http_svc/create_group',             //创建群组
        'destroyGroup' => '/v4/group_open_http_svc/destroy_group',             //解散群组
        'getJoinedGroupList' => '/v4/group_open_http_svc/get_joined_group_list',             //获取用户所加入的群组
        'getAppIDGroupList' => '/v4/group_open_http_svc/get_appid_group_list',               //获取 App 中的所有群组
        'getGroupInfo' => '/v4/group_open_http_svc/get_group_info',                          //获取群详细资料
        'modifyGroupBaseInfo' => '/v4/group_open_http_svc/modify_group_base_info',           //修改群基础资料
        'importGroup' => '/v4/group_open_http_svc/import_group',                             //导入群基础资料
        'addGroupMember' => '/v4/group_open_http_svc/add_group_member',                      //增加群成员
        'deleteGroupMember' => '/v4/group_open_http_svc/delete_group_member',                //删除群成员
        'banGroupMember' => '/v4/group_open_http_svc/ban_group_member',                      //群成员封禁
        'unbanGroupMember' => '/v4/group_open_http_svc/unban_group_member',                  //群成员解封
        'forbidSendMsg' => '/v4/group_open_http_svc/forbid_send_msg',                        //批量禁言和取消禁言
        'getGroupMutedAccount' => '/v4/group_open_http_svc/get_group_muted_account',         //获取被禁群成员列表
        'changeGroupOwner' => '/v4/group_open_http_svc/change_group_owner',                  //转让群主
        'getRoleInGroup' => '/v4/group_open_http_svc/get_role_in_group',                     //查询用户在群组中的身份
        'importGroupMember' => '/v4/group_open_http_svc/import_group_member',                //导入群成员
        'getGroupMemberInfo' => '/v4/group_open_http_svc/get_group_member_info',             //获取群成员详细资料
        'modifyGroupMemberInfo' => '/v4/group_open_http_svc/modify_group_member_info',       //修改群成员资料
        'getGroupAttr' => '/v4/group_open_attr_http_svc/get_group_attr',                     //获取群自定义属性
        'modifyGroupAttr' => '/v4/group_open_http_svc/modify_group_attr',                    //修改群自定义属性
        'clearGroupAttr' => '/v4/group_open_http_svc/clear_group_attr',                      //清空群自定义属性
        'setGroupAttr' => '/v4/group_open_http_svc/set_group_attr',                          //重置群自定义属性
        'getOnlineMemberNum' => '/v4/group_open_http_svc/get_online_member_num',             //获取直播群在线人数
        'getMembers' => '/v4/group_open_avchatroom_http_svc/get_members',                    //获取直播群在线成员列表
        'modifyUserInfo' => '/v4/group_open_avchatroom_http_svc/modify_user_info',           //设置直播群成员标记
        'getGroupBanMember' => '/v4/group_open_http_svc/get_group_ban_member',               //获取封禁群成员列表
        'createTopic' => '/v4/million_group_open_http_svc/create_topic',                     //创建话题
        'destroyTopic' => '/v4/million_group_open_http_svc/destroy_topic',                   //解散话题
        'getTopic' => '/v4/million_group_open_http_svc/get_topic',                           //获取话题
        'modifyTopic' => '/v4/million_group_open_http_svc/modify_topic',                     //修改话题
        'importTopic' => '/v4/group_open_http_svc/import_topic',                             //导入话题
        'getGroupCounter' => '/v4/group_open_http_svc/get_group_counter',                    //获取群计数器
        'updateGroupCounter' => '/v4/group_open_http_svc/update_group_counter',              //更新群计数器
        'deleteGroupCounter' => '/v4/group_open_http_svc/delete_group_counter',              //删除群计数器
    ];
}