<?php
namespace Rtgroup\HttpRouter;

final class HttpCleaner
{
    public static function clean($data)
    {
        if(is_array($data))
        {
            foreach($data as $key=>$val)
            {
                if(is_string($val))
                {
                    $data[$key]=filter_var($data[$key],  FILTER_SANITIZE_STRING);
                    $data[$key]=htmlspecialchars($data[$key]);
                    $data[$key]=stripslashes($data[$key]);
                    $data[$key]=trim($data[$key]);
                }
            }
        }
        else
        {
            $data=filter_var($data,  FILTER_SANITIZE_STRING);
            $data=htmlspecialchars($data);
            $data=stripslashes($data);
            $data=trim($data);
        }
        return $data ; //DONNEE FILTREE
    }
}