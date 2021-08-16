<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace Sword\Storage\Drive;

use Swoole\Coroutine\Http\Client;
use Sword\Storage\StorageException;

/**
 * Class ResApi
 *
 * 文件对象储存OSS
 */

class ResApi implements DriveInterface
{
    //配置信息
    private $config;

    public function __construct(array $config = [])
    {
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
        try{
            //开始上传文件
            $cli = new Client($this->config['Host'], $this->config['Port']);
            $cli->setHeaders([
                'Host' => $this->config['Host']
            ]);
            $cli->set(['timeout' => $this->config['OutTime']]);
            $cli->addFile($file, 'file');
            $cli->post($this->config['Gateway'], [
                'Path' => $target,
                'User' => $this->config['User'],
                'Secret' => $this->config['Secret'],
                'Action' => 'upload'
            ]);

            //删除源文件
            $delSource && unlink($file);

            $cli->close();
            if($cli->getStatusCode() != 200){
                throw new StorageException(__CLASS__ . ': Interface request exception.');
            }
            //echo $cli->body;
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
        try{
            $cli = new Client($this->config['Host'], $this->config['Port']);
            $cli->setHeaders([
                'Host' => $this->config['Host']
            ]);
            $cli->set(['timeout' => 5]);
            $cli->post('/api.php', [
                'Path' => $target,
                'User' => $this->config['User'],
                'Secret' => $this->config['Secret'],
                'Action' => 'delete'
            ]);
//            echo $cli->body;
            $cli->close();

        } catch(\Throwable $e) {
            //返回报错
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
