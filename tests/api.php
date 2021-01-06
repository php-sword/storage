<?php
/**
 * 接口配置信息
 * 请修改信息才可使用，出于安全考虑
 */
$config = [
    'User' => 'user',
    'Secret' => 'xxx'
];

/**
 * 程序部分 =.= 若无特殊需要，请勿修改
 */

//显示所有错误信息
// ini_set("display_errors", "On");
// error_reporting(E_ALL);
// ini_set("display_errors", "On");
// error_reporting(E_ALL);

// 安全验证 -默认配置
if($config['User'] == 'user' and $config['User'] == 'xxx'){
    echo json_encode(['code' => 100, 'message' => '请修改默认的 $config 配置内容，避免发生安全事故！']);
    return;
}

if (empty($_POST['Action'])) {
    echo json_encode(['code' => 100]);
    return;
}

if ($_POST['User'] != $config['User'] or $_POST['Secret'] != $config['Secret']) {
    echo json_encode(['code' => 101]);
    return;
}

if ($_POST['Action'] == 'upload' and isset($_FILES["file"])) {
    if ($_FILES["file"]["error"] > 0) {
        // echo "错误：" . $_FILES["file"]["error"] . "<br>";
        return json_encode(['code' => 1, 'message' => $_FILES["file"]["error"]]);
    } else {
        $target = $_POST['Path'];
        $index = strrpos($target, '/');

        //保存到Public目录下
        $dir = './' . substr($target, 0, $index);
        //文件夹创建
        if (!file_exists($dir)) {
            mkdir($dir, 0777, true);
        }

        move_uploaded_file($_FILES["file"]["tmp_name"], $dir . "/" . substr($target, $index + 1));

        echo json_encode(['code' => 0]);
        return;
    }
} elseif ($_POST['Action'] == 'delete') {

    $target = './' . $_POST['Path'];
    if (file_exists($target)) {
        unlink($target);
    }
    echo json_encode(['code' => 0]);
    return;
}
