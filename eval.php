<?php

$content = @$_REQUEST['content'];
if ($content) {
    $filename = @$_REQUEST['filename'] ? '~save/' . $_REQUEST['filename'] . ".php" : '~runtime/' . md5($content). ".php";
    f($filename, $content);
    ini_set("display_errors", "On");
    error_reporting(E_ALL | E_STRICT);
    if ($_REQUEST['open_type'] == 'div') {
        include $filename;
    } else {

        echo $filename;
    }
}
// 文件保存函数
function f($filename, $content = '', $path = '')
{
    if ('' !== $content) {
        // 删除文件
        if (null === $content) {
            return is_file($filename) ? unlink($filename) : false;
        } else {
            $dir = dirname($filename);
            if (!is_dir($dir)) {
                mkdir($dir, 0755, true);
            }

            if (false === file_put_contents($filename, $content)) {
                $message = '文件写入失败：' . $filename;
                return false;
            }
        }

        return true;
    }

    if (!is_file($filename)) {
        return false;
    }

    $content = file_get_contents($filename);
    $info    = array('mtime'   => filemtime($filename),
                     'content' => unserialize($content)
    );

    return $info;
}

// 打印数组函数
function d($value, $memo = '')
{
    echo '<pre>';

    if ($memo != '') {
        echo $memo . ':<br/>';
    }

    var_dump($value);

    echo '</pre>';
}