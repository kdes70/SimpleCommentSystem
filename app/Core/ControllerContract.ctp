<?php

namespace App\Core;

use App\Core\Request\RequestForm;

interface ControllerContract
{
    public function index();

    public function create(RequestForm $requestForm);
}
