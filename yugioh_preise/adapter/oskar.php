<?php

class OSKAR {
    /*
     * return array with csv file data
     */
    public static function readFile($path){
        $string = file_get_contents($path);
        $rows  = explode("||",$string);
        foreach ($rows as $row ){
            $data [] = explode("|",$row);
        }
        return $data;
    }
}