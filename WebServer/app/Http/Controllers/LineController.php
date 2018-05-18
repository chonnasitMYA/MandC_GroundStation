<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LineController extends Controller
{
    //
    public function callback(Request $req)
    {
        $httpClient = new \LINE\LINEBot\HTTPClient\CurlHTTPClient('9vcQYFsWeTWWI4XJhvK4Jh6Qt54LkEWh0TLz41lTbsSvcvT4QYbGrtG4BF6o4XTirZl+eVL0f7jvAHPrzyf0hgeg6+UDFaUhzTdgBupVUEEFQIUgXtFkpG7t5u83kBFQiC7tThlqExUtliV7Sm5U6wdB04t89/1O/w1cDnyilFU=');
        $bot = new \LINE\LINEBot($httpClient, ['channelSecret' => '85439be393dc65d51ad64716e46a4230']);
        $replyToken = $req->events[0]['replyToken'];
        $text=$req->events[0]['messag']['text'];
        $user_id = $require->events[0]['source']['userID'];
        $textMessageBuilder = new \LINE\LINEBot\MessageBuilder\TextMessageBuilder('hello');
        $response = $bot->replyMessage('<reply token>', $textMessageBuilder);
        if ($response->isSucceeded()) {
            echo 'Succeeded!';
            return;
        }

        // Failed
        echo $response->getHTTPStatus() . ' ' . $response->getRawBody();
    }
}
