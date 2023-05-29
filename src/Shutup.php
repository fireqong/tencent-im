<?php
/**
 * 禁言
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method setNoSpeaking($array)
 * @method getNoSpeaking($array)
 *
 */
class Shutup extends Client
{
    protected $urlMap = [
        'setNoSpeaking' => '/v4/openconfigsvr/setnospeaking',             //设置全局禁言
        'getNoSpeaking' => '/v4/openconfigsvr/getnospeaking',             //查询全局禁言
    ];
}