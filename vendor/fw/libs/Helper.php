<?php
namespace fw\libs;

class Helper
{
    /** Dumps a value for debugging
     * @param $data
     * @param bool $die
     * @param bool $type true = var_dump, false = print_r
     * @return void
     */
    public static function dump($data, $die = false, $type = false){
        echo "<pre>"; if(!$type) var_dump($data); else print_r($data);
        echo "</pre>"; if($die) die();
    }

    /** Sends no-cache headers
     * @return void
     */
    public static function noCache(){
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: no-cache, must-revalidate');
        header('Cache-Control: post-check=0,pre-check=0', false);
        header('Cache-Control: max-age=0', false);
        header('Pragma: no-cache');
    }

    /** Redirect helper for form submissions
     * @param string $url exact target (optional)
     * @return void
     */
    public static function redirect($url = false){
        if($url) $redirect = $url;
        // fall back to the referrer, or the home page
        else $redirect = isset($_SERVER["HTTP_REFERER"]) ? $_SERVER['HTTP_REFERER'] : '/';
        header("Location: $redirect");
        exit;
    }

    // redirects to the login page if the user isn't authenticated
    public static function needAuth(){
        if ($_SERVER['REQUEST_URI'] !== '/user/personal') {
            if (!isset($_SESSION['user'])) {
                self::redirect('/user/personal');
            }
        }
    }

    /** Appends a message to a log file
     * @param $msg
     * @param string $fileName
     * @param string $source
     * @param string $path
     * @return void
     */
    public static function WriteLog($msg, string $fileName, $source = '', $path = ''){
        try {
            if (!trim($fileName))
                throw new \Exception('file name is empty ' . __METHOD__);
            if (empty($msg))
                throw new \Exception('msg is empty ' . __METHOD__);
            if (!$path)
                $path = $_SERVER['DOCUMENT_ROOT'] . 'logs';
            if (is_array($msg)) {
                $msg = print_r($msg, true);
                file_put_contents($path . '/' . $fileName, $msg, FILE_APPEND);
            } else {
                $msg = "\n" . date('d-m-Y:(H-i-s)') . ': ' . $msg . ' ' . $source;
                file_put_contents($path . '/' . $fileName, $msg, FILE_APPEND);
            }
        } catch (\Exception $e) {
            die($e->getMessage());
        }
    }

    /** Copies array keys onto a bean as properties
     * @param object $bean
     * @param array $arr associative array
     * @return object the populated bean
     */
    public static function array2Bean($bean, $arr = []):object{
        if(!empty($arr) && is_object($bean)){
            foreach($arr as $key => $val){
                if(is_string($key))
                    $bean->$key = strip_tags(trim($val));
            }
        }
        return $bean;
    }


    /** Wraps matching words in <b> tags via str_replace
     * @param string $text
     * @param array $words
     * @return string
     */
    public static function TextHighlightWords(string $text, array $words): string
    {
        $text = strtolower($text);
        $str = '';
        foreach ($words as $word) {
            if ($str !== '')
                $str = str_replace($word, "<b>$word</b>", $str);
            else
                $str = str_replace($word, "<b>$word</b>", $text);
        }
        return $str;
    }

    /** Highlights words in text, also matching common endings (ing, ed, ly, s)
     * @param string $text
     * @param array $needle
     * @return string
     */
    public static function NeedleHighlight(string $text, array $needle): string{
        $arr = self::splitText($text);
        $string = '';
        foreach ($arr as $word) {
            if (in_array($word, $needle) || in_array(rtrim($word, 'ing'), $needle) || in_array(rtrim($word, 'ed'), $needle) || in_array(rtrim($word, 's'), $needle) || in_array(rtrim($word, 'ly'), $needle))
                $string .= ' ' . "<b>$word</b>"; else $string .= ' ' . $word;
        }
        return $string;
    }

    public static function NeedleHighlightOne(string $text, $needle): string{
        $arr = self::splitText($text);
        $string = '';
        foreach ($arr as $word) {
            if ($word == $needle || rtrim($word, 'ing') == $needle || rtrim($word, 'ed') == $needle ||
            rtrim($word, 's') == $needle || rtrim($word, 'ly') == $needle)
                $string .= ' ' . "<b>$word</b>"; else $string .= ' ' . $word;
        }
        return $string;
    }


    /** Splits text into an array of normalized words
     * @param string $data
     * @return array
     */
    public static function splitText(string $data):array{
        // split on whitespace/commas and drop trailing punctuation
        $arr_words = preg_split('/[\s,]+/', rtrim($data, ',.!?'));
        foreach ($arr_words as $key => $word) {
            $arr_words[$key] = strtolower(trim($word, ',.!?'));
        }
        return $arr_words;
    }


    /** Strips tags/whitespace from form input before it's stored
     * @param $data
     * @return string
     */
    public static function clearData($data): string
    {
        $data = strip_tags(trim($data));
        return str_replace('+', '', $data);
    }

    /** Whether the current request is an AJAX request
     * @return bool
     */
    public static function isAjax():bool{
        if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower
            ($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
            return true;
        }
        return false;
    }

    /** Strips the query string and trailing slash off a URL
     * @param $url
     * @return string
     */
    public static function getCleanUrl($url){
        $string = explode('?', $url);
        return rtrim($string[0], '/');
    }

    /** The current logged-in user's id, or false
     * @return false|mixed
     */
    public static function getUserID(){
        if(isset($_SESSION['user']))
            return $_SESSION['user']['id'];
        return false;
    }

    /** Whether the current user has the admin role
     * @return bool
     */
    public static function isAdmin(){
        if(isset($_SESSION['user']) && $_SESSION['user']['role'] == "admin")
            return true;
        return false;
    }

    /** What percentage $percentage is of $totalCount
     * @param $totalCount the total to compute a percentage of
     * @param $percentage the value to express as a percentage
     * @return float|int
     */
    public static function getPercent($totalCount, $percentage){
        if($totalCount == 0 || $percentage == 0)
            return 0;
        return round($percentage * (100 / $totalCount), 1);
    }

    /** Pulls a single key out of each element of an array of arrays
     * @param $arr
     * @param $key
     * @return array
     */
    public static function sepatateArrayByKey($arr, $key): array{
        if(!is_array($arr) || !count($arr) || !is_string($key)) return [];
        $tmp = [];
        foreach ($arr as $item){
            foreach ($item as $k => $v){
                if($k === $key) $tmp[] = $v;
            }
        }
        return $tmp;
    }


}
