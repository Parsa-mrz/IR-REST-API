<?php
namespace App\Utilities;
use \App\Utilities\Response;

class CacheUtility
{
    protected static $cache_file;
    protected static $cache_enabled = 1;
    const EXPIRE_TIME = 3600;   // 1 hour

    public static function init()
    {
        self::$cache_file = CACHE_DIR . md5($_SERVER['REQUEST_URI']) . ".json";
        if ($_SERVER['REQUEST_METHOD'] != 'GET')
            self::$cache_enabled = 0;
    }

    public static function cache_exits(){
        return (file_exists(self::$cache_file) && (time() - self::EXPIRE_TIME) < filemtime(self::$cache_file));
    }
    public static function start()
    {
        self::init();
        if (!self::$cache_enabled)
            return;
        if (self::cache_exits()) {
            Response::setHeaders(Response::HTTP_OK);
            readfile(self::$cache_file);
            // echo "<!-- Cached copy, generated ".date('H:i', filemtime(self::$cache_file))."-->\n";
            exit;
        }
        ob_start();
    }

    public static function end()
    {
        if (!self::$cache_enabled)
            return;
        # Cache the contents to a cache file
        $cachedfile = fopen(self::$cache_file, 'w');
        fwrite($cachedfile, ob_get_contents());
        fclose($cachedfile);
        // alternative solution: file_put_contents(self::$cache_file,ob_get_contents());
        # Send the output to the browser
        ob_end_flush();
    }

    public static function flush()
    {
        $files = glob(CACHE_DIR . "*");             // get all file names
        foreach ($files as $file)                   // iterate files
            if (is_file($file))
                unlink($file);
    }
}
