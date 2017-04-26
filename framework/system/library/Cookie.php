<?php

/**
 * Cookie类
 * @author 刘健 <code.liu@qq.com>
 */

namespace sys;

class Cookie
{

    // 是否初始化完成
    private static $initComplete;

    // 配置
    private static $conf;

    // 客户端发送来的数据
    private static $input;

    // 初始化
    public static function init($conf = null)
    {
        if (!isset(self::$initComplete)) {
            self::$conf         = Config::get('config.cookie');
            self::$input        = $_COOKIE;
            self::$initComplete = true;
        }
        is_null($conf) or self::$conf = array_merge(self::$conf, $conf);
    }

    // 取值
    public static function get($name = null)
    {
        self::init();
        return is_null($name) ? self::$input : (isset(self::$input[$name]) ? self::getSignatureValue($name, self::$input[$name], self::$conf['signature_key']) : null);
    }

    // 赋值
    public static function set($name, $value, $uExpire = null)
    {
        self::init();
        // 定义配置变量
        extract(self::$conf);
        // 签名
        if ($signature_key != '') {
            $value = self::signature($name, $value, $signature_key);
        }
        // 赋值
        $expire = is_null($uExpire) ? $expire : $uExpire;
        setcookie($name, $value, $expire, $domain, $secure, $httponly);
    }

    // 判断是否存在
    public static function has($name)
    {
        self::init();
        
    }

    // 删除
    public static function delete($name)
    {

    }

    // 清除cookie
    public static function clear()
    {

    }

    // 签名
    private static function signature($name, $value, $signatureKey)
    {
        $signature = md5($name . $value . $signatureKey, true);
        return $value . '|' . $signature;
    }

    // 获取签名后的值
    private static function getSignatureValue($name, $value, $signatureKey)
    {
        if (!signatureKey != '') {
            $tmp = explode('|', $value);
            if (count($tmp) >= 2) {
                list($value, $signature) = $tmp;
                if (self::signature($name, $value, $signatureKey) == $signature) {
                    return $value;
                }
            }
            return null;
        }
        return $value;
    }

}
