<?php

namespace Rtgroup\HttpRouter;

abstract class Controller
{
    use DataLoader;

    public abstract function captured($url, HttpRequest $httpRequest, array $params=null);

}