<?php
if (empty($_REQUEST)) {
 ?>
<meta charset="UTF-8">
<script src="http://apps.bdimg.com/libs/jquery/1.6.4/jquery.js"></script>
<label>文件名</label><input id="filename"/>
<label>打开方式</label>
<input name="open_type" type='radio' value="div" id="open_type1" checked="checked"><label for="open_type1">div</label>
<input name="open_type" type='radio' value="2"  id="open_type2" ><label for="open_type2">iframe</label>  
<textarea  id ="content" name="content" style="width: 100%;height: 300px" onkeydown="ctlSubmit(event)">
&lt;?php
</textarea>
<button id="button"> 提交</button>
<div id="eval"></div>
<script>
      function height_auto(iframe) {
    var doc = iframe.contentWindow.document,
      html = doc.documentElement,
      body = doc.body;
// 获取高度
    var height = Math.max(body.scrollHeight, body.offsetHeight,
      html.clientHeight, html.scrollHeight, html.offsetHeight);
    iframe.setAttribute('height', height);
  }
  </script>
<iframe id="eval_iframe" onload=height_auto(this)></ifarme>
<script>
    $("#button").click(
        function(){

        if($("[name='open_type']:checked").val() == 'div'){
        //div 打开
            $("#eval").load("",{content:$("#content").val(),filename:$("#filename").val(),open_type:"div"});
        } else{
        //iframe

$.ajax({
 type:"POST",
 data:  {content:$("#content").val(),filename:$("#filename").val(),open_type:"iframe"} ,
success:function(date){
  $("#eval_iframe").attr("src",date);
}
})


        }

        }
    );

    //ctrl +回车
    function ctlSubmit(event) {
        if (event.ctrlKey && event.keyCode == 13) { $("#button").click() }
    }

</script>

<?php
} else {
    $content  = @$_REQUEST['content'];
    if($content){
        $filename =  @$_REQUEST['filename'] ? '~save/'.$_REQUEST['filename'].".php" : '~runtime/'.date("Ymdhis") . mt_rand(1000, 9999).".php";
        f($filename, $content);
        ini_set("display_errors", "On");
        error_reporting(E_ALL | E_STRICT);
        if($_REQUEST['open_type']=='div'){
         include $filename;
        }else{

        echo  $filename;
        }

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