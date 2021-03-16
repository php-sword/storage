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

use Sword\Storage\StorageException;

class Local implements DriveInterface
{
    //配置信息
    private $config = [
        'public' => './Public', //EASYSWOOLE_ROOT. '/Public/'
    ];

    public function __construct(array $config = [])
    {
        if($config)
            $this->config = $config;
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
        // TODO: Implement upload() method.
        try{
            $index = strrpos($target, '/');

            //保存到Public目录下
            $dir = $this->config['public'] . substr($target, 0, $index);

            //文件夹创建
            if (!file_exists($dir)){
                mkdir($dir,0777,true);
            }
            $to = $dir.'/'.substr($target, $index +1);
            if(!copy($file, $to)){
                throw new StorageException(__CLASS__ . ': Copy fail. '.$file. '>' .$to);
            }

            $delSource && unlink($file);
        } catch(\Throwable $e) {
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
        // TODO: Implement delete() method.
        try{
            unlink($target);
        } catch(\Throwable $e) {
            throw new StorageException(__CLASS__ . ':'.$e->getMessage());
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
