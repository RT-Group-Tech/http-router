<?php
namespace Rtgroup\HttpRouter;

use Exception;

class HttpRouter
{
    private HttpRequest $httpRequest;
    private $urlFound=false;

    public function __construct()
    {

        $this->httpRequest=new HttpRequest();
    }

    /**
     * Method pour listen les https requetes
     * @param $url => url à capturer.
     * @param Controller $handler => Le controller à éxécuter
     * @return $this
     */
    public function listening(array $url, Controller $controller)
    {
        if(in_array($this->httpRequest->getUrl(),$url))
        {
            $this->urlFound=true;
            $controller->captured($this->httpRequest->getUrl(),$this->httpRequest);
        }
        return $this;
    }

    public function close()
    {
        $this->urlNotFound();
    }

    private function urlNotFound()
    {
        if(!$this->urlFound)
        {
            throw new UrlNotFound("Url not found",404);
        }
    }
}