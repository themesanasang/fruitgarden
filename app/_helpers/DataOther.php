<?php
namespace App\_helpers;
use DB;
use Exception;

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



    /**
     * random color
     */
    public static function random_color(){
        $array = array("#1abc9c", "#3498db", "#34495e", "#f1c40f", "#e67e22", "#e74c3c", "#95a5a6", "#273c75", "#487eb0", "#b71540");
        $output = array_rand( $array , 1 );

        return $array[$output];
    }



    /**
     * ดึงข้อมูลติดต่อ facebook ของ web
     */
    public static function getContactFacebook()
    {
        try{
            $app_config = DB::table('f_contact')->select('facebook')->first(); 
            return (($app_config->facebook == '' || $app_config->facebook == '-')?'#':'http://'.$app_config->facebook);
        }catch(\Exception $e){
            return '-';
        }
    }




    /**
     * ดึงข้อมูลติดต่อ instagram ของ web
     */
    public static function getContactInstagram()
    {
        try{
            $app_config = DB::table('f_contact')->select('instagram')->first(); 
            return (($app_config->instagram == '' || $app_config->instagram == '-')?'#':'http://'.$app_config->instagram);
        }catch(\Exception $e){
            return '-';
        }
    }



    /**
     * ดึงข้อมูลติดต่อ instagram ของ web
     */
    public static function getContactTwitter()
    {
        try{
            $app_config = DB::table('f_contact')->select('twitter')->first(); 
            return (($app_config->twitter == '' || $app_config->twitter == '-')?'#':'http://'.$app_config->twitter);
        }catch(\Exception $e){
            return '-';
        }
    }


    /**
     * ดึงข้อมูลติดต่อ about ของ web
     */
    public static function getContactAbout()
    {
        try{
            $app_config = DB::table('f_contact')->select('about')->first(); 
            return $app_config->about;
        }catch(\Exception $e){
            return '-';
        }
    }



     /**
     * ดึงข้อมูลติดต่อ address ของ web
     */
    public static function getContactAddress()
    {
        try{
            $app_config = DB::table('f_contact')->select('address')->first(); 
            return $app_config->address;
        }catch(\Exception $e){
            return '-';
        }
    }



     /**
     * ดึงข้อมูลติดต่อ phone ของ web
     */
    public static function getContactPhone()
    {
        try{
            $app_config = DB::table('f_contact')->select('phone')->first(); 
            return $app_config->phone;
        }catch(\Exception $e){
            return '-';
        }
    }


}

?>