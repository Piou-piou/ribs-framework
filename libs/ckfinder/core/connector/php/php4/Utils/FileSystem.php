<?php
/*
* CKFinder
* ========
* http://ckfinder.com
* Copyright (C) 2007-2010, CKSource - Frederico Knabben. All rights reserved.
*
* The software, this file and its contents are subject to the CKFinder
* License. Please read the license.txt file before using, installing, copying,
* modifying or distribute this file or part of its contents. The contents of
* this file is part of the Source Code of CKFinder.
*/
if (!defined('IN_CKFINDER')) exit;

/**
 * @package CKFinder
 * @subpackage Utils
 * @copyright CKSource - Frederico Knabben
 */

/**
 * @package CKFinder
 * @subpackage Utils
 * @copyright CKSource - Frederico Knabben
 */
class CKFinder_Connector_Utils_FileSystem
{

    /**
     * This function behaves similar to System.IO.Path.Combine in C#, the only diffrenece is that it also accepts null values and treat them as empty string
     *
     * @static
     * @access public
     * @param string $path1 first path
     * @param string $path2 scecond path
     * @return string
     */
    function combinePaths($path1, $path2)
    {
        if (is_null($path1))  {
            $path1 = "";
        }
        if (is_null($path2))  {
            $path2 = "";
        }
        if (!strlen($path2)) {
            if (strlen($path1)) {
                $_lastCharP1 = substr($path1, -1, 1);
                if ($_lastCharP1 != "/" && $_lastCharP1 != "\\") {
                    $path1 .= DIRECTORY_SEPARATOR;
                }
            }
        }
        else {
            $_firstCharP2 = substr($path2, 0, 1);
            if (strlen($path1)) {
                if (strpos($path2, $path1)===0) {
                    return $path2;
                }
                $_lastCharP1 = substr($path1, -1, 1);
                if ($_lastCharP1 != "/" && $_lastCharP1 != "\\" && $_firstCharP2 != "/" && $_firstCharP2 != "\\") {
                    $path1 .= DIRECTORY_SEPARATOR;
                }
            }
            else {
                return $path2;
            }
        }
        return $path1 . $path2;
    }

    /**
     * Check whether $fileName is a valid file name, return true on success
     *
     * @static
     * @access public
     * @param string $fileName
     * @return boolean
     */
    function checkFileName($fileName)
    {
        if (is_null($fileName) || !strlen($fileName) || substr($fileName,-1,1)=="." || false!==strpos($fileName, "..")) {
            return false;
        }

        if (preg_match(CKFINDER_REGEX_INVALID_FILE, $fileName)) {
            return false;
        }

        return true;
    }

    /**
     * Unlink file/folder
     *
     * @static
     * @access public
     * @param string $path
     * @return boolean
     */
    function unlink($path)
    {
        /*    make sure the path exists    */
        if(!file_exists($path)) {
            return false;
        }

        /*    If it is a file or link, just delete it    */
        if(is_file($path) || is_link($path)) {
            return @unlink($path);
        }

        /*    Scan the dir and recursively unlink    */
        $files = CKFinder_Connector_Utils_FileSystem::php4_scandir($path);
        if ($files) {
            foreach($files as $filename)
            {
                if ($filename == '.' || $filename == '..') {
                    continue;
                }
                $file = str_replace('//','/',$path.'/'.$filename);
                CKFinder_Connector_Utils_FileSystem::unlink($file);
            }
        }

        /*    Remove the parent dir    */
        if(!@rmdir($path)) {
            return false;
        }

        return true;
    }

    /**
     * PHP4 Scandir
     * @static
     * @access public
     * @param $directory directory name
    */
    function php4_scandir($directory)
    {
        if (!is_dir($directory) || (false === $fh = @opendir($directory))) {
            return false;
        }

        $files = array ();
        while (false !== ($filename = readdir($fh))) {
            $files[] = $filename;
        }

        closedir($fh);

        return $files;
    }

    /**
     * Return file name without extension (without dot & last part after dot)
     *
     * @static
     * @access public
     * @param string $fileName
     * @return string
     */
    function getFileNameWithoutExtension($fileName)
    {
        $dotPos = strrpos( $fileName, '.' );
        if (false === $dotPos) {
            return $fileName;
        }

        return substr($fileName, 0, $dotPos);
    }

