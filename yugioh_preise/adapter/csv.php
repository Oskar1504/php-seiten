<?php

class CSV {
    /*
     * return array with csv file data
     */
    public static function readFile($path){
        $string = file_get_contents($path);
        $rows  = explode("\n",$string);
        foreach ($rows as $row ){
            $data [] = explode(",",$row);
        }
        return $data;
    }
}