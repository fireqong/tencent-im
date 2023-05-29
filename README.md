### 环境准备

- php >= 7.4

### 安装

```shell
composer require church/tencent-im dev-main
```

### 使用

> **强烈建议在使用之前，仔细阅读官方开发文档.**

#### 综合

```php
<?php
use Church\TencentIm\CallbackHandler;

class IM
{
    public function callback(Request $request)
    {
        $sdkAppID = $request->input('SdkAppid');
        $callbackCommand = $request->input('CallbackCommand');
        $contentType = $request->input('contenttype');
        $clientIP = $request->input('ClientIP');
        $optPlatform = $request->input('OptPlatform');
        $requestTime = $request->input('RequestTime');
        $sign = $request->input('Sign');
        $data = $request->post();
        
        $app = new App(env('IM_SDK_APPID'), env('IM_SECRET_KEY'), env('IM_ADMIN_USER_ID'));
        $handler = $app->callbackHandler;
        
        $handler->setAuthWay(CallbackHandler::AUTH_TOKEN);
        $handler->setToken(env('IM_CALLBACK_AUTH_TOKEN'));
        
        $handler->batchAddEventHandlers([
            CallbackHandler::EVENT_SNS_CALLBACK_PREV_FRIEND_ADD => self::class . '::' . 'prevFriendAdd',            //添加朋友之前
            CallbackHandler::EVENT_SNS_CALLBACK_FRIEND_ADD => self::class . '::' . 'friendAdd',                     //添加朋友之后
            CallbackHandler::EVENT_SNS_CALLBACK_FRIEND_DELETE => self::class . '::' . 'friendDelete',               //删除朋友之后
            CallbackHandler::EVENT_PROFILE_CALLBACK_PORTRAIT_SET => self::class . '::' . 'portraitSet',             //资料设置之后
            CallbackHandler::EVENT_GROUP_CALLBACK_BEFORE_CREATE_GROUP => self::class . '::' . 'beforeCreateGroup',  //创建群组之前
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_CREATE_GROUP => self::class . '::' . 'afterCreateGroup',         //创建群组之后
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_NEW_MEMBER_JOIN => self::class . '::' . 'newMemberJoin',    //新成员进群组之后
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_MEMBER_EXIT => self::class . '::' . 'afterMemberExit',      //成员退出之后
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_GROUP_DESTROYED => self::class . '::' . 'afterGroupDestroy',//群组解散之后
            CallbackHandler::EVENT_GROUP_CALLBACK_BEFORE_SEND_MSG => self::class . '::' . 'groupBeforeSendMsg',          //群内消息发送之前
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_SEND_MSG => self::class . '::' . 'groupAfterSendMsg',            //群内消息发送之后
            CallbackHandler::EVENT_GROUP_CALLBACK_AFTER_GROUP_INFO_CHANGED => self::class . '::' . 'afterGroupInfoChanged', //群组资料更改之后
            CallbackHandler::EVENT_C2C_CALLBACK_BEFORE_SEND_MSG => self::class . '::' . 'beforeSendMsg',            //发送单聊消息之前
            CallbackHandler::EVENT_C2C_CALLBACK_AFTER_SEND_MSG => self::class . '::' . 'afterSendMsg',              //发送单聊消息之后
            CallbackHandler::EVENT_GROUP_CALLBACK_BEFORE_APPLY_JOIN_GROUP => self::class . '::' . 'beforeApplyJoinGroup',   //申请加群之前
        ]);
        
        try {
            return $handler->handle($data, $sdkAppID, $callbackCommand, $contentType, $clientIP, $optPlatform, $requestTime, $sign);
        } catch (\Exception $e) {
            Log::error($e->getMessage() . $e->getTraceAsString());
            if (env('APP_DEBUG')) {
                echo $e->getMessage();
                echo $e->getTraceAsString();
            }
        }
    }
    
    public static function prevFriendAdd 
    {
        return json([
            'ActionStatus' => 'OK',
            'ErrorCode' => 0,
            'ErrorInfo' => ''
        ]);  
    }
}


```

#### 消息

