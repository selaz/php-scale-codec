<?php

namespace Codec;


class Utils
{

    /**
     * @param string $str
     * @return array|false
     */
    public static function string2ByteArray($str)
    {
        return unpack('C*', $str);
    }


    /**
     * @param $bytes
     * @return string
     */
    public static function byteArray2String($bytes)
    {
        $chars = array_map("chr", $bytes);
        return join($chars);
    }

    /**
     * @param array $bytes
     * @return string
     */
    public static function bytesToHex($bytes)
    {
        $chars = array_map("chr", $bytes);
        $bin = join($chars);
        return bin2hex($bin);
    }

    /**
     * @param $hex
     * @return array
     */
    public static function hexToBytes($hex)
    {
        $string = hex2bin($hex);
        $value = unpack('C*', $string);
        return is_array($value) ? array_values($value) : [];
    }

    /**
     * @param string $string
     * @return string
     */
    public static function string2Hex(string $string)
    {
        return bin2hex($string);
    }

    /**
     * @param string $hexString
     * @return bool|string
     */
    public static function hex2String(string $hexString)
    {
        return hex2bin($hexString);
    }


    /**
     * @param $hexString string
     * @return string|string[]|null
     */
    public static function trimHex($hexString)
    {
        return preg_replace('/0x[0-9a-fA-F]/', '', $hexString);
    }


    /**
     * BytesToLittleInt
     * @param array $byteArray
     * @return int
     *
     *
     */
    public static function bytesToLittleInt(array $byteArray)
    {
        switch (count($byteArray)) {
            case 1:
                return $byteArray[0];
            case 2: // uint16
                return $byteArray[0] | $byteArray[1] << 8;
            case 4: // uint32
                return $byteArray[0] | $byteArray[1] << 8 | $byteArray[2] << 16 | $byteArray[3] << 24;
            case 8: // uint64
                return $byteArray[0] | $byteArray[1] << 8 | $byteArray[2] << 16 | $byteArray[3] << 24 |
                    $byteArray[4] << 32 | $byteArray[5] << 40 | $byteArray[6] << 48 | $byteArray[7] << 56;
        }
        return 0;
    }

    /**
     * @param int $value
     * @param int $length
     * @return string
     */
    public static function LittleIntToBytes(int $value,int $length){
        switch ($length){
            case 1:
                return self::bytesToHex(array($value));
            case 2:
                return self::bytesToHex(array($value,$value>>8));
            case 3:
                return self::bytesToHex(array($value,$value>>8,$value>>16,$value>>32));
            case 4:
                return self::bytesToHex(array($value,$value>>8,$value>>16,$value>>24));
            case 8:
                return self::bytesToHex(array($value,$value>>8,$value>>16,$value>>24,$value>>32,$value>>40,$value>>48,$value>>56));
            default:
                return new \OutOfRangeException(sprintf('LittleIntToBytes'));
        }
    }
}
