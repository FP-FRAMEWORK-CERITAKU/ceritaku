<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\ViewErrorBag;
use Illuminate\Support\MessageBag;

class Helper
{
    /*
     * Add an error to Laravel session $errors
     * @author Pavel Lint
     * @param string $key
     * @param string $error_msg
     */
    public static function addError($error_msg, $key = 'default') {
        $errors = Session::get('errors', new ViewErrorBag);

        if (! $errors instanceof ViewErrorBag) {
            $errors = new ViewErrorBag;
        }

        $bag = $errors->getBags()['default'] ?? new MessageBag;
        $bag->add($key, $error_msg);

        Session::flash(
            'errors', $errors->put('default', $bag)
        );
    }

    /**
     * @param float|string $price
     * @param string $as
     * @return string|null
     */
    public static function formatPrice($price, $as = 'rupiah', $from = null) {
        if(
            $price === null
            || (!is_numeric($price) && empty($price))
        ) {
            return '0';
        }

        $as = $as ?? 'rupiah';

        if(
            $from == 'excel'
            && $as == 'db'
        ) {
            $price = str_replace(".", "", $price);
            return number_format($price, 2, '', '');
        }

        if($as == 'excel') {
            return number_format($price, 0, '', '.');
        }

        if($as == 'rupiah') {
            return number_format($price, 0, '', '.');
        }

        if($as == 'db') {
            $price = str_replace(".", "", $price);
            return str_replace(",", ".", $price);
        }

        return null;
    }

    /**
     * @param float|string $stock
     * @param string $as
     * @return string|null
     */
    public static function formatStock($stock, $as = 'default') {
        if(
            $stock === null
            || (!is_numeric($stock) && empty($stock))
        ) {
            return '0';
        }

        $as = $as ?? 'default';

        if($as == 'excel') {
            return number_format($stock, 2, '.', ',');
        }

        if($as == 'default') {
            $formatting = number_format($stock, 2, '.', ',');
            return strpos($formatting,'.') !== false ? rtrim(rtrim($formatting,'0'),'.') : $formatting;
        }

        if($as == 'db') {
            $stock = str_replace(",", "", $stock);
            return number_format($stock, 2, '.', '');
        }

        return null;
    }

    /**
     * @param string $string
     * @return bool|null
     */
    public static function stringToBoolean($string) {
        if (is_bool($string)) {
            return $string;
        }

        return filter_var($string, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE);
    }

    /**
     * @param mixed $data
     * @param mixed $then
     * @return mixed
     */
    public static function ifEmptyThen($data, $then = '(not set)') {
        if(is_numeric($data)){
            return $data;
        }

        return empty($data) ? $then : $data;
    }

    /**
     * @param array $data
     * @param string $key
     * @param mixed $then
     * @return mixed
     */
    public static function ifArrayKeyEmptyThen($array, $key, $then = 'No data') {
        if(!is_array($array)){
            return $then;
        }

        return array_key_exists($key, $array) ? $array : $then;
    }

    /**
     * @param string[] $permissions
     * @return string
     */
    public static function buildHasAnyPermission($permissions = []) {
        return 'permission:' . implode('|', $permissions);
    }

    /**
     * @param string[] $roles
     * @return string
     */
    public static function buildHasAnyRole($roles = []) {
        return 'role:' . implode('|', $roles);
    }

    /**
     * @param string $str
     * @param int $padNum
     * @return string
     */
    public static function paddingZeros($str, $padNum = 5, $padStr = '0') {
        if (
            !is_numeric(intval($padNum))
        ) {
            return '';
        }

        $usedLength = strlen($str);
        return str_repeat($padStr, intval($padNum)-$usedLength) . $str;
    }

    /**
     * @param string $string
     * @param int $limit
     * @param string $trimmedText
     * @return string
     */
    public static function trimText($string, $limit = 100, $trimmedText = '...') {
        if (!is_string($string)) {
            return '';
        }

        $in = $string;
        return strlen($in) > $limit ? substr($in,0,$limit) . $trimmedText : $in;
    }

