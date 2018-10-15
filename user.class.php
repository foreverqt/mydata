<?php
//http://localhost/?mod=user&act=select

class user{

	function test(){
		$db	= new db;
		$getPage = intval($_REQUEST['page'])?intval($_REQUEST['page']):1;
	    $pagesize = 1;
	    $page = ($getPage-1)*$pagesize;
	    $limit = 'limit '.$page.','.$pagesize;
	    $res =  $db->sqlselect("user",'','','',$limit);
	    foreach ($res  as $key => $value) {
	    	 foreach ($value as $keys => $values) {
	    	 	 if($keys=='img'){
	    	 	 	$res[$key]['img']  = explode(',', $values);
	    	 	 }
	    	 }
	    }
	    print_r($res);
	}

	function upfile(){
		$filetmp = $_FILES['file']['tmp_name'];
		$imagename = rand(0,99).time().'.jpg';
		$image = $GLOBALS['uploads'].'/'.$imagename;
		$res = move_uploaded_file($filetmp,$image);
		if($res){
			echo 'public/uploads/'.$imagename;
		}else{
			echo  false;
		}	
	}

	function insert(){
		$db = new db();
		$_POST['time'] = time();  
		$array = $_POST;
	 	$res =$db->sqlinsert('user',$array);
	 	if($res){
	 		echo '200';
	 	}else{
	 		echo '500';
	 	}
	}

	function sqlfind(){

			$db	= new db;
			$id = intval($_REQUEST['id']);
			$res = $db->sqlselect("user",'*','where id='.$id);
			echo json_encode($res);

	}

	function select(){
	  	$db	= new db;
	  	 // $count = $db->sqlcount('user');//统计总数
	    $getPage = intval($_REQUEST['page'])?intval($_REQUEST['page']):1;
	    $pagesize =30;
	    $page = ($getPage-1)*$pagesize;
	    $limit = 'limit '.$page.','.$pagesize;
	    $res =  $db->sqlselect("user",'','','',$limit);
	  	echo json_encode($res);
 	}

	

	function update(){
			$array = ['area'=>'北京','cityname'=>'通州'];
			$res = $this->sqlupdate($array,3,'city');
			if($res){
	 			echo '更新成功';
		 	}else{
		 		echo '更新失败';
		 	}

	}

	function delete(){
		$db=new db;
  		$id = $_REQUEST['id'];
	  	$res = $db->sqldelete($id,"user");
	  	if($res){
	  		echo 200;
	  	}else{
	  		echo 500;
	  	}
	}
}

?>