    /**
     * Get file extension (only last part - e.g. extension of file.foo.bar.jpg = jpg)
     *
     * @static
     * @access public
     * @param string $fileName
     * @return string
     */
    function getExtension( $fileName )
    {
        $dotPos = strrpos( $fileName, '.' );
        if (false === $dotPos) {
            return "";
        }

        return substr( $fileName, strrpos( $fileName, '.' ) +1 ) ;
    }

    /**
	 * Read file, split it into small chunks and send it to the browser
	 *
     * @static
     * @access public
	 * @param string $filename
	 * @return boolean
	 */
    function readfileChunked($filename)
    {
        $chunksize = 1024 * 10; // how many bytes per chunk

        $handle = fopen($filename, 'rb');
        if ($handle === false) {
            return false;
        }
        while (!feof($handle)) {
            echo fread($handle, $chunksize);
            @ob_flush();
            flush();
            @set_time_limit(8);
        }
        fclose($handle);
        return true;
    }

    /**
    * Replace accented UTF-8 characters by unaccented ASCII-7 "equivalents".
    * The purpose of this function is to replace characters commonly found in Latin
    * alphabets with something more or less equivalent from the ASCII range. This can
    * be useful for converting a UTF-8 to something ready for a filename, for example.
    * Following the use of this function, you would probably also pass the string
    * through utf8_strip_non_ascii to clean out any other non-ASCII chars
    *
    * For a more complete implementation of transliteration, see the utf8_to_ascii package
    * available from the phputf8 project downloads:
    * http://prdownloads.sourceforge.net/phputf8
    *
    * @param string UTF-8 string
    * @param string UTF-8 with accented characters replaced by ASCII chars
    * @return string accented chars replaced with ascii equivalents
    * @author Andreas Gohr <andi@splitbrain.org>
    * @see http://sourceforge.net/projects/phputf8/
    */
    function convertToAscii($str)
    {
        static $UTF8_LOWER_ACCENTS = NULL;
        static $UTF8_UPPER_ACCENTS = NULL;

        if ( is_null($UTF8_LOWER_ACCENTS) ) {
            $UTF8_LOWER_ACCENTS = array(
  'à' => 'a', 'ô' => 'o', 'ď' => 'd', 'ḟ' => 'f', 'ë' => 'e', 'š' => 's', 'ơ' => 'o',
  'ß' => 'ss', 'ă' => 'a', 'ř' => 'r', 'ț' => 't', 'ň' => 'n', 'ā' => 'a', 'ķ' => 'k',
  'ŝ' => 's', 'ỳ' => 'y', 'ņ' => 'n', 'ĺ' => 'l', 'ħ' => 'h', 'ṗ' => 'p', 'ó' => 'o',
  'ú' => 'u', 'ě' => 'e', 'é' => 'e', 'ç' => 'c', 'ẁ' => 'w', 'ċ' => 'c', 'õ' => 'o',
  'ṡ' => 's', 'ø' => 'o', 'ģ' => 'g', 'ŧ' => 't', 'ș' => 's', 'ė' => 'e', 'ĉ' => 'c',
  'ś' => 's', 'î' => 'i', 'ű' => 'u', 'ć' => 'c', 'ę' => 'e', 'ŵ' => 'w', 'ṫ' => 't',
  'ū' => 'u', 'č' => 'c', 'ö' => 'oe', 'è' => 'e', 'ŷ' => 'y', 'ą' => 'a', 'ł' => 'l',
  'ų' => 'u', 'ů' => 'u', 'ş' => 's', 'ğ' => 'g', 'ļ' => 'l', 'ƒ' => 'f', 'ž' => 'z',
  'ẃ' => 'w', 'ḃ' => 'b', 'å' => 'a', 'ì' => 'i', 'ï' => 'i', 'ḋ' => 'd', 'ť' => 't',
  'ŗ' => 'r', 'ä' => 'ae', 'í' => 'i', 'ŕ' => 'r', 'ê' => 'e', 'ü' => 'ue', 'ò' => 'o',
  'ē' => 'e', 'ñ' => 'n', 'ń' => 'n', 'ĥ' => 'h', 'ĝ' => 'g', 'đ' => 'd', 'ĵ' => 'j',
  'ÿ' => 'y', 'ũ' => 'u', 'ŭ' => 'u', 'ư' => 'u', 'ţ' => 't', 'ý' => 'y', 'ő' => 'o',
  'â' => 'a', 'ľ' => 'l', 'ẅ' => 'w', 'ż' => 'z', 'ī' => 'i', 'ã' => 'a', 'ġ' => 'g',
  'ṁ' => 'm', 'ō' => 'o', 'ĩ' => 'i', 'ù' => 'u', 'į' => 'i', 'ź' => 'z', 'á' => 'a',
  'û' => 'u', 'þ' => 'th', 'ð' => 'dh', 'æ' => 'ae', 'µ' => 'u', 'ĕ' => 'e',
            );
        }

        $str = str_replace(
                array_keys($UTF8_LOWER_ACCENTS),
                array_values($UTF8_LOWER_ACCENTS),
                $str
            );

        if ( is_null($UTF8_UPPER_ACCENTS) ) {
            $UTF8_UPPER_ACCENTS = array(
  'À' => 'A', 'Ô' => 'O', 'Ď' => 'D', 'Ḟ' => 'F', 'Ë' => 'E', 'Š' => 'S', 'Ơ' => 'O',
  'Ă' => 'A', 'Ř' => 'R', 'Ț' => 'T', 'Ň' => 'N', 'Ā' => 'A', 'Ķ' => 'K',
  'Ŝ' => 'S', 'Ỳ' => 'Y', 'Ņ' => 'N', 'Ĺ' => 'L', 'Ħ' => 'H', 'Ṗ' => 'P', 'Ó' => 'O',
  'Ú' => 'U', 'Ě' => 'E', 'É' => 'E', 'Ç' => 'C', 'Ẁ' => 'W', 'Ċ' => 'C', 'Õ' => 'O',
  'Ṡ' => 'S', 'Ø' => 'O', 'Ģ' => 'G', 'Ŧ' => 'T', 'Ș' => 'S', 'Ė' => 'E', 'Ĉ' => 'C',
  'Ś' => 'S', 'Î' => 'I', 'Ű' => 'U', 'Ć' => 'C', 'Ę' => 'E', 'Ŵ' => 'W', 'Ṫ' => 'T',
  'Ū' => 'U', 'Č' => 'C', 'Ö' => 'Oe', 'È' => 'E', 'Ŷ' => 'Y', 'Ą' => 'A', 'Ł' => 'L',
  'Ų' => 'U', 'Ů' => 'U', 'Ş' => 'S', 'Ğ' => 'G', 'Ļ' => 'L', 'Ƒ' => 'F', 'Ž' => 'Z',
  'Ẃ' => 'W', 'Ḃ' => 'B', 'Å' => 'A', 'Ì' => 'I', 'Ï' => 'I', 'Ḋ' => 'D', 'Ť' => 'T',
  'Ŗ' => 'R', 'Ä' => 'Ae', 'Í' => 'I', 'Ŕ' => 'R', 'Ê' => 'E', 'Ü' => 'Ue', 'Ò' => 'O',
  'Ē' => 'E', 'Ñ' => 'N', 'Ń' => 'N', 'Ĥ' => 'H', 'Ĝ' => 'G', 'Đ' => 'D', 'Ĵ' => 'J',
  'Ÿ' => 'Y', 'Ũ' => 'U', 'Ŭ' => 'U', 'Ư' => 'U', 'Ţ' => 'T', 'Ý' => 'Y', 'Ő' => 'O',
  'Â' => 'A', 'Ľ' => 'L', 'Ẅ' => 'W', 'Ż' => 'Z', 'Ī' => 'I', 'Ã' => 'A', 'Ġ' => 'G',
  'Ṁ' => 'M', 'Ō' => 'O', 'Ĩ' => 'I', 'Ù' => 'U', 'Į' => 'I', 'Ź' => 'Z', 'Á' => 'A',
  'Û' => 'U', 'Þ' => 'Th', 'Ð' => 'Dh', 'Æ' => 'Ae', 'Ĕ' => 'E',
            );
        }
        $str = str_replace(
                array_keys($UTF8_UPPER_ACCENTS),
                array_values($UTF8_UPPER_ACCENTS),
                $str
            );
        return $str;
    }