    /**
     * @return array
     */
    public static function getRouteNames()
    {
        $routeCollection = \Route::getRoutes();
        $routeNames = [];
        /* @var $route \Illuminate\Routing\Route */
        foreach ($routeCollection as $route) {
            if (!$route->getName()) {
                continue;
            }

            $routeNames[] = $route->getName();
        }

        return $routeNames;
    }

    public static function getStoragePath($path)
    {
        $storageUrl = Storage::url($path) ?? null;
        return $storageUrl ? asset($storageUrl) : '#';
    }

    public static function formatBytes($bytes, $precision = 2)
    {
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $bytes = max($bytes, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= pow(1024, $pow);
        return round($bytes, $precision) . ' ' . $units[$pow];
    }

    /**
     * Return a UUID (version 4) using random bytes
     * Note that version 4 follows the format:
     *     xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx
     *     35a0d9a7-e0f5-4c88-9cad-2e542d6da02f
     * where y is one of: [8, 9, A, B]
     *
     * We use (random_bytes(1) & 0x0F) | 0x40 to force
     * the first character of hex value to always be 4
     * in the appropriate position.
     *
     * For 4: http://3v4l.org/q2JN9
     * For Y: http://3v4l.org/EsGSU
     * For the whole shebang: https://3v4l.org/LNgJb
     *
     * @ref https://stackoverflow.com/a/31460273/2224584
     * @ref https://paragonie.com/b/JvICXzh_jhLyt4y3
     *
     * @return string
     */
    public static function uuidv4($implodeChar = '-')
    {
        return implode($implodeChar, [
            bin2hex(random_bytes(4)),
            bin2hex(random_bytes(2)),
            bin2hex(chr((ord(random_bytes(1)) & 0x0F) | 0x40)) . bin2hex(random_bytes(1)),
            bin2hex(chr((ord(random_bytes(1)) & 0x3F) | 0x80)) . bin2hex(random_bytes(1)),
            bin2hex(random_bytes(6))
        ]);
    }

    public static function objectToArray($data)
    {
        if (is_array($data) || is_object($data))
        {
            $result = [];
            foreach ($data as $key => $value)
            {
                $result[$key] = (is_array($value) || is_object($value)) ? self::objectToArray($value) : $value;
            }
            return $result;
        }

        return $data;
    }

    public static function enumSearcher($needle, $enum, $ifEmptyThen = null)
    {
        if (empty($needle) || empty($enum)) {
            return $ifEmptyThen;
        }

        if (is_object($enum) && !is_array($enum)) {
            $enum = self::objectToArray($enum);
        }

        // search by key
        if (array_key_exists($needle, $enum)) {
            return $needle;
        }

        // search by value
        $needle = strtolower($needle);
        foreach ($enum as $key => $value) {
            // if value array
            if (is_array($value)) {
                foreach ($value as $subValue) {
                    if (!is_array($subValue) && strtolower($subValue) === $needle) {
                        return $key;
                    }
                }
            }

            if (!is_array($value) && strtolower($value) === $needle) {
                return $key;
            }
        }

        return $ifEmptyThen;
    }

    public static function getEnumValue($needle, $enum, $ifEmptyThen = null)
    {
        $needle = self::enumSearcher($needle, $enum, $ifEmptyThen);
        if (empty($needle)) {
            return $ifEmptyThen;
        }

        if (!array_key_exists($needle, $enum)) {
            return $ifEmptyThen;
        }

        return is_array($enum[$needle])
            ? $enum[$needle][0]
            : $enum[$needle];
    }

    public static function isURLFriendly($string)
    {
        return preg_match('/^[a-z0-9]+(?:-[a-z0-9]+)*$/', $string);
    }

    public static function generateSlug($string, $separator = '-')
    {
        $slug = strtolower(trim(preg_replace('/[^A-Za-z0-9-]+/', $separator, $string), $separator));
        if (self::isURLFriendly($slug)) {
            return $slug;
        }

        return self::uuidv4();
    }

    // function to convert integer to K, M, B, T
    public static function numberKMBT($number)
    {
        $number = (int) $number;
        if ($number < 1000) {
            return $number;
        }
        $suffixes = ['K', 'M', 'B', 'T'];
        $suffixIndex = 0;
        while ($number >= 1000) {
            $suffixIndex++;
            $number /= 1000;
        }
        return round($number, 2) . $suffixes[$suffixIndex];
    }
}
