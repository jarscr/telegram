<?php

namespace Longman\TelegramBot\Commands\UserCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ServerResponse;
use Longman\TelegramBot\Entities\Keyboard;
use Longman\TelegramBot\Entities\InlineKeyboard;


class IntegracionCommand extends UserCommand
{
    protected $name = 'integracion';                      // Your command's name
    protected $description = 'Informacion de Integraciones'; // Your command description
    protected $usage = '/integracion plataforma';                    // Usage of your command
    protected $version = '1.0.0';                  // Version of your command

    public function execute(): ServerResponse
    {
        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();   // Get the current Chat ID

        $text = 'Para obtener información mas especifica: '. $this->getUsage();

        $plataforma = trim($this->getMessage()->getText(true));
       

        if ($plataforma !== '') {
            $text = $this->getPlatformData(strtoupper($plataforma));
        }

        $keyboards[] = new Keyboard(
            ['text' => 'Prestashop'],
            ['texto'=>'WordPress']
        );

        $inline_keyboard = new InlineKeyboard([
            ['text' => 'WordPress', 'switch_inline_query_current_chat' => '/integracion WordPress'],
            ['text' => 'Prestashop', 'switch_inline_query_current_chat' => '/integracion Prestashop'],
        ]);

        return $this->replyToChat('Inline Keyboard', [
            'reply_markup' => $inline_keyboard,
        ]);

       
        $data = [
            'chat_id' => $chat_id,
            'text'    => $text,
        ];

       /* shuffle($keyboards);
        $keyboard = end($keyboards)
            ->setResizeKeyboard(true)
            ->setOneTimeKeyboard(true)
            ->setSelective(false);

        return $this->replyToChat('Seleccione una Opción!', [
            'reply_markup' => $keyboard,
        ]);*/
        return $this->replyToChat('Seleccione una Opción', [
            'reply_markup' => $inline_keyboard,
        ]);
       // return Request::sendMessage($data);
    }

    private function getPlatformData($plataforma): string
    {

        $message = $this->getMessage();            // Get Message object

        $chat_id = $message->getChat()->getId();

        if($plataforma=="WORDPRESS"){
            $text = 'Contamos con Plugin para Banco Nacional, Banco de Costa Rica, Promerica, Credix y Bac San José';
            $data = [
                'chat_id' => $chat_id,
                'text'    => $text,
            ];
            return Request::sendMessage($data);
        }elseif($plataforma=="PRESTASHOP"){
            $text= 'Contamos con modulos para Banco Nacional, Credix y Bac San José';
            $data = [
                'chat_id' => $chat_id,
                'text'    => $text,
            ];
            return Request::sendMessage($data);
        }else{
            return 'Para obtener información mas especifica: '. $this->getUsage();
        }

}
}