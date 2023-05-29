<?php
/**
 * 回调处理器
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * Notes:
 *
 * $app = new App();
 * $app->callbackHandler->addEventHandler('State.StateChange', function() {
 *      //do something.
 * });
 * $app->callbackHandler->handle();
 *
 * @author: church <wolfqong1993@gmail.com>
 * DateTime: 2023/3/18 13:31
 */
class Callbackhandler extends Client
{
    protected $handlers = [];

    protected $hooks = [
        'beforeValidate' => null,
        'afterValidate' => null,
        'beforeHandle' => null,
        'afterHandle' => null,
    ];

    const AUTH_TOKEN = 'token';

    const AUTH_HTTPS = 'https';

    const EVENT_STATE_STATECHANGE = 'State.StateChange';

    const EVENT_PROFILE_CALLBACK_PORTRAIT_SET = 'Profile.CallbackPortraitSet';

    const EVENT_SNS_CALLBACK_PREV_FRIEND_ADD = 'Sns.CallbackPrevFriendAdd';

    const EVENT_SNS_CALLBACK_PREV_FRIEND_RESPONSE = 'Sns.CallbackPrevFriendResponse';

    const EVENT_SNS_CALLBACK_FRIEND_ADD = 'Sns.CallbackFriendAdd';

    const EVENT_SNS_CALLBACK_FRIEND_DELETE = 'Sns.CallbackFriendDelete';

    const EVENT_SNS_CALLBACK_BLACKLIST_ADD = 'Sns.CallbackBlackListAdd';

    const EVENT_SNS_CALLBACK_BLACKLIST_DELETE = 'Sns.CallbackBlackListDelete';

    const EVENT_C2C_CALLBACK_BEFORE_SEND_MSG = 'C2C.CallbackBeforeSendMsg';

    const EVENT_C2C_CALLBACK_AFTER_SEND_MSG = 'C2C.CallbackAfterSendMsg';

    const EVENT_C2C_CALLBACK_AFTER_MSG_REPORT = 'C2C.CallbackAfterMsgReport';

    const EVENT_C2C_CALLBACK_AFTER_MSG_WITHDRAW = 'C2C.CallbackAfterMsgWithDraw';

    const EVENT_GROUP_CALLBACK_BEFORE_CREATE_GROUP = 'Group.CallbackBeforeCreateGroup';

    const EVENT_GROUP_CALLBACK_AFTER_CREATE_GROUP = 'Group.CallbackAfterCreateGroup';

    const EVENT_GROUP_CALLBACK_BEFORE_APPLY_JOIN_GROUP = 'Group.CallbackBeforeApplyJoinGroup';

    const EVENT_GROUP_CALLBACK_BEFORE_INVITE_JOIN_GROUP = 'Group.CallbackBeforeInviteJoinGroup';

    const EVENT_GROUP_CALLBACK_AFTER_NEW_MEMBER_JOIN = 'Group.CallbackAfterNewMemberJoin';

    const EVENT_GROUP_CALLBACK_AFTER_MEMBER_EXIT = 'Group.CallbackAfterMemberExit';

    const EVENT_GROUP_CALLBACK_BEFORE_SEND_MSG = 'Group.CallbackBeforeSendMsg';

    const EVENT_GROUP_CALLBACK_AFTER_SEND_MSG = 'Group.CallbackAfterSendMsg';

    const EVENT_GROUP_CALLBACK_AFTER_GROUP_FULL = 'Group.CallbackAfterGroupFull';

    const EVENT_GROUP_CALLBACK_AFTER_GROUP_DESTROYED = 'Group.CallbackAfterGroupDestroyed';

    const EVENT_GROUP_CALLBACK_AFTER_GROUP_INFO_CHANGED = 'Group.CallbackAfterGroupInfoChanged';

    const EVENT_GROUP_CALLBACK_ON_MEMBER_STATE_CHANGE = 'Group.CallbackOnMemberStateChange';

    const EVENT_GROUP_CALLBACK_SEND_MSG_EXCEPTION = 'Group.CallbackSendMsgException';

    const EVENT_GROUP_CALLBACK_BEFORE_CREATE_TOPIC = 'Group.CallbackBeforeCreateTopic';

    const EVENT_GROUP_CALLBACK_AFTER_CREATE_TOPIC = 'Group.CallbackAfterCreateTopic';

    const EVENT_GROUP_CALLBACK_AFTER_TOPIC_DESTROYED = 'Group.CallbackAfterTopicDestroyed';

    const EVENT_GROUP_CALLBACK_AFTER_TOPIC_INFO_CHANGED = 'Group.CallbackAfterTopicInfoChanged';


