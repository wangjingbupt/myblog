<?php
/**
 * APP控制层基类
 * 
 */

abstract class control {
	
	/**
	 * 控制层业务错误
	 * @var unknown_type
	 */
	protected $errors = array();
	
	protected function setCError($error_no, $error_msg){
		$this->errors[] = array('errorno'=>$error_no, 'errormsg'=>$error_msg);
	}
	
	protected function getCErrors(){
		return $this->errors;
	}
	
	protected function hasCError(){
		return count($this->errors)>0 ? true : false;
	}

	

	
	public function __construct() {
		//检查链接是否跳转
		if( $this->checkPara() !== FALSE ){
            $this->includeFiles();
            $this->action();
    }
		return;
	}
	
	
	abstract protected function checkPara();//读取参数
	
	public function includeFiles(){}//用于加载Smarty_InsertFunction类似的文件
	
	abstract protected function action();
	
	
	/**
	 * @param string bizid  业务编号
	 * @param enum(json,xml,serialize,html,str) $disType
	 * @param bool $isReturn 返回数据 或者直接输出
	 * @param bool  $fromPub  是否是推送过来的html
	 */
	protected function display($data, $disType='html',$isReturn = FALSE,$fromPub=FALSE) {
		$output = json_encode($data);
		if ($isReturn) return $output;
		echo $output;
	}
	
}
?>
