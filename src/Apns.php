<?php

namespace Audi2014\PushAdapter;

use ApnsPHP_Abstract;
use ApnsPHP_Message;
use ApnsPHP_Push;



class Apns implements AdapterInterface {
    const CONF_APP_CER = "app_cer";
    const CONF_ROOT_AUTHORITY_CER = "root_cer";
    const CONF_LOGGER = "logger";
    const CONF_SANDBOX = "is_sb";
    private $rootCer;
    private $appCer;
    private $logger;
    private $isSandbox;

    public function __construct(array $conf) {
        $this->appCer = $conf[self::CONF_APP_CER];
        $this->rootCer = $conf[self::CONF_ROOT_AUTHORITY_CER] ?? __DIR__ . "/root.pem";
        $this->logger = $conf[self::CONF_LOGGER] ?? new EmptyLogger();
        $this->isSandbox = (bool)$conf[self::CONF_SANDBOX];
    }

    public function sendByTokenArray(array $tokenArray, $text = "", $subject = "subject", $argsArray = null) {
        $push = $this->connect();
        $errors = [];
        if ($tokenArray && !empty($tokenArray) && $push) {
            try {
                $message = new ApnsPHP_Message();
                // Set a custom identifier. To get back this identifier use the getCustomIdentifier() method
                // over a ApnsPHP_Message object retrieved with the getErrors() message.
                //$message->setCustomIdentifier($eventName);
                $message->setSound();
                $message->setText($text);
                $message->setBadge(1);
                $message->setCustomProperty('title', $subject);
                if ($argsArray && is_array($argsArray)) {
                    foreach ($argsArray as $key => $value) {
                        // Set a custom property
                        $message->setCustomProperty($key, $value);
                    }
                }
                // Set the expiry value
                $message->setExpiry(240);
                foreach ($tokenArray as $token) {
                    $message->addRecipient($token);
                }

                $push->add($message);
                $errors = $this->send($push);
            } catch (\Exception $e) {
                $this->logger->log($e->getMessage());
            }
        }
        return $errors;
    }

    /**
     * @return ApnsPHP_Push
     */
    private function connect(): ?ApnsPHP_Push {
        $push = null;
        try {
            $push = new ApnsPHP_Push(
                $this->isSandbox
                    ? ApnsPHP_Abstract::ENVIRONMENT_SANDBOX
                    : ApnsPHP_Abstract::ENVIRONMENT_PRODUCTION,
                $this->appCer
            );

            $push->setLogger($this->logger);
            $push->setRootCertificationAuthority($this->rootCer);
            // Connect to the Apple Push Notification Service
            $push->connect();
        } catch (\Exception $e) {
            $this->logger->log($e->getMessage());
            return null;
        }
        return $push;
    }

    /**
     * @param ApnsPHP_Push $push
     * @return array
     * @throws \ApnsPHP_Push_Exception
     */
    private function send(ApnsPHP_Push $push): array {

        $push->send();
        // Disconnect from the Apple Push Notification Service
        $push->disconnect();
        // Examine the error message container
        return $push->getErrors();

    }
}