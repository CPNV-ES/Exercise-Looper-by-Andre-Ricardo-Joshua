<?php

namespace App\Controller;

class HomeController
{
    /**
     * Handles the logic for the homepage.
     */
    public function index(): array
    {
        return ['view' => 'view/Home',
                'data' => [
                    'title' => 'Exercise Looper'
                ]
        ];
    }
}