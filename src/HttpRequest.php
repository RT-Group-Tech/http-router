<?php

namespace Rtgroup\HttpRouter;


class HttpRequest
{
    private $host;
    private $userAgent;
    private $protocol;
    private $method;
    private $url;

    private $requestData;

    private static $mainDir;
    private static $storeFilename="http-request-store.txt";

    private static $requestObj;

    public function __construct()
    {
        /**
         * Parse request.
         */
        $this->setHost();
        $this->setAgent();
        $this->setMethod();
        $this->setprotocol();
        $this->setUrl();

        /**
         * Http data cleaning.
         */
        $this->requestData=array_merge($_GET,$_POST);
        $this->requestData= HttpCleaner::clean($this->requestData);
    }

    private function setHost()
    {
        $this->host=$_SERVER['HTTP_HOST'];
    }

    private function setAgent()
    {
        $this->userAgent=$_SERVER['HTTP_USER_AGENT'];
    }

    private function setprotocol()
    {
        $this->protocol=(isset($_SERVER['REQUEST_SCHEME']))? $_SERVER['REQUEST_SCHEME']."//" : "http://";
    }

    private function setMethod()
    {
        $this->method=$_SERVER['REQUEST_METHOD'];
    }

    private function setUrl()
    {
        $this->url=$_SERVER['REQUEST_URI'];

        self::$mainDir=dirname($_SERVER['SCRIPT_FILENAME']);
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getprotocol()
    {
        return $this->protocol;
    }

    public function isHttps()
    {
        if(strstr($this->protocol,"https"))
        {
            return true;
        }

        return false;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Method pour vérifier d'une donnée obligatoire parmis les données http de la requete.
     * @param $key
     * @return void
     */
    public static function checkRequiredData($key,$checkLength=false,$minLength=1)
    {
        $request=HttpRequest::getCachedObject();

        if(!isset($request->requestData[$key]))
        {
            throw new \Exception($key." : obligatoire");
        }
        else
        {
            /**
             * Check count.
             */
            if($checkLength)
            {
                if(strlen($request->requestData[$key])<$minLength)
            {
                throw new \Exception($key." : obligatoire");
            }
            }
        }
    }

    public function __destruct()
    {
        /**
         * Cache HttpRequest object in file.
         */
        $this->cacheObject();
    }

    private function cacheObject()
    {
        $data['req_obj']=serialize($this);
        $jsonData=json_encode($data);

        file_put_contents(self::$mainDir.DIRECTORY_SEPARATOR.self::$storeFilename,$jsonData);
    }

    /**
     * Recuperer l'objet en cache.
     * @return mixed
     */
    private static function getCachedObject()
    {
        $content=file_get_contents(self::$mainDir.DIRECTORY_SEPARATOR.self::$storeFilename);

        /**
         * Decode json content.
         */
        $content=json_decode($content);

        /**
         * Get cached HttpRequest obj.
         */
        self::$requestObj=unserialize($content->req_obj);

        return self::$requestObj;
    }

    /**
     * Recuperer les données GET & POST de la requete.
     * @return array|mixed|string
     */
    public function getData()
    {
        return $this->requestData;
    }
}