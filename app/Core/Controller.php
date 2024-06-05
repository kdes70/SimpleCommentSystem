<?php

namespace App\Core;

use App\Core\Request\Request;

class Controller
{
    public function __construct(protected Request $request)
    {
    }
}