```php
<?php
$result = $app->message->sendMsg([
    'SyncOtherMachine' => 2,
    'To_Account' => 'lumotuwe2',
    'MsgLifeTime' => 60,
    'MsgSeq' => 93847636,
    'MsgRandom' => 1287657,
    'MsgBody' => [
        [
            'MsgType' => 'TIMTextElem',
            'MsgContent' => [
                'Text' => 'hi, beauty'
            ]  
        ]       
    ],
    'CloudCustomData' => 'your cloud custom data',
    'SupportMessageExtension' => 0   
])

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

#### 会话

```php
<?php
$result = $app->session->getList([
    'From_Account' => 'id1',
    'TimeStamp' => 0,
    'StartIndex' => 0,
    'TopTimeStamp' => 0,
    'TopStartIndex' => 0,
    'AssistFlags' => 15
]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

#### 群组

```php
<?php
$result = $app->group->createGroup([
    'Owner_Account' => 'leckie',
    'Type' => 'Public',
    'Name' => 'TestGroup'
]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

#### 用户

```php
<?php
$result = $app->account->importAccount([
    'UserID' => '1111',
    'FaceUrl' => 'http://www.qq.com',
    'Nick' => 'TestGroup'
]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

#### 全局禁言

```php
<?php
$result = $app->shutup->setNoSpeaking([
    'Set_Account' => '1111',
    'C2CmsgNospeakingTime' => 4294967295,
    'GroupmsgNospeakingTime' => 7200
]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

#### 运营管理

```php
<?php
$result = $app->operation->getAppInfo([]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

### 机器人

```php
<?php
$result = $app->robot->create([
    'UserID' => '@RBT#0001'
]);

if ($result['ActionStatus'] == 'OK' && $result['ErrorCode'] == 0) {
    // 走成功逻辑
} else {
    // 走失败逻辑
}
```

### API列表

| 属性        | 方法                          | 描述            |
|-----------|-----------------------------|---------------|
| account   | importAccount               | 导入用户          |
| account   | importMultiAccount          | 导入多个用户        |
| account   | deleteAccount               | 删除用户          |
| account   | checkAccount                | 查询用户          |
| account   | setProfile                  | 设置资料          |
| account   | getProfile                  | 获取资料          |
| account   | kick                        | 踢下线           |
| account   | queryOnlineStatus           | 查询在线状态        |
| account   | addFriend                   | 新增好友          |
| account   | importFriend                | 导入好友          |
| account   | updateFriend                | 更新好友          |
| account   | deleteFriend                | 删除好友          |
| account   | deleteAllFriend             | 删除所有好友        |
| account   | checkFriend                 | 检查是否好友        |
| account   | getFriend                   | 拉取好友          |
| account   | getFriendList               | 拉取指定好友        |
| account   | addGroup                    | 添加好友分组        |
| account   | deleteGroup                 | 删除好友分组        |
| account   | getGroup                    | 获取好友分组        |
| account   | addBlackList                | 添加黑名单         |
| account   | deleteBlackList             | 删除黑名单         |
| account   | getBlackList                | 拉取黑名单         |
| account   | checkBlackList              | 校验黑名单         |
| group     | createGroup                 | 创建群组          |
| group     | destroyGroup                | 销毁群组          |
| group     | getJoinedGroupList          | 获取用户已经加入的群组列表 |
| group     | getAppIDGroupList           | 获取APP中的所有群组列表 |
| group     | getGroupInfo                | 获取群详细资料       |
| group     | modifyGroupBaseInfo         | 修改群基础资料       |
| group     | importGroup                 | 导入群基础资料       |
| group     | addGroupMember              | 增加群成员         |
| group     | deleteGroupMember           | 删除群成员         |
| group     | banGroupMember              | 群成员封禁         |
| group     | unbanGroupMember            | 群成员解封         |
| group     | forbidSendMsg               | 批量禁言和取消禁言     |
| group     | getGroupMutedAccount        | 获取被禁言群成员列表    |
| group     | changeGroupOwner            | 转让群主          |
| group     | getRoleInGroup              | 查询用户在群组中的身份   |
| group     | getRoleInGroup              | 查询用户在群组中的身份   |
| group     | importGroupMember           | 导入群成员         |
| group     | getGroupMemberInfo          | 获取群成员详细资料     |
| group     | modifyGroupMemberInfo       | 修改群成员资料       |
| group     | getGroupAttr                | 获取群自定义属性      |
| group     | modifyGroupAttr             | 修改群自定义属性      |
| group     | clearGroupAttr              | 清空群自定义属性      |
| group     | setGroupAttr                | 重置群自定义属性      |
| group     | getOnlineMemberNum          | 获取直播群在线人数     |
| group     | getMembers                  | 获取直播群在线成员列表   |
| group     | modifyUserInfo              | 设置直播群成员标记     |
| group     | getGroupBanMember           | 获取封禁群成员列表     |
| group     | createTopic                 | 创建话题          |
| group     | destroyTopic                | 解散话题          |
| group     | getTopic                    | 获取话题资料        |
| group     | modifyTopic                 | 修改话题资料        |
| group     | importTopic                 | 导入话题基础资料      |
| group     | getGroupCounter             | 获取群计数器        |
| group     | updateGroupCounter          | 更新群计数器        |
| group     | deleteGroupCounter          | 删除群计数器        |
| message   | sendMsg                     | 单发单聊消息        |
| message   | batchSendMsg                | 批量发单聊消息       |
| message   | sendGroupMsg                | 在群组中发送普通消息    |
| message   | sendGroupSystemNotification | 在群组中发送系统通知    |
| message   | sendBroadCastMsg            | 直播群广播消息       |
| message   | importGroupMsg              | 导入群消息         |
| message   | importMsg                   | 导入单聊消息        |
| message   | modifyC2CMsg                | 修改单聊历史消息      |
| message   | modifyGroupMsg              | 修改群聊历史消息      |
| message   | getGroupMsg                 | 拉取群聊历史消息      |
| message   | getRoamMsg                  | 拉取单聊历史消息      |
| message   | deleteGroupMsgBySender      | 删除指定用户发送的消息   |
| message   | recallMsg                   | 撤回单聊消息        |
| message   | recallGroupMsg              | 撤回群消息         |
| message   | setMsgRead                  | 设置单聊消息已读      |
| message   | getGroupMsgReceiptDetail    | 拉取群消息已读回执详情   |
| message   | getGroupMsgReceipt          | 拉取群消息已读回执信息   |
| message   | getKeyValues                | 拉取单聊消息扩展      |
| message   | setKeyValues                | 设置单聊消息扩展      |
| message   | getGroupKeyValues           | 拉取群消息扩展       |
| message   | setGroupKeyValues           | 设置群消息扩展       |
| message   | push                        | 全员推送          |
| message   | setAttrName                 | 设置应用属性名称      |
| message   | getAttrName                 | 获取应用属性名称      |
| message   | getAttr                     | 获取用户属性        |
| message   | setAttr                     | 设置用户属性        |
| message   | removeAttr                  | 删除用户属性        |
| message   | getTag                      | 获取用户标签        |
| message   | addTag                      | 添加用户标签        |
| message   | removeTag                   | 删除用户标签        |
| message   | removeAllTags               | 删除用户所有标签      |
| session   | getList                     | 拉取会话列表        |
| session   | getC2CUnreadMsgNum          | 查询单聊未读消息计数    |
| session   | setUnreadMsgNum             | 设置群成员未读消息计数   |
| session   | delete                      | 删除单个会话        |
| session   | createContactGroup          | 创建会话分组数据      |
| session   | updateContactGroup          | 更新会话分组数据      |
| session   | deleteContactGroup          | 删除会话分组数据      |
| session   | markContact                 | 创建或更新会话标记数据   |
| session   | searchContactGroup          | 搜索会话分组标记      |
| session   | getContactGroup             | 拉取会话分组标记数据    |
| operation | getAppInfo                  | 拉取运营数据        |
| operation | getHistory                  | 下载最近消息记录      |
| operation | getIPList                   | 获取服务器 IP 地址   |
| operation | forbidIllegalObject         | 聊天文件封禁        |
| operation | allowBannedObject           | 聊天文件解封        |
| operation | getCosSig                   | 聊天文件签名        |
| shutup    | setNoSpeaking               | 设置全局禁言        |
| shutup    | getNoSpeaking               | 查询全局禁言        |
| robot     | create                      | 创建机器人         |
| robot     | delete                      | 删除机器人         |
| robot     | getAll                      | 拉取所有机器人         |

### 贡献

先`fork`,提`pr`

### 协议
MIT