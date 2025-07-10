<?php
declare(strict_types=1);

/**
 * HashID is a class that encodes and decodes numbers to and from hashes.
 * It uses a base 36 character set and a lookup table to speed up the encoding and decoding process.
 * It is case insensitive and ignores non-base 36 characters.
 * It is thread safe and can be used in a multi-threaded environment.
 * It is also very fast and can encode and decode numbers very quickly.
 * 
 * @example:
 * 
 * $hash = HashID::encode(1234567890);
 * echo $hash; // Outputs: "kf12oi"
 * 
 * $number = HashID::decode($hash);
 * echo $number; // Outputs: 1234567890
 * 
 * @author: @halityesil
 * @version: 1.0.0
 * @since: 2025-07-10
 * @package: App\Utils\Helpers
 * @category: Helpers
 * @subcategory: HashID
 * @link: https://github.com/halityesil/hashid
 * @license: MIT
 */
class HashID
{

    private const BASE_CHARS = '0123456789abcdefghijklmnopqrstuvwxyz';
    private static $lookup = null;
    private static $base_length = null;

    /**
     * Encode a number to a hash
     * @param int $number
     * @return string
     */
    public static function encode(int $number): string
    {
        if ($number < 0) {
            throw new \InvalidArgumentException("Negative numbers are not supported");
        }

        self::init(false);
                
        $result = '';
        while ($number > 0) {
            $result = self::BASE_CHARS[$number % self::$base_length] . $result;
            $number = (int)($number / self::$base_length);
        }
        if(empty($result)){
            $result = self::BASE_CHARS[0];
        }
        return $result;
    }

    /**
     * Decode a hash to a number
     * @param string $hash
     * @param bool $insensitive
     * @return int
     */
    public static function decode(string $hash, bool $insensitive = true): int
    {
        self::init(true);

        if($insensitive){
            $hash = strtolower($hash);
        }

        $hash = preg_replace('/[^'.preg_quote(self::BASE_CHARS).']/', '', $hash);

        if(empty($hash)){
            return 0;
        }
        $result = 0;
        for ($i = 0; $i < strlen($hash); $i++) {
            $result = $result * self::$base_length + self::$lookup[$hash[$i]];
        }
        return $result;
    }

    /**
     * Initialize the lookup table and base length
     * @return void
     */
    private static function init(bool $init_lookup = false): void
    {
        if ($init_lookup && self::$lookup === null) {
            self::$lookup = array_flip(str_split(self::BASE_CHARS));
        }

        if(self::$base_length === null){
            self::$base_length = strlen(self::BASE_CHARS);
        }   
    }
}