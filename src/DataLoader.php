<?php
namespace Rtgroup\HttpRouter;

trait DataLoader
{
    private array $headers=array(
        "Content-Type"=>"application/json"
    );

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
        exit(); /** stop the application */
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

?>
