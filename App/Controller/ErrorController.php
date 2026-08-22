<?php

declare(strict_types=1);

namespace App\Controller;

use Core\DefaultController;

class ErrorController extends DefaultController
{
    public function index(): string
    {
        return $this->render('errors404');
    }
}