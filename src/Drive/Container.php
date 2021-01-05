<?php declare(strict_types=1);
/**
 * This file is part of Sword.
 * @link     http://sword.kyour.cn
 * @document http://sword.kyour.cn/doc
 * @contact  kyour@vip.qq.com
 * @license  http://github.com/php-sword/sword/blob/master/LICENSE
 */

namespace App\Common;

use Sword\Storage\StorageSingleton;

/**
 * Class Container
 *
 * 实现缓存容器 -用于储存全局变量
 * 助手方法 container($name, $val)
 * 获取实列 $ins = App\Common\Container::getInstance();
 * 操作示例 $ins->set('name', 'value')
 * 注意：由于直接保存到内存，并且没有GC机制，酌情使用
 */


class Container
{
    use StorageSingleton;

    private $list = [];

    public function set($name, $value):void
    {
        $this->list[$name] = $value;
    }

    public function get($name = null)
    {
        if($name === null){
            return $this->list;
        }
        if(isset($this->list[$name])){
            return $this->list[$name];
        }else{
            return null;
        }
    }

    public function del($name, $value):void
    {
        unset($this->list[$name]);
    }

}