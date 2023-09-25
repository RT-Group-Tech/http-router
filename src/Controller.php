<?php

namespace Rtgroup\HttpRouter;

abstract class Controller
{
    public abstract function captured($url, HttpRequest $httpRequest);
}