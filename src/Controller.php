<?php

namespace Rtgroup\HttpRouter;

abstract class Controller
{
    use DataLoader; /** trait pour gerer le chargement des données en reponde http format json. */

    public abstract function captured($url, HttpRequest $httpRequest);

}