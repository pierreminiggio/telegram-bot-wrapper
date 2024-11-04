<?php

namespace PierreMiniggio\TelegramBotWrapper;

class TelegramBot
{
    public function __construct(private string $bot)
    {  
    }

    /**
     * @return int messageId
     */
    public function sendMessageToChat(string $chatId, string $message): int
    {
        $bot = $this->bot;

        $sendMessageCurl = curl_init();
        curl_setopt_array($sendMessageCurl, [
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'https://api.telegram.org/bot' . $bot . '/sendMessage?chat_id=' . $chatId . '&text=' . $message
        ]);
        $sendMessageCurlResponse = curl_exec($sendMessageCurl);
        $httpCode = curl_getinfo($sendMessageCurl)['http_code'];
        curl_close($sendMessageCurl);

        if ($httpCode !== 200) {
            throw new TelegramBotException('send message request failed with code ' . $httpCode . ' : ' . $sendMessageCurlResponse);
        }

        if ($sendMessageCurlResponse === false) {
            throw new TelegramBotException('No body for send message request');
        }

        $sendMessageCurlJsonResponse = json_decode($sendMessageCurlResponse, true);

        if (! $sendMessageCurlJsonResponse) {
            throw new TelegramBotException('Bad JSON for send message request : ' . $sendMessageCurlResponse);
        }

        if (empty($sendMessageCurlJsonResponse['ok'])) {
            throw new TelegramBotException('send message request not ok : ' . $sendMessageCurlResponse);
        }

        if (! isset($sendMessageCurlJsonResponse['result'])) {
            throw new TelegramBotException('send message request missing result key : ' . $sendMessageCurlResponse);
        }

        $fetchedMessage = $sendMessageCurlJsonResponse['result'];

        if (empty($fetchedMessage['message_id'])) {
            throw new TelegramBotException('send message request missing result->message_id key : ' . $sendMessageCurlResponse);
        }

        $messageId = $fetchedMessage['message_id'];

        return $messageId;
    }
}
