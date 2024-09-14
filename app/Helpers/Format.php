<?php

// if (!function_exists('formatstring')) {
//     function formatstring($string)
//     {
//         return \Carbon\Carbon::parse($date)->format('d/m/Y');
//     }
// }
namespace App\Helpers;
// Thêm các helper functions khác nếu cần
    class Format{
        public static function textShorten($text, $limit = 50){
            $text = $text. " ";
            if(strlen($text)< $limit)
                { 
                    return $text;
                }
            else{
                $text = substr($text, 0, $limit);
                $text = substr($text, 0, strrpos($text, ' '));
                $text = $text."...";
            }
           
            return $text;
        }
        public static function format_currency($n=0){
            $n=(string)$n;
            $n=strrev($n);
            $res='';
            for($i=0;$i<strlen($n);$i++){
                if($i%3==0 && $i!=0){
                    $res.='.';
                }
                $res.=$n[$i];
            }
            $res = strrev($res);
            return $res;
        }
    }