<?php

namespace App\Http\Traits;

trait Response
{
	public function successCode()
	{
		return [200, 201, 202];
	}

	//by taha
	//message is string
	//dataOrErrors is data if (200,201,202) else errors
	//code 200,404 .........
	//meta is array as ['token'=>$token , 'count'=>20]
	public  function ResponseApi($message = '', $dataOrErrors = null, $code = 200, $meta = [])
	{
        if($code != 200 && ($dataOrErrors == [] ||$dataOrErrors == null || $dataOrErrors == "")){
            $dataOrErrors = [];
             $dataOrErrors['message'] =[$message];
//            $dataOrErrors['message'] =$message;
        }

//        if($code != 200 && !preg_match("/(android|avantgo|blackberry|bolt|boost|cricket|docomo|fone|hiptop|mini|mobi|palm|phone|pie|tablet|up\.browser|up\.link|webos|wos)/i", $_SERVER["HTTP_USER_AGENT"])){
//            //hey I'm a mobile device
//            $message = '';
//        }
		$array = [
			'status' => in_array($code, $this->successCode()) ? true : false,
			'message' => ($message == null) ? '' : $message,
			in_array($code, $this->successCode()) ? 'data' : 'errors'  => $dataOrErrors,
		];
		if (!empty($meta))
			foreach ($meta as $key => $value) {
				$array[$key] = $value;
			}

		return response($array, $code);
	}
}
