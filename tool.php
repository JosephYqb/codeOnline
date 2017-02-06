<?php

class Tool {

    //清空runtime 目录
    public  function clearRuntimeDir() {
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
		
		
		return true;
    }
	public function getSaveFile(){
		$filename= isset($_POST['filename']) ? $_POST['filename']:'';
		if($filename==''){
			
			$this->jsonOutPut(array('status'=>0,'msg'=>'文件名为空'));
		}
	
			$filename = dirname(__FILE__).'/~save/'.$filename.'.php';

			if(!file_exists($filename )){
			 $this->jsonOutPut(array('status'=>0,'msg'=>'找不到文件'));
			}
			$fileContent = file_get_contents($filename);
			if($fileContent==false){
				$this->jsonOutPut(array('status'=>0,'msg'=>'找不到文件'));
			}
			
			$this->jsonOutPut(array('status'=>1,'data'=>$fileContent));
			
	}
	private function jsonOutPut($data){
		header('content-type: application/json');
		echo json_encode($data);
		exit;
	}
	

}


$tool = new Tool();
$action = isset($_REQUEST['action'])? $_REQUEST['action'] : '';


if($action && is_callable(array($tool,$action ))){
	$tool->$action();
}