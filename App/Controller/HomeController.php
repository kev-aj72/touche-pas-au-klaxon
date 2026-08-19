<?php

declare(strict_types=1);

namespace App\Controller;

class HomeController
{
    public function index(): string
    {
        ob_start();
        require dirname(__DIR__) . '/Templates/home.php';
        return (string) ob_get_clean();
    }
}
?>