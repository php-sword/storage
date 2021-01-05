<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace Sword\Storage;

use Sword\Storage\Drive\Oss;
use Sword\Storage\Drive\ResApi;

/**
 * Class Storage
 *
 * 文件对象储存OSS
 * 使用方法：
 *      $storage = Sword\Storage\Storage::getInstance();
 *      $storage->upload()
 */

class Storage
{
    use StorageSingleton;

    // 储存方式 --默认本地
    private $drive = 'local';
    // 实例
    private $object;
    // 配置信息
    private $config = [
        'public' => './Public', //EASYSWOOLE_ROOT. '/Public/'
    ];

    public function __construct(array $config = [])
    {
        if($config)
            $this->config = $config;
    }

    /**
     * 资源文件保存
     * @param string $file 临时文件路径
     * @param string $target 目标路径
     * @param string|null $type 储存类型 local|oss
     * @return array
     */
    public function upload(string $file, string $target, $type = null): array
    {
        switch ($this->drive) {
            case 'local': //本地储存
                $index = strrpos($target, '/');

                //保存到Public目录下
                $dir = $this->config['public'].substr($target, 0, $index);
                //文件夹创建
                if (!file_exists($dir)){
                    mkdir($dir,0777,true);
                }
                if(copy($file, $dir.'/'.substr($target, $index +1))){
                    return [null, true];
                }
                return ['fail', false];
            case 'oss': //阿里对象储存
                $oss = new Oss();
                return $oss->upload($file, $target);
//            case 'ftp': //FTP服务器
//                $ftp = new FtpClient();
//                return $ftp->upload($file, $target);
            case 'api': //文件服务器接口
                $oss = new ResApi();
                return $oss->upload($file, $target);
            default:
                break;
        }
        return ['fail', false];
    }

    public function delete()
    {

    }

    public function download()
    {

    }

}
