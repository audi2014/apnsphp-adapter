<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 01/09/2018
 * Time: 13:14
 */

namespace Audi2014\PushAdapter;


class Fcm implements AdapterInterface {
    private $key;
    const CONF_APP_KEY = "app_key";

    public function __construct(array $conf) {
        $this->key = $conf[self::CONF_APP_KEY];
    }

    public function sendByTokenArray(array $tokenArray, $text = "", $subject = "subject", $argsArray = []) {

        $notification['body'] = $text;
        $notification['title'] = $subject;
        $url = 'https://fcm.googleapis.com/fcm/send';
        $fields = [
            'registration_ids' => $tokenArray,
            'notification' => $notification,
        ];
        if(!empty($argsArray)) {
             $fields['data'] = $argsArray;
        }
        $headers = [
            'Authorization: key=' . $this->key,
            'Content-Type: application/json'
        ];
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($fields));
        curl_exec($curl);
        $response = curl_exec($curl);
        curl_close($curl);
        return $response;
    }
}