    // 允许的事件列表
    const ALLOWED_EVENTS = [
        self::EVENT_STATE_STATECHANGE,
        self::EVENT_PROFILE_CALLBACK_PORTRAIT_SET,
        self::EVENT_SNS_CALLBACK_BLACKLIST_ADD,
        self::EVENT_SNS_CALLBACK_BLACKLIST_DELETE,
        self::EVENT_SNS_CALLBACK_FRIEND_ADD,
        self::EVENT_SNS_CALLBACK_FRIEND_DELETE,
        self::EVENT_SNS_CALLBACK_PREV_FRIEND_ADD,
        self::EVENT_SNS_CALLBACK_PREV_FRIEND_RESPONSE,
        self::EVENT_C2C_CALLBACK_AFTER_MSG_REPORT,
        self::EVENT_C2C_CALLBACK_AFTER_MSG_WITHDRAW,
        self::EVENT_C2C_CALLBACK_AFTER_SEND_MSG,
        self::EVENT_C2C_CALLBACK_BEFORE_SEND_MSG,
        self::EVENT_GROUP_CALLBACK_AFTER_CREATE_GROUP,
        self::EVENT_GROUP_CALLBACK_AFTER_CREATE_TOPIC,
        self::EVENT_GROUP_CALLBACK_AFTER_GROUP_DESTROYED,
        self::EVENT_GROUP_CALLBACK_AFTER_GROUP_FULL,
        self::EVENT_GROUP_CALLBACK_AFTER_GROUP_INFO_CHANGED,
        self::EVENT_GROUP_CALLBACK_AFTER_MEMBER_EXIT,
        self::EVENT_GROUP_CALLBACK_AFTER_NEW_MEMBER_JOIN,
        self::EVENT_GROUP_CALLBACK_AFTER_SEND_MSG,
        self::EVENT_GROUP_CALLBACK_AFTER_TOPIC_DESTROYED,
        self::EVENT_GROUP_CALLBACK_AFTER_TOPIC_INFO_CHANGED,
        self::EVENT_GROUP_CALLBACK_BEFORE_APPLY_JOIN_GROUP,
        self::EVENT_GROUP_CALLBACK_BEFORE_CREATE_GROUP,
        self::EVENT_GROUP_CALLBACK_ON_MEMBER_STATE_CHANGE,
        self::EVENT_GROUP_CALLBACK_SEND_MSG_EXCEPTION,
        self::EVENT_GROUP_CALLBACK_BEFORE_INVITE_JOIN_GROUP,
        self::EVENT_GROUP_CALLBACK_BEFORE_SEND_MSG,
        self::EVENT_GROUP_CALLBACK_BEFORE_CREATE_TOPIC,
    ];

    protected $token = '';

    protected $authWay = '';

    /**
     * 添加事件处理器
     *
     * @param string $event
     * @param callable $callback
     * @return $this
     * @throws \Exception
     */
    public function addEventHandler(string $event, callable $callback)
    {
        if (!in_array($event, self::ALLOWED_EVENTS)) {
            throw new \Exception('不支持的事件，可用的事件为' . join(',', self::ALLOWED_EVENTS));
        }

        $this->handlers[$event] = $callback;

        return $this;
    }

    /**
     * 批量设置事件处理器
     *
     * @param array $handlers
     * @return void
     * @throws \Exception
     */
    public function batchAddEventHandlers(array $handlers)
    {
        foreach ($handlers as $event=>$callback) {
            $this->addEventHandler($event, $callback);
        }
    }

    /**
     * 设置hook
     *
     * @param string $hookName
     * @param callable $callback
     * @return $this
     * @throws \Exception
     */
    public function setHook(string $hookName, callable $callback)
    {
        if (!in_array($hookName, array_keys($this->hooks))) {
            throw new \Exception('不支持的hook');
        }

        $this->hooks[$hookName] = $callback;

        return $this;
    }

    /**
     * 调用hook
     *
     * @param string $hookName
     * @param array $params
     * @return void
     */
    public function callHook(string $hookName, array $params)
    {
        if (is_callable($this->hooks[$hookName])) {
            call_user_func($this->hooks[$hookName], ...$params);
        }
    }

    /**
     * 调用事件处理器
     *
     * @param string $eventName
     * @param array $params
     * @return void
     */
    public function callEventHandle(string $eventName, array $params)
    {
        if (is_callable($this->handlers[$eventName])) {
            return call_user_func($this->handlers[$eventName], ...$params);
        }

        return null;
    }

    /**
     * @param string $token
     * @return $this
     */
    public function setToken(string $token)
    {
        $this->token = $token;

        return $this;
    }

    /**
     * @param string $authWay
     * @return $this
     */
    public function setAuthWay(string $authWay)
    {
        $this->authWay = $authWay;

        return $this;
    }

    /**
     * 处理事件
     *
     * @param array $postData
     * @param string $sdkAppID
     * @param string $callbackCommand
     * @param string $contentType
     * @param string $clientIP
     * @param string $optPlatform
     * @param string $requestTime
     * @param string $sign
     * @return void
     * @throws \Exception
     */
    public function handle(array $postData, string $sdkAppID, string $callbackCommand, string $contentType, string $clientIP, string $optPlatform, string $requestTime, string $sign)
    {
        if (empty($this->authWay) || ($this->authWay != self::AUTH_HTTPS && $this->authWay != self::AUTH_TOKEN)) {
            throw new \Exception('未设置回调鉴权方式，或设置的回调鉴权方式不是' . self::AUTH_TOKEN . '或' . self::AUTH_HTTPS);
        }

        if ($this->authWay == self::AUTH_TOKEN) {
            if (empty($this->token)) {
                throw new \Exception('请先设置token');
            }

            if (!$this->checkSign($requestTime, $sign)) {
                throw new \Exception('不正确的签名');
            }
        }

        $params = func_get_args();

        $this->callHook('beforeValidate', $params);

        if ($sdkAppID != $this->app->getSDKAppID()) {
            throw new \Exception('不正确的sdkAppID');
        }

        if (!isset($this->handlers[$callbackCommand])) {
            throw new \Exception('没有设置处理该事件的回调函数', 404);
        }

        $this->callHook('afterValidate', $params);


        $this->callHook('beforeHandle', $params);

        $result = $this->callEventHandle($callbackCommand, $params);

        $params['result'] = $result;
        $this->callHook('afterHandle', $params);

        return $result;
    }

    /**
     * 检查签名
     *
     * @param string $requestTime
     * @param string $sign
     * @return bool
     */
    public function checkSign(string $requestTime, string $sign): bool
    {
        $str = $this->token . $requestTime;

        return hash('sha256', $str) == $sign;
    }
}