<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'python_rag' => [
        'base_url' => env('PYTHON_RAG_BASE_URL', 'http://localhost:8000'),
        'timeout' => env('PYTHON_RAG_TIMEOUT', 30),
    ],

    'chat_widget' => [
        'enabled' => env('CHAT_WIDGET_ENABLED', false),
        'webhook_url' => env('CHAT_WIDGET_WEBHOOK_URL', 'https://n8n.setz.de/webhook/8245fc59-b868-48d7-883d-1ca58334958d/chat'),
        'webhook_route' => env('CHAT_WIDGET_WEBHOOK_ROUTE', 'general'),
        'script_url' => env('CHAT_WIDGET_SCRIPT_URL', 'js/chat-widget.js'),
        'branding' => [
            'logo' => env('CHAT_WIDGET_LOGO', 'https://setz.de/img/logo_transl.gif'),
            'name' => env('CHAT_WIDGET_NAME', 'EDV Integration Dr. Setz'),
            'welcome_text' => env('CHAT_WIDGET_WELCOME_TEXT', '<br>'),
            'response_time_text' => env('CHAT_WIDGET_RESPONSE_TEXT', 'Setz AI Chat'),
        ],
        'style' => [
            'primary_color' => env('CHAT_WIDGET_PRIMARY_COLOR', '#dbd21f'),
            'secondary_color' => env('CHAT_WIDGET_SECONDARY_COLOR', '#5fd43f'),
            'position' => env('CHAT_WIDGET_POSITION', 'right'),
            'background_color' => env('CHAT_WIDGET_BG_COLOR', '#ffffff'),
            'font_color' => env('CHAT_WIDGET_FONT_COLOR', '#333333'),
        ],
    ],

];
