<?php

declare(strict_types=1);

return [

    'merge' => [
        'single' => [
            'label' => 'Merge',
            'modal' => [
                'heading' => 'Merge :label',
                'actions' => [
                    'merge' => [
                        'label' => 'Merge',
                    ],
                ],
            ],

            'notifications' => [
                'merged' => [
                    'title' => 'Merged',
                ],
            ],
        ],

        'multiple' => [
            'label' => 'Merge selected',
            'modal' => [
                'heading' => 'Merge selected :label',
                'actions' => [
                    'merge' => [
                        'label' => 'Merge',
                    ],
                ],
            ],

            'notifications' => [
                'merged' => [
                    'title' => 'Merged',
                ],
            ],
        ],
    ],

];
