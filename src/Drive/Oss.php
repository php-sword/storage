<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace Sword\Storage\Drive;

/**
 * Class Oss
 *
 * 文件对象储存OSS
 */

use OSS\OssClient;
use OSS\Core\OssException;

class Oss implements DriveInterface
{
    //配置信息
    private $config;

    //连接客户端对象
    private $client;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    //连接客户端
    private function conn() :array
    {
        if($this->client != null){
            return [null, $this->client];
        }
        try{
            $this->client = new OssClient($this->config['AccessKey'], $this->config['Secret'], $this->config['Endpoint']);
            return [null, $this->client];
        } catch(OssException $e) {
            return [$e,null];
        }
    }

    /**
     * 上传文件
     * @param $file string 本地文件地址
     * @param $path string 保存路径(包含文件名)
     * @param $delSource bool 是否删除源文件
     * @return array
     */
    public function upload(string $file, string $path, bool $delSource = false) :array
    {
        //连接云端
        list($err, $client) = $this->conn();
        if($err){
            return [$err,null];
        }
        try{
            //开始上传文件
            $ret = $client->uploadFile($this->config['Bucket'], $path, $file);
            //删除源文件
            $delSource && unlink($file);
            return [null, $ret];
        } catch(OssException $e) {
            //返回报错
            return [$e, null];
        }
    }

    /**
     * 删除文件
     * @param $path string 保存路径(包含文件名)
     * @return array
     */
    public function delete(string $path) :array
    {
        //连接云端
        list($err, $client) = $this->conn();
        if($err) return [$err,null];
        try{
            $ret = $client->deleteObject($this->config['Bucket'], $path);
            return [null, $ret];
        } catch(OssException $e) {
            //返回报错
            return [$e, null];
        }
    }
}