    /**
     * Convert file name from UTF-8 to system encoding
     *
     * @static
     * @access public
     * @param string $fileName
     * @return string
     */
    function convertToFilesystemEncoding($fileName)
    {
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        $encoding = $_config->getFilesystemEncoding();
        if (is_null($encoding) || strcasecmp($encoding, "UTF-8") == 0 || strcasecmp($encoding, "UTF8") == 0) {
            return $fileName;
        }

        if (!function_exists("iconv")) {
            if (strcasecmp($encoding, "ISO-8859-1") == 0 || strcasecmp($encoding, "ISO8859-1") == 0 || strcasecmp($encoding, "Latin1") == 0) {
                return str_replace("\0", "_", utf8_decode($fileName));
            } else if (function_exists('mb_convert_encoding')) {

                $encoded = @mb_convert_encoding($fileName, $encoding, 'UTF-8');
                if (@mb_strlen($fileName, "UTF-8") != @mb_strlen($encoded, $encoding)) {
                    return str_replace("\0", "_", preg_replace("/[^[:ascii:]]/u","_",$fileName));
                }
                else {
                    return str_replace("\0", "_", $encoded);
                }
            } else {
                return str_replace("\0", "_", preg_replace("/[^[:ascii:]]/u","_",$fileName));
            }
        }

        $converted = @iconv("UTF-8", $encoding . "//IGNORE//TRANSLIT", $fileName);
        if ($converted === false) {
            return str_replace("\0", "_", preg_replace("/[^[:ascii:]]/u","_",$fileName));
        }

        return $converted;
    }

