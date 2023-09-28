<?php

namespace Rtgroup\HttpRouter;


class HttpRequest
{
    private $host;
    private $userAgent;
    private $protocol;
    private $method;
    private $url;

    private array $params=[];

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
        $_POST=HttpCleaner::clean($_POST);
        $_GET=HttpCleaner::clean($_GET);
        $this->requestData=array_merge($_GET,$_POST);
        $this->requestData= HttpCleaner::clean($this->requestData);

        /**
         * Cache HttpRequest object in file.
         */
        $this->cacheObject();
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

        if($this->host=="127.0.0.1" || $this->host=="localhost")
        {
            /**
             * Remove host from url.
             */
            $u=explode("/",$this->url);

            $cleanedUrl="";
            for($i=0; $i<count($u); $i++)
            {
                if($i<2)
                {
                    continue;
                }
                $cleanedUrl.=$u[$i];

                if($i!=count($u)-1)
                {
                    $cleanedUrl.="/";
                }
            }

            $this->url=$cleanedUrl;
        }
        $urlParts=explode("/",$this->url);

        /**
         * Set params from url.
         */
        if(count($urlParts)>2)
        {
            /**
             * Separate params & Rebuild url.
             */
            $this->url=$urlParts[0]."/".$urlParts[1];

            /**
             * Params.
             */
            $this->params=array_slice($urlParts,2);

        }

        self::$mainDir=dirname($_SERVER['SCRIPT_FILENAME']);
    }

    /**
     * Recuperer les parametres dans l'url.
     * @return array
     */
    public function getParams()
    {
        return $this->params;
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

    public static function isPost()
    {
        $obj=self::getCachedObject();
        if($obj->method=="POST")
        {
            return true;
        }

        return false;

    }

    public static function isGet()
    {
        $obj=self::getCachedObject();
        if($obj->method=="GET")
        {
            return true;
        }

        return false;
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
        //$this->cacheObject();
    }

    private function cacheObject()
    {
        $data['req_obj']=serialize($this);
        $jsonData=json_encode($data);

        $dataFile=self::$mainDir.DIRECTORY_SEPARATOR.self::$storeFilename;
        //file_put_contents($dataFile,$jsonData);
        $f=fopen($dataFile,'w');
        fwrite($f,$jsonData);
        fclose($f);
    }

    /**
     * Recuperer l'objet en cache.
     * @return mixed
     */
    public static function getCachedObject()
    {
        $dataFile=self::$mainDir.DIRECTORY_SEPARATOR.self::$storeFilename;
        if(!file_exists($dataFile))
        {
            return null;
        }
        $content=file_get_contents($dataFile);

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

    /**
     * Method pour éxécuter une requete POST http.
     * @param $url => url de la requete.
     * @param $data => POST data.
     * @return false|string|null
     */
    public function executeRequest($url,$data)
    {

        $curl=new \Curl\Curl();
        $curl->setHeader("Content-Type","application/json");

        $curl->setOpt(CURLOPT_SSL_VERIFYPEER, 0);
        $curl->setOpt(CURLOPT_SSL_VERIFYHOST, 0);

        $curl->setOpt(CURLOPT_FOLLOWLOCATION,true);
        $curl->setOpt(CURLOPT_RETURNTRANSFER,true);

        $res=$curl->post($url, $data);

        if($curl->error)
        {
            return null;
        }
        else
        {
            $obj=$curl->response;

            return $obj;
        }

    }
}