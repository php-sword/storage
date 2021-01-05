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
 * Class DriveInterface
 * 实现接口
 */

interface DriveInterface
{
    /**
     * 上传文件
     * @param $file string 本地文件地址
     * @param $path string 保存路径(包含文件名)
     * @param $delSource bool 是否删除源文件
     * @return array
     */
    public function upload(string $file, string $path, bool $delSource = false) :array;

    /**
     * 删除文件
     * @param $path string 保存路径(包含文件名)
     * @return array
     */
    public function delete(string $path) :array;

}