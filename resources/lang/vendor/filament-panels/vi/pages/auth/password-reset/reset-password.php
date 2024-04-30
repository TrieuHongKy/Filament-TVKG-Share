<?php

return [

    'title' => 'Cập nhật mật khẩu',

    'heading' => 'Đặt lại mật khẩu',

    'form' => [

        'email' => [
            'label' => 'Email',
        ],

        'password' => [
            'label' => 'Mật khẩu',
            'validation_attribute' => 'mật khẩu',
        ],

        'password_confirmation' => [
            'label' => 'Xác nhận mật khẩu',
        ],

        'actions' => [

            'reset' => [
                'label' => 'Cập nhật',
            ],

        ],

    ],

    'notifications' => [

        'throttled' => [
            'title' => 'Bạn đã gửi quá nhiều yêu cầu !!!',
            'body' => 'Vui lòng đợi :seconds giây.',
        ],

    ],

];
