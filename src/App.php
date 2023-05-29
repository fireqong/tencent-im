<?php
/**
 * 主程序文件
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 *
 * @property Account $account
 * @property Callbackhandler $callbackHandler
 * @property Group $group
 * @property Message $message
 * @property Session $session
 * @property Shutup $shutUp
 * @property Operation $operation
 * @property Tlssigapiv2 $TLSSigAPIv2
 *
 * @author: church <wolfqong1993@gmail.com>
 * DateTime: 2023/3/16 14:03
 */
class App
{
    protected $SDKAppID = '';

    protected $key = '';

    protected $adminUserID = '';

    protected $adminUserSig = '';

    protected $objects = [];

    public function __construct($SDKAppID, $key, $adminUserID)
    {
        $this->SDKAppID = $SDKAppID;
        $this->key = $key;

        $this->setAdminUserID($adminUserID);

        return $this;
    }

    /**
     * @param string $adminUserID
     */
    public function setAdminUserID($adminUserID)
    {
        $this->adminUserID = $adminUserID;
        $this->adminUserSig = $this->TLSSigAPIv2->genUserSig($adminUserID);

        return $this;
    }

    /**
     * @return string
     */
    public function getAdminUserID(): string
    {
        return $this->adminUserID;
    }

    /**
     * @return string
     */
    public function getAdminUserSig(): string
    {
        return $this->adminUserSig;
    }

    /**
     * @return string
     */
    public function getSDKAppID()
    {
        return $this->SDKAppID;
    }

    /**
     * @return string
     */
    public function getKey()
    {
        return $this->key;
    }

    public function __get($field)
    {
        $class = ucfirst(strtolower($field));

        $class = __NAMESPACE__ . '\\' . $class;

        if (!class_exists($class)) {
            throw new \Exception($class . '类不存在');
        }

        if (!isset($this->objects[$class])) {
            $this->objects[$class] = new $class($this);
        }

        return $this->objects[$class];
    }

}