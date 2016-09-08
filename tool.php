<?php

class Tool {

    //清空runtime 目录
    public static function clearRuntimeDir() {
        $runtime_dir = realpath("") . "/~runtime/";
        $dp = @dir($runtime_dir);
        if($dp){
        while ($file = $dp->read()) {
            if($file !='.' && $file != '..'){
                unlink($runtime_dir.$file);
            }
        }
        rmdir($runtime_dir);
        }
    }
}

Tool::clearRuntimeDir();