    /**
     * Convert file name from system encoding into UTF-8
     *
     * @static
     * @access public
     * @param string $fileName
     * @return string
     */
    function convertToConnectorEncoding($fileName)
    {
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        $encoding = $_config->getFilesystemEncoding();
        if (is_null($encoding) || strcasecmp($encoding, "UTF-8") == 0 || strcasecmp($encoding, "UTF8") == 0) {
            return $fileName;
        }

        if (!function_exists("iconv")) {
            if (strcasecmp($encoding, "ISO-8859-1") == 0 || strcasecmp($encoding, "ISO8859-1") == 0 || strcasecmp($encoding, "Latin1") == 0) {
                return utf8_encode($fileName);
            } else {
                return $fileName;
            }
        }

        $converted = @iconv($encoding, "UTF-8", $fileName);

        if ($converted === false) {
            return $fileName;
        }

        return $converted;
    }

    /**
     * Find document root
     *
     * @return string
     * @access public
     */
    function getDocumentRootPath()
    {
        /**
         * The absolute pathname of the currently executing script.
         * Notatka: If a script is executed with the CLI, as a relative path, such as file.php or ../file.php,
         * $_SERVER['SCRIPT_FILENAME'] will contain the relative path specified by the user.
         */
        if (isset($_SERVER['SCRIPT_FILENAME'])) {
            $sRealPath = dirname($_SERVER['SCRIPT_FILENAME']);
        }
        else {
            /**
             * realpath — Returns canonicalized absolute pathname
             */
            $sRealPath = realpath( './' ) ;
        }

        /**
         * The filename of the currently executing script, relative to the document root.
         * For instance, $_SERVER['PHP_SELF'] in a script at the address http://example.com/test.php/foo.bar
         * would be /test.php/foo.bar.
         */
        $sSelfPath = dirname($_SERVER['PHP_SELF']);

        return substr($sRealPath, 0, strlen($sRealPath) - strlen($sSelfPath));
    }

    /**
     * Create directory recursively
     *
     * @static
     * @access public
     * @param string $dir
     * @param int $mode
     * @return boolean
     */
    function createDirectoryRecursively($dir)
    {
        if (is_dir($dir)) {
            return true;
        }

        //attempt to create directory
        $_config =& CKFinder_Connector_Core_Factory::getInstance("Core_Config");
        if ($perms = $_config->getChmodFolders()) {
            $oldUmask = umask(0);
            $bCreated = @mkdir($dir, $perms);
            umask($oldUmask);
        }
        else {
            $bCreated = @mkdir($dir);
        }

        if ($bCreated) {
            return true;
        }

        //failed to create directory, perhaps we need to create parent directories first
        if (!CKFinder_Connector_Utils_FileSystem::createDirectoryRecursively(dirname($dir))) {
            return false;
        }

        //parent directories created successfully, let's try to create directory once again
        if ($perms) {
            $old_umask = umask(0);
            $result = @mkdir($dir, $perms);
            umask($old_umask);
        }
        else {
            $result = @mkdir($dir);
        }

        return $result;
    }

