<?php

namespace Rtgroup\HttpRouter;

abstract class Controller
{
    private array $headers=array(
        "Content-Type"=>"application/json"
    );

    public abstract function captured($url, HttpRequest $httpRequest);

    /**
     * Reponse http, retourne les données en format json.
     * @param $key
     * @param $data
     * @return void
     */
    protected function loadData($key, $data)
    {
        $dataResponse[$key]=$data;

        /**
         * Send response headers.
         */
        foreach($this->headers as $key=>$val)
        {
            header($key.":".$val);
        }

        $jsonResponse=json_encode($dataResponse);

        /**
         * Output http response.
         */
        echo $jsonResponse;
    }

    /**
     * Specifier un header pour la reponse http
     * @param $key
     * @param $value
     * @return void
     */
    protected function setResponseHeader($key,$value)
    {
        $this->headers[$key]=$value;
    }
}