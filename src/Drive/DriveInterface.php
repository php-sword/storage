<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace Sword\Storage\Drive;

use Sword\Storage\StorageException;

/**
 * Class DriveInterface
 * 实现接口
 */

interface DriveInterface
{
    /**
     * 上传文件
     * @param $file string 本地文件地址
     * @param $target string 保存路径(包含文件名)
     * @param $delSource bool 是否删除源文件
     * @throws StorageException
     */
    public function upload(string $file, string $target, bool $delSource = false);

    /**
     * 删除文件
     * @param $target string 保存路径(包含文件名)
     * @throws StorageException
     */
    public function delete(string $target);

    /**
     * 下载
     * @param $target string 远程路径(包含文件名)
     * @param $file string 本地路径(包含文件名)
     * @throws StorageException
     */
    public function download(string $target, string $file);

}