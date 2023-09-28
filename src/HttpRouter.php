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
    public function listening(array $urls, Controller $controller)
    {
        if(in_array($this->httpRequest->getUrl(),$urls))
        {
            $this->urlFound=true;
            $controller->captured(url: $this->httpRequest->getUrl(),httpRequest: $this->httpRequest,params: $this->httpRequest->getParams());
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