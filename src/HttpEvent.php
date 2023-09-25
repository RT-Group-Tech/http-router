<?php

namespace Rtgroup\HttpRouter;

abstract class HttpEvent
{
    public abstract function capture($url);
}