    /**
     * Detect HTML in the first KB to prevent against potential security issue with
     * IE/Safari/Opera file type auto detection bug.
     * Returns true if file contain insecure HTML code at the beginning.
     *
     * @static
     * @access public
     * @param string $filePath absolute path to file
     * @return boolean
    */
    function detectHtml($filePath)
    {
        $fp = @fopen($filePath, 'rb');
        if ( $fp === false || !flock( $fp, LOCK_SH ) ) {
            return -1 ;
        }
        $chunk = fread($fp, 1024);
        flock( $fp, LOCK_UN ) ;
        fclose($fp);

        $chunk = strtolower($chunk);

        if (!$chunk) {
            return false;
        }

        $chunk = trim($chunk);

        if (preg_match("/<!DOCTYPE\W*X?HTML/sim", $chunk)) {
            return true;
        }

        $tags = array('<body', '<head', '<html', '<img', '<pre', '<script', '<table', '<title');

        foreach( $tags as $tag ) {
            if(false !== strpos($chunk, $tag)) {
                return true ;
            }
        }

        //type = javascript
        if (preg_match('!type\s*=\s*[\'"]?\s*(?:\w*/)?(?:ecma|java)!sim', $chunk)) {
            return true ;
        }

        //href = javascript
        //src = javascript
        //data = javascript
        if (preg_match('!(?:href|src|data)\s*=\s*[\'"]?\s*(?:ecma|java)script:!sim',$chunk)) {
            return true ;
        }

        //url(javascript
        if (preg_match('!url\s*\(\s*[\'"]?\s*(?:ecma|java)script:!sim', $chunk)) {
            return true ;
        }

        return false ;
    }

    /**
     * Check file content.
     * Currently this function validates only image files.
     * Returns false if file is invalid.
     *
     * @static
     * @access public
     * @param string $filePath absolute path to file
     * @param string $extension file extension
     * @param integer $detectionLevel 0 = none, 1 = use getimagesize for images, 2 = use DetectHtml for images
     * @return boolean
    */
    function isImageValid($filePath, $extension)
    {
        if (!@is_readable($filePath)) {
            return -1;
        }

        $imageCheckExtensions = array('gif', 'jpeg', 'jpg', 'png', 'psd', 'bmp', 'tiff');

        // version_compare is available since PHP4 >= 4.0.7
        if ( function_exists( 'version_compare' ) ) {
            $sCurrentVersion = phpversion();
            if ( version_compare( $sCurrentVersion, "4.2.0" ) >= 0 ) {
                $imageCheckExtensions[] = "tiff";
                $imageCheckExtensions[] = "tif";
            }
            if ( version_compare( $sCurrentVersion, "4.3.0" ) >= 0 ) {
                $imageCheckExtensions[] = "swc";
            }
            if ( version_compare( $sCurrentVersion, "4.3.2" ) >= 0 ) {
                $imageCheckExtensions[] = "jpc";
                $imageCheckExtensions[] = "jp2";
                $imageCheckExtensions[] = "jpx";
                $imageCheckExtensions[] = "jb2";
                $imageCheckExtensions[] = "xbm";
                $imageCheckExtensions[] = "wbmp";
            }
        }

        if ( !in_array( $extension, $imageCheckExtensions ) ) {
            return true;
        }

        if ( @getimagesize( $filePath ) === false ) {
            return false ;
        }

        return true;
    }

    /**
     * Returns true if directory is not empty
     *
     * @access public
     * @static
     * @param string $serverPath
     * @return boolean
     */
    function hasChildren($serverPath)
    {
        if (!is_dir($serverPath) || (false === $fh = @opendir($serverPath))) {
            return false;
        }

        $hasChildren = false;
        while (false !== ($filename = readdir($fh))) {
            if ($filename == '.' || $filename == '..') {
                continue;
            } else if (is_dir($serverPath . DIRECTORY_SEPARATOR . $filename)) {
                //we have found valid directory
                $hasChildren = true;
                break;
            }
        }

        closedir($fh);

        return $hasChildren;
    }
}
