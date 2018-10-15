<?php

class image{



	public function ceratepic(){

		$APPID = 'wx4d645509e43528f0';
   		$SECRET = '8dc9388504534b4848df99019bac3616';
		$url= 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid='.$APPID.'&secret='.$SECRET;
		$data = $this->curl($url);
		$TOKENarr =  json_decode($data,true);
		$postdata = ['path'=>'pages/index/index','width'=>430];
		$imgeurl = 'https://api.weixin.qq.com/wxa/getwxacode?access_token='.$TOKENarr['access_token'];
		$imgdata = $this->curl($imgeurl,json_encode($postdata));
		$imageName = "25220_".date("His",time())."_".rand(1111,9999).'.jpg';
		$path = ROOT_PATH .DS."public".DS."uploads".DS. $imageName;
		file_put_contents($path,$imgdata);

		//生成缩图
		$img = imagecreatefromjpeg($path);
		$npath = ROOT_PATH .DS."public".DS."uploads".DS;
		$newimage = imagecreatetruecolor(200, 200);
		imagecopyresized($newimage, $img , 0, 0, 0, 0, 200, 200, 430, 430);
		imagejpeg($newimage, $npath.'news.jpg');
		
		//背景图片
		$dsim = imagecreatefromjpeg($npath.'bg.jpg');
		//文字合成图片
		$str = $_POST["title"];
		$color = imagecolorallocate($dsim, 245, 0, 0);
		$text = mb_convert_encoding($str,"UTF-8" );
		imagettftext($dsim,  $_POST["fontsize"], 0, 200, 100, $color, ROOT_PATH .DS."public".DS."msyhbd.ttc", $text);
		//小图片合并
		$dsin = imagecreatefromjpeg($npath.'news.jpg');
		imagecopy($dsim, $dsin, 680/2-100, 349-214, 0, 0, 200, 200);
		$imagename = $_POST["imgname"].'.jpg';
		$imageaddress = $npath.$imagename;
		$dsres = imagejpeg($dsim,$imageaddress);
		if($dsres){
			unlink($npath.'news.jpg');
			unlink($path);

			echo json_encode('http://localhost/public/uploads/'.$imagename);
		}
		

	}

	public function curl($url,$data = null){
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, FALSE);
        if (!empty($data)){//post方式
            curl_setopt($curl, CURLOPT_POST, 1);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        }
        //获取采集结果
        $output = curl_exec($curl);
        //关闭cURL链接
        curl_close($curl);
        return $output;
    }
}