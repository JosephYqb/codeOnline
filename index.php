<?php
if (empty($_REQUEST)) {
    $html = '
<meta charset="UTF-8">
<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.js"></script>
<label>文件名</label><input id="filename"/>
<textarea  id ="content" name="content" style="width: 100%;height: 300px" onkeydown="ctlSubmit(event)">
<?php
</textarea>
<button id="button"> 提交</button>
<div id="eval"></div>
<script>
    $("#button").click(
        function(){
            $("#eval").load("",{content:$("#content").val(),filename:$("#filename").val()});
        }
    );
    //ctrl +回车
    function ctlSubmit(event) {
        if (event.ctrlKey && event.keyCode == 13) { $("#button").click() }
    }
</script>
';
    echo $html;
} else {
    $content  = @$_REQUEST['content'];
    if($content){
        $filename =  @$_REQUEST['filename'] ? '~save/'.$_REQUEST['filename'].".php" : '~runtime/'.date("Ymdhis") . mt_rand(1000, 9999).".php";
        f($filename, $content);
        ini_set("display_errors", "On");
        error_reporting(E_ALL | E_STRICT);
        include $filename;
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

                // LOG::w($message);
                return false;
            }
        }

        return true;
    }

    if (!is_file($filename)) {
        return false;
    }

    $content = file_get_contents($filename);
    $info    = array(
        'mtime'   => filemtime($filename),
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