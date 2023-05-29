<?php
/**
 * 客户端
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */

namespace Church\TencentIm;

abstract class Client
{
    protected $baseUri = 'https://console.tim.qq.com';

    protected $client = null;

    protected ?App $app;

    public function __construct($app)
    {
        $this->app = $app;
    }

    public function send($uri, $params)
    {
        if (is_null($this->client)) {
            $this->client = new \GuzzleHttp\Client(['base_uri' => $this->baseUri]);
        }

        $queryString = http_build_query([
            'sdkappid' => $this->app->getSDKAppID(),
            'identifier' => $this->app->getAdminUserID(),
            'usersig' => $this->app->getAdminUserSig(),
            'random' => mt_rand(0, 4294967295),
            'contenttype' => 'json'
        ]);

        $data['header'] = ['Content-Type' => 'application/json'];
        if ($params) {
            $data['body'] = json_encode($params);
        }

        $res = $this->client->request('POST', $uri . '?' . $queryString, $data);

        if ($res->getStatusCode() == 200) {
            $result = $res->getBody()->getContents();
            return json_decode($result, true);
        }

        throw new \Exception($res->getBody()->getContents());
    }

    public function __call($method, $params)
    {
        $methods = array_keys($this->urlMap);
        if (!in_array($method, $methods)) {
            throw new \Exception('不支持的方法');
        }

        return $this->send($this->urlMap[$method], ...$params);
    }
}