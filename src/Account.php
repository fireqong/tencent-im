<?php
/**
 * 用户管理类
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method importAccount($array)
 * @method importMultiAccount($array)
 * @method deleteAccount($array)
 * @method checkAccount($array)
 * @method setProfile($array)
 * @method getProfile($array)
 * @method kick($array)
 * @method queryOnlineStatus($array)
 * @method addFriend($array)
 * @method importFriend($array)
 * @method updateFriend($array)
 * @method deleteFriend($array)
 * @method deleteAllFriend($array)
 * @method checkFriend($array)
 * @method getFriend($array)
 * @method getFriendList($array)
 * @method addGroup($array)
 * @method deleteGroup($array)
 * @method getGroup($array)
 * @method addBlackList($array)
 * @method deleteBlackList($array)
 * @method getBlackList($array)
 * @method checkBlackList($array)
 */
class Account extends Client
{
    protected $urlMap = [
        'importAccount' => '/v4/im_open_login_svc/account_import',             //导入单个账号
        'importMultiAccount' => '/v4/im_open_login_svc/multiaccount_import',   //导入多个账号
        'deleteAccount' => '/v4/im_open_login_svc/account_delete',             //删除账号
        'checkAccount' => '/v4/im_open_login_svc/account_check',               //查询账号
        'setProfile' => '/v4/profile/portrait_set',                            //设置资料
        'getProfile' => '/v4/profile/portrait_get',                            //拉取资料
        'kick' => '/v4/im_open_login_svc/kick',                         //失效账号登录状态
        'queryOnlineStatus' => '/v4/openim/query_online_status',        //查询账号在线状态
        'addFriend' => '/v4/sns/friend_add',                            //添加好友
        'importFriend' => '/v4/sns/friend_import',                      //导入好友
        'updateFriend' => '/v4/sns/friend_update',                      //更新好友
        'deleteFriend' => '/v4/sns/friend_delete',                      //删除好友
        'deleteAllFriend' => '/v4/sns/friend_delete_all',               //删除所有好友
        'checkFriend' => '/v4/sns/friend_check',                        //检验好友
        'getFriend' => '/v4/sns/friend_get',                            //拉取好友
        'getFriendList' => 'v4/sns/friend_get_list',                    //拉取指定好友
        'addGroup' => '/v4/sns/group_add',                              //添加分组
        'deleteGroup' => '/v4/sns/group_delete',                        //删除分组
        'getGroup' => 'v4/sns/group_get',                               //获取分组
        'addBlackList' => '/v4/sns/black_list_add',                     //添加黑名单
        'deleteBlackList' => '/v4/sns/black_list_delete',               //删除黑名单
        'getBlackList' => '/v4/sns/black_list_get',                     //获取黑名单
        'checkBlackList' => '/v4/sns/black_list_check',                 //检验黑名单
    ];
}