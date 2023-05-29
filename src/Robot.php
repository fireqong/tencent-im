<?php
/**
 * 机器人
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

/**
 * @method create($array)
 * @method delete($array)
 * @method getAll($array)
 */
class Robot extends Client
{
    protected $urlMap = [
        'create' => '/v4/openim_robot_http_svc/create_robot',             //创建机器人
        'delete' => '/v4/openim_robot_http_svc/delete_robot',             //删除机器人
        'getAll' => '/v4/openim_robot_http_svc/get_all_robots',           //拉取所有机器人
    ];
}