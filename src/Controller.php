<?php

namespace Rtgroup\HttpRouter;

abstract class Controller
{
    use DataLoader;


    /**
     * Avant d'entrer dans le route.
     * @param $url
     * @param HttpRequest $httpRequest
     * @param array|null $params
     * @return mixed
     */
    public abstract function beforeEnter($url, HttpRequest $httpRequest, array $params=null);

    /**
     * Lorsque le URl listened est capturé.
     * @param $url
     * @param HttpRequest $httpRequest
     * @param array|null $params
     * @return mixed
     */
    public abstract function captured($url, HttpRequest $httpRequest, array $params=null);

}