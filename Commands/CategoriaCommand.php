<?php


namespace Longman\TelegramBot\Commands\AdminCommands;

use Longman\TelegramBot\Commands\UserCommand;
use Longman\TelegramBot\Entities\InlineKeyboard;
use Longman\TelegramBot\Entities\InlineKeyboardButton;
use Longman\TelegramBot\Request;
use Longman\TelegramBot\Entities\ServerResponse;


class CategoriaCommand extends UserCommand
{
    protected $name = 'categoria';
    protected $description = 'Choose a category, inline.';
    protected $usage = '/categoria';
    protected $version = '1.0.0';

    /** @var array Inline button categories (can also be dynamically generated) */
    public static $categories = [
        'apple'  => 'Yay, an apple!',
        'orange' => 'Sweetness...',
        'cherry' => 'A cherry on top.',
    ];

    public function execute(): ServerResponse
    {
        $keyboard_buttons = [];
        foreach (self::$categories as $key => $value) {
            $keyboard_buttons[] = new InlineKeyboardButton([
                'text'          => ucfirst($key),
                'callback_data' => 'category_' . $key,
            ]);
        }
        $data = [
            'chat_id'      => $this->getMessage()->getChat()->getId(),
            'text'         => 'Choose a category:',
            'reply_markup' => new InlineKeyboard($keyboard_buttons),
        ];

        return Request::sendMessage($data);
    }
}