<?php

namespace Tapin;

class Request
{
    private static string $BASE_URL = "https://api.tapin.ir/api/v2/public/";

    private static array $response;

    private static string $auth;

    public static function setAuthKey(string $authKey)
    {
        self::$auth = $authKey;
    }


    /**
     * Send request
     * @param string $path
     * @param array $data
     * @return array
     */
    public static function send(string $path, array $data=[]): Request
    {
        $headers = [
            "CONTENT-TYPE: application/json",
            "Accept: application/json",
            "Authorization: " . self::$auth,
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
        $url = self::$BASE_URL . $path;
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_ENCODING, '');
        curl_setopt($curl, CURLOPT_MAXREDIRS, 10);
        curl_setopt($curl, CURLOPT_TIMEOUT, 0);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
        curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
        if(count($data) >0 ){
            curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        }
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        try {
            $curlResponse = curl_exec($curl);
            if (is_object(json_decode($curlResponse)))
            {
                self::$response = json_decode($curlResponse,true);
            }else{
                throw new \Exception("The requested resource was not found on this server",500);
            }
            curl_getinfo($curl);
            curl_close($curl);
        }catch (\Exception $e){
            self::$response = ['returns'=>['status'=>500,'message'=>$e->getMessage()]];
        }
        return new self();
    }


    /**
     * return response
     * @return array
     */
    public function body():array
    {
        $returns = self::$response['returns'];
        if($returns['status'] == 200){
            $entries = self::$response['entries'];
            $data = array_key_exists('list',$entries) ? $entries['list'] : $entries;
            if(array_key_exists('count',$entries)){
                $data['pagination'] = [
                    'count'=>$entries['count'],
                    'page'=>$entries['page'],
                    'total_count'=>$entries['total_count']
                ];
            }
            return ['status'=>'success','data'=>$data, 'status_code'=>200];
        }else{
            $entries = array_key_exists('entries',self::$response) ? self::$response['entries'] : [];
            return ['status'=>'error','data'=>['msg'=>$returns['message'],'validationError'=>$entries],'status_code'=>$returns['status']];
        }
    }
}