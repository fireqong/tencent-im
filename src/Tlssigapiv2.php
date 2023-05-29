<?php

namespace Church\TencentIm;

/**
 * 获取用户签名类
 * @author      church<wolfqong1993@gmail.com>
 * @since        1.0
 */
class Tlssigapiv2 {

    private $key = false;
    private $sdkappid = 0;

    /**
     * 【功能说明】用于签发 TRTC 和 IM 服务中必须要使用的 UserSig 鉴权票据
     *
     * @param $userid
     * @param $expire
     * @return array|string|string[]
     * @throws \Exception
     */
    public function genUserSig( $userid, $expire = 86400*180 ) {
        return $this->__genSig( $userid, $expire, '', false );
    }

    /**
     * 用于签发 TRTC 进房参数中可选的 PrivateMapKey 权限票据。
     *
     * @param $userid
     * @param $expire
     * @param $roomID
     * @param $privilegeMap
     * @return array|string|string[]
     * @throws \Exception
     */
    public function genPrivateMapKey( $userid, $expire, $roomID, $privilegeMap ) {
        $userBuf = $this->__genUserBuf( $userid, $roomID, $expire, $privilegeMap, 0, '' );
        return $this->__genSig( $userid, $expire, $userBuf, true );
    }

    /**
     * 用于签发 TRTC 进房参数中可选的 PrivateMapKey 权限票据。
     *
     * @param $userid
     * @param $expire
     * @param $roomStr
     * @param $privilegeMap
     * @return array|string|string[]
     * @throws \Exception
     */
    public function genPrivateMapKeyWithStringRoomID( $userid, $expire, $roomStr, $privilegeMap ) {
        $userBuf = $this->__genUserBuf( $userid, 0, $expire, $privilegeMap, 0, $roomStr );
        return $this->__genSig( $userid, $expire, $userBuf, true );
    }

    public function __construct( App $app ) {
        $this->sdkappid = $app->getSDKAppID();
        $this->key = $app->getKey();
    }

    /**
     * 用于 url 的 base64 encode
     *
     * @param $string
     * @return array|string|string[]
     * @throws \Exception
     */
    private function base64UrlEncode( $string ) {
        static $replace = Array( '+' => '*', '/' => '-', '=' => '_' );
        $base64 = base64_encode( $string );
        if ( $base64 === false ) {
            throw new \Exception( 'base64_encode error' );
        }
        return str_replace( array_keys( $replace ), array_values( $replace ), $base64 );
    }

    /**
     * 用于 url 的 base64 decode
     *
     * @param $base64
     * @return string
     * @throws \Exception
     */
    private function base64UrlDecode( $base64 ) {
        static $replace = Array( '+' => '*', '/' => '-', '=' => '_' );
        $string = str_replace( array_values( $replace ), array_keys( $replace ), $base64 );
        $result = base64_decode( $string );
        if ( $result == false ) {
            throw new \Exception( 'base64UrlDecode error' );
        }
        return $result;
    }


    /**
     * TRTC业务进房权限加密串使用用户定义的userbuf
     *
     * @param $account
     * @param $dwAuthID
     * @param $dwExpTime
     * @param $dwPrivilegeMap
     * @param $dwAccountType
     * @param $roomStr
     * @return string
     */
    private function __genUserBuf( $account, $dwAuthID, $dwExpTime, $dwPrivilegeMap, $dwAccountType,$roomStr ) {

        //cVer  unsigned char/1 版本号，填0
        if($roomStr == '')
            $userBuf = pack( 'C1', '0' );
        else
            $userBuf = pack( 'C1', '1' );

        $userBuf .= pack( 'n', strlen( $account ) );
        //wAccountLen   unsigned short /2   第三方自己的帐号长度
        $userBuf .= pack( 'a'.strlen( $account ), $account );
        //buffAccount   wAccountLen 第三方自己的帐号字符
        $userBuf .= pack( 'N', $this->sdkappid );
        //dwSdkAppid    unsigned int/4  sdkappid
        $userBuf .= pack( 'N', $dwAuthID );
        //dwAuthId  unsigned int/4  群组号码/音视频房间号
        $expire = $dwExpTime + time();
        $userBuf .= pack( 'N', $expire );
        //dwExpTime unsigned int/4  过期时间 （当前时间 + 有效期（单位：秒，建议300秒））
        $userBuf .= pack( 'N', $dwPrivilegeMap );
        //dwPrivilegeMap unsigned int/4  权限位
        $userBuf .= pack( 'N', $dwAccountType );
        //dwAccountType  unsigned int/4
        if($roomStr != '')
        {
            $userBuf .= pack( 'n', strlen( $roomStr ) );
            //roomStrLen   unsigned short /2   字符串房间号长度
            $userBuf .= pack( 'a'.strlen( $roomStr ), $roomStr );
            //roomStr   roomStrLen 字符串房间号
        }
        return $userBuf;
    }

