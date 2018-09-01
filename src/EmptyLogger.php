<?php
/**
 * Created by PhpStorm.
 * User: andriyprosekov
 * Date: 01/09/2018
 * Time: 13:16
 */

namespace Audi2014\PushAdapter;


use ApnsPHP_Log_Interface;

class EmptyLogger implements ApnsPHP_Log_Interface {
    public function log($sMessage) {

    }
}