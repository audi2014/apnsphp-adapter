<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 01/09/2018
 * Time: 13:13
 */

namespace Audi2014\ApnsAdapter;


interface AdapterInterface {
    public function sendByTokenArray(array $tokenArray, $text = "", $subject = "subject", $argsArray = null);

}