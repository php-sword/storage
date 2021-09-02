<?php
/**
 * 此文件是Sword/Storage的api接口
 * 接口配置信息
 */
$config = [
    'User' => 'school',
    'Secret' => 'kyourpwd'
];


//显示所有错误信息
// ini_set("display_errors", "On");
// error_reporting(E_ALL);
// ini_set("display_errors", "On");
// error_reporting(E_ALL); //显示所有错误信息

if(empty($_POST['Action'])){
    echo  json_encode(['code' => 100]);
    return;
}

if($_POST['User'] != $config['User'] or $_POST['Secret'] != $config['Secret']){
    echo  json_encode(['code' => 101]);
    return;
}

if($_POST['Action'] == 'upload' and isset($_FILES["file"])){
    if($_FILES["file"]["error"] > 0){
        return json_encode(['code' => 1, 'message' => $_FILES["file"]["error"]]);
    }else{
        $target = $_POST['Path'];
        $index = strrpos($target, '/');

        //保存到Public目录下
        $dir = './'.substr($target, 0, $index);
        //文件夹创建
        if (!file_exists($dir)){
            mkdir($dir,0777,true);
        }

        move_uploaded_file($_FILES["file"]["tmp_name"], $dir. "/" . substr($target, $index +1));
    
        echo json_encode(['code' => 0]);
        return;
    }
}elseif($_POST['Action'] == 'delete'){
    
    $path = $_POST['Path'];
    $files = explode(',', $path);
    foreach ($files as $file){
        $target = './' . $file;
        if(file_exists($target)){
            unlink($target);
        }
    }

    echo json_encode(['code' => 0]);
    return;
}
