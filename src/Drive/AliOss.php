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
 * 使用该驱动请require "aliyuncs/oss-sdk-php": "^2.4"
 */

use OSS\OssClient;
use OSS\Core\OssException;
use Sword\Storage\StorageException;

class AliOss implements DriveInterface
{
    //配置信息
    private $config;

    //连接客户端对象
    private $client;

    public function __construct(array $config = [])
    {
        $this->config = $config;
    }

    /**
     * 连接客户端
     * @return OssClient
     * @throws OssException
     */
    private function conn(): OssClient
    {
        if($this->client == null){
            $this->client = new OssClient($this->config['AccessKey'],
                $this->config['Secret'], $this->config['Endpoint']);
        }
        return $this->client;
    }

    /**
     * 上传文件
     * @param $file string 本地文件地址
     * @param $target string 保存路径(包含文件名)
     * @param $delSource bool 是否删除源文件
     * @throws StorageException
     */
    public function upload(string $file, string $target, bool $delSource = false)
    {
        try{
            //连接云端
            $client = $this->conn();

            //开始上传文件
            $client->uploadFile($this->config['Bucket'], $target, $file);

            //删除源文件
            $delSource && unlink($file);
        } catch(OssException $e) {
            throw new StorageException(__CLASS__ . ':'.$e->getMessage());
        }
    }

    /**
     * 删除文件
     * @param $target string 文件路径(包含文件名)
     * @throws StorageException
     */
    public function delete(string $target)
    {
        try{
            //连接云端
            $client = $this->conn();

            $client->deleteObject($this->config['Bucket'], $target);
        } catch(OssException $e) {
            throw new StorageException(__CLASS__ . ':'.$e->getErrorMessage());
        }
    }

    /**
     * 下载
     * @param $target string 远程路径(包含文件名)
     * @param $file string 本地路径(包含文件名)
     * @throws StorageException
     */
    public function download(string $target, string $file)
    {
        // TODO: Implement download() method.
    }
}
