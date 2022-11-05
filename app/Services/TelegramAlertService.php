<?php

namespace App\Services;

use GuzzleHttp\Client;


class TelegramAlertService {
    
    protected static $_url = 'https://api.telegram.org/bot';
    protected static $_token = '902669368:AAHQkV_RX60WEPrY_J4KG6ocZLLPH3LfILo';


    public static function sendMessage($text, $isNeedPretty=false)
    {
        $chatId = '-538344338';

        if ($isNeedPretty) {
            $text = json_encode($text, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
        }

        $detail = '';
        if (!is_string($text)) {
            $detail = "\n Message: ". $text->getMessage()
                . "\n Line: " . $text->getLine()
                . "\n File: " . $text->getFile();
        }else {
            $detail = "\n Message: " . $text;
        }

        $text = "=== Thông tin lỗi ===
            \n URL: ".request()->url() ?? 'Không xác định'."
            \n Method: ".request()->route() ?? request()->route()->getActionName() ?? 'Không xác định';

        $text .= $detail;

        return self::pushNoty(['chat_id' => $chatId, 'text' => $text]);
    }

    public static function pushNoty(array $params=[]) {
        $uri = self::$_url . self::$_token . '/sendMessage?parse_mode=html';
        $option['verify'] = false;
        $option['form_params'] = $params;
        $option['http_errors'] = false;
        $client = new Client();
        $response = $client->request("POST", $uri, $option);
        return json_decode($response->getBody(), true);
    }
} // End class