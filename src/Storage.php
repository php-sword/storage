<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace Sword\Storage;

//use Sword\Storage\Drive\Ftp;
use Sword\Storage\Drive\Local;
use Sword\Storage\Drive\AliOss;
use Sword\Storage\Drive\ResApi;

/**
 * Class Storage
 *
 * 文件对象储存OSS
 * 使用方法：
 *      Storage::getInstance($config);
 *
 *      $storage = Storage::getInstance()->getObject();
 *      $storage->upload(...);
 */

class Storage
{
    /**
     * 单例对象
     * @var Storage
     */
    private static $instance;

    /**
     * 储存方式 --默认本地
     * @var string
     */
    private $drive;

    /**
     * 实例对象
     * @var Local|AliOss|ResApi
     */
    private $object;

    /**
     * 配置信息
     * @var array|string[]
     */
    private $config = [
        'drive' => 'local',
        'public' => './Public', //EASYSWOOLE_ROOT. '/Public/'
    ];

    public function __construct(array $config = [])
    {
        if($config)
            $this->config = $config;

        //默认驱动
        $this->drive = $this->config['drive'];

        if(!isset($this->config['dev_'.$this->drive])){
            throw new StorageException(__CLASS__ . ': Configuration information does not exist: dev_'.$this->drive);
        }

        $dev_config = $this->config['dev_'.$this->drive];

        //实例化驱动
        switch ($this->drive){
            case "local":
                $this->object = new Local($dev_config);
                break;
            case "alioss":
                $this->object = new AliOss($dev_config);
                break;
            case "api":
                $this->object = new ResApi($dev_config);
                break;
//            case "ftp":
//                $this->object = new Ftp($config);
//                break;
        }

        if($config)
            $this->config = $config;
    }

    /**
     * 获取实例
     * @return Local|AliOss|ResApi
     */
    public function getObject()
    {
        return $this->object;
    }

    /**
     * @return Storage
     */
    public static function getInstance(): Storage
    {
        return self::$instance;
    }

    /**
     * @param mixed ...$args
     * @return Storage
     * @throws StorageException
     */
    public static function setInstance(...$args): Storage
    {
        if(!isset(self::$instance)){
            self::$instance = new static(...$args);
        }
        return self::$instance;
    }
}
