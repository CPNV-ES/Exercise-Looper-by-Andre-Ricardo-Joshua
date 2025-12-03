<?php

namespace App\Controllers;

class HomeController
{
    /**
     * Handles the logic for the homepage.
     */
    public function index(): array
    {
        return [
            'view' => 'views/home',
            'data' => [
                'title' => 'Exercise Looper'
            ]
        ];
    }
}