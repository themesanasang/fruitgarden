<?php
namespace App\_helpers;

class DataOther
{

    /**
     * url images
     */
    public static function getURL()
    {
        return "localhost:8080/fruitgarden/";
    }




    /**
     * ลบ folder รูป
     */
    public static function delete_directory($dirname) {
        if (is_dir($dirname))
            $dir_handle = opendir($dirname);
        if (!$dir_handle)
            return false;
        while($file = readdir($dir_handle)) {
            if ($file != "." && $file != "..") {
                if (!is_dir($dirname."/".$file))
                        unlink($dirname."/".$file);
                else
                        delete_directory($dirname.'/'.$file);
            }
        }
        closedir($dir_handle);
        rmdir($dirname);
        return true;
    }
    
    

    /**
     * slug thai
     */
    public static function slugify($text)
    {
        // replace non letter or digits by -
        $text = preg_replace('~[^\\pL\d้ำัไใาะี๊ๆฯ็้๋่ิ์ุืูึๅเื]+~u', '-', $text);
        // trim
        $text = trim(rand(1000, 99999).self::mockRandChar().'-'.$text, '-');
        // transliterate
        $text = iconv('utf-8', 'utf-8', $text);
        // lowercase
        $text = strtolower($text);
        // remove unwanted characters
        //$text = preg_replace('~[^-\w]+~', '', $text);
        if (empty($text))
        {
            return 'n-a';
        }

        return $text;
    }

    private static function mockRandChar() { 
        $t = "abcdefghijklmnopqrstuvwxyz"; #letters only
        $idx = rand(0, strlen($t)-1); 
        return substr($t, $idx, 2); 
    }


}

?>