    /**
     * 加密算法
     *
     * @param $identifier
     * @param $currentTime
     * @param $expire
     * @param $base64UserBuf
     * @param $userBufEnabled
     * @return string
     */
    private function hmacsha256( $identifier, $currentTime, $expire, $base64UserBuf, $userBufEnabled ) {
        $contentToBeSigned = 'TLS.identifier:' . $identifier . "\n"
            . 'TLS.sdkappid:' . $this->sdkappid . "\n"
            . 'TLS.time:' . $currentTime . "\n"
            . 'TLS.expire:' . $expire . "\n";
        if ( true == $userBufEnabled ) {
            $contentToBeSigned .= 'TLS.userbuf:' . $base64UserBuf . "\n";
        }
        return base64_encode( hash_hmac( 'sha256', $contentToBeSigned, $this->key, true ) );
    }

    /**
     * 生成签名
     *
     * @param $identifier
     * @param $expire
     * @param $userbuf
     * @param $userbuf_enabled
     * @return string
     * @throws \Exception
     */
    private function __genSig( $identifier, $expire, $userBuf, $userBufEnabled ) {
        $currentTime = time();
        $sigArray = Array(
            'TLS.ver' => '2.0',
            'TLS.identifier' => strval( $identifier ),
            'TLS.sdkappid' => intval( $this->sdkappid ),
            'TLS.expire' => intval( $expire ),
            'TLS.time' => intval( $currentTime )
        );

        $base64UserBuf = '';
        if ( true == $userBufEnabled ) {
            $base64UserBuf = base64_encode( $userBuf );
            $sigArray['TLS.userbuf'] = strval( $base64UserBuf );
        }

        $sigArray['TLS.sig'] = $this->hmacsha256( $identifier, $currentTime, $expire, $base64UserBuf, $userBufEnabled );
        if ( $sigArray['TLS.sig'] === false ) {
            throw new \Exception( 'base64_encode error' );
        }
        $jsonStrSig = json_encode( $sigArray );
        if ( $jsonStrSig === false ) {
            throw new \Exception( 'json_encode error' );
        }
        $compressed = gzcompress( $jsonStrSig );
        if ( $compressed === false ) {
            throw new \Exception( 'gzcompress error' );
        }
        return $this->base64UrlEncode( $compressed );
    }

    /**
     * 验证签名
     *
     * @param $sig
     * @param $identifier
     * @param $init_time
     * @param $expire_time
     * @param $userbuf
     * @param $error_msg
     * @return bool
     */
    private function __verifySig( $sig, $identifier, &$initTime, &$expireTime, &$userBuf, &$errorMsg ) {
        try {
            $errorMsg = '';
            $compressedSig = $this->base64UrlDecode( $sig );
            $preLevel = error_reporting( E_ERROR );
            $uncompressedSig = gzuncompress( $compressedSig );
            error_reporting( $preLevel );
            if ( $uncompressedSig === false ) {
                throw new \Exception( 'gzuncompress error' );
            }
            $sigDoc = json_decode( $uncompressedSig );
            if ( $sigDoc == false ) {
                throw new \Exception( 'json_decode error' );
            }
            $sigDoc = ( array )$sigDoc;
            if ( $sigDoc['TLS.identifier'] !== $identifier ) {
                throw new \Exception( "identifier dosen't match" );
            }
            if ( $sigDoc['TLS.sdkappid'] != $this->sdkappid ) {
                throw new \Exception( "sdkappid dosen't match" );
            }
            $sig = $sigDoc['TLS.sig'];
            if ( $sig == false ) {
                throw new \Exception( 'sig field is missing' );
            }

            $initTime = $sigDoc['TLS.time'];
            $expireTime = $sigDoc['TLS.expire'];

            $curr_time = time();
            if ( $curr_time > $initTime+$expireTime ) {
                throw new \Exception( 'sig expired' );
            }

            $userBufEnabled = false;
            $base64UserBuf = '';
            if ( isset( $sigDoc['TLS.userbuf'] ) ) {
                $base64UserBuf = $sigDoc['TLS.userbuf'];
                $userBuf = base64_decode( $base64UserBuf );
                $userBufEnabled = true;
            }
            $sigCalculated = $this->hmacsha256( $identifier, $initTime, $expireTime, $base64UserBuf, $userBufEnabled );

            if ( $sig != $sigCalculated ) {
                throw new \Exception( 'verify failed' );
            }

            return true;
        } catch ( \Exception $ex ) {
            $errorMsg = $ex->getMessage();
            return false;
        }
    }

    /**
     * 带 userbuf 验证签名。
     *
     * @param $sig
     * @param $identifier
     * @param $initTime
     * @param $expireTime
     * @param $errorMsg
     * @return bool
     */
    public function verifySig( $sig, $identifier, &$initTime, &$expireTime, &$errorMsg ) {
        $userBuf = '';
        return $this->__verifySig( $sig, $identifier, $initTime, $expireTime, $userBuf, $errorMsg );
    }

    /**
     * 验证签名
     *
     * @param $sig
     * @param $identifier
     * @param $initTime
     * @param $expireTime
     * @param $userBuf
     * @param $errorMsg
     * @return bool
     */
    public function verifySigWithUserBuf( $sig, $identifier, &$initTime, &$expireTime, &$userBuf, &$errorMsg ) {
        return $this->__verifySig( $sig, $identifier, $initTime, $expireTime, $userBuf, $errorMsg );
    }
}