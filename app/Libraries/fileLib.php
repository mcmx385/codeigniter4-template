<?php

namespace App\Libraries;

class fileLib
{
    public function __construct()
    {
        $this->zip = new \PhpZip\ZipFile();
        $this->ciL = new \App\Libraries\ciLib();
    }
    public function getExtension($path)
    {
        return pathinfo($path, PATHINFO_EXTENSION);
    }
    public function download($path)
    {
        readfile($path);
    }
    public function ifExtension($file, $type)
    {
        return $this->getExtension($file) == $type;
    }
    public function upload($file, $path)
    {
        move_uploaded_file($file, $path);
    }
    public function uploadFile($filename, $path)
    {
        $file = $this->request->getFile($filename);
        $file->move($path);
    }
    public function appendFileName($path, $string)
    {
        $ext = $this->getExtension($path);
        $targetPath = $this->chopExtension($path);
        echo $targetPath;
        $targetPath = $targetPath . "$string." . $ext;
        return $targetPath;
    }
    public function ifExist($path)
    {
        return file_exists($path);
    }
    public function fileName($file)
    {
        return basename($file["name"]);
    }
    public function writeFile($path, $data)
    {
        write_file($path, $data);
    }
    public function getFilePath($path)
    {
        $baseurl = $this->ciL->baseurl();
        $path = str_replace("..", "", $path);
        $path = $baseurl . "/" . $path;
        $path = str_replace("//", "/", $path);
        // $path = str_replace("\\", "/", $path);
        // echo $path;
        return $path;
    }
    public function downloadFile($path)
    {
        if (file_exists($path)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($path) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($path));
            flush(); // Flush system output buffer
            readfile($path);
            die();
        } else {
            http_response_code(404);
            die();
        }
    }
    function compress_image($source_url, $destination_url, $quality)
    {
        $info = getimagesize($source_url);
        if ($info['mime'] == 'image/jpeg') $image = imagecreatefromjpeg($source_url);
        elseif ($info['mime'] == 'image/gif') $image = imagecreatefromgif($source_url);
        elseif ($info['mime'] == 'image/png') $image = imagecreatefrompng($source_url);
        imagejpeg($image, $destination_url, $quality);
    }
    # This gets an array of all directory and file
    function getls($path)
    {
        $files = array();
        $list = array();
        if ($path != "") {
            # This prepare the returning statement
            $count = substr_count($path, "/");
            $return = "../";
            while ($count > 0) {
                $return .= "../";
                $count -= 1;
            }
            # This opens the directory
            $dir = opendir($path);
            chdir($path);
            while (($dir = readdir()) != false) {
                if (is_file($dir)) {
                    array_push($files, $dir);
                } elseif (is_dir($dir)) {
                    array_push($list, $dir);
                }
            }
            chdir($return);
        } else {
            $result = scandir(getcwd());
            foreach ($result as $item) {
                if (is_file($item)) {
                    array_push($files, $item);
                } elseif (is_dir($item)) {
                    array_push($list, $item);
                }
            }
        }
        return array($files, $list);
    }
    # Return every thing in current or other directory
    function getevery($path)
    {
        if ($path == "") {
            return scandir(getcwd());
        }
        return scandir($path);
    }
    # Return all directory
    function getdirls($path)
    {
        return $this->getls($path)[1];
    }
    # Return all file
    function getfilels($path)
    {
        return $this->getls($path)[0];
    }
    # Return file with only extension
    function getonlyfilels($type, $path)
    {
        if ($path != "") {
            $count = substr_count($path, "/");
            $return = "../";
            while ($count > 0) {
                $return .= "../";
                $count -= 1;
            }
            # This opens the directory
            $dir = opendir($path);
            chdir($path);
        }
        $typename = "*." . $type;
        $result = glob($typename);
        if ($path != "") {
            chdir($return);
        }
        return $result;
    }
    public function deleteDir($dirPath)
    {
        if (is_dir($dirPath)) {
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    $this->deleteDir($file);
                } else {
                    unlink($file);
                }
            }
            rmdir($dirPath);
        }
    }
    public function deleteFile($path)
    {
        ignore_user_abort(true);
        unlink($path);
    }
    # Return file name with only extension
    function getonlyfilelswithoutex($type, $path)
    {
        $list = $this->getonlyfilels($type, $path);
        $new_list = [];
        $uncap_list = [];
        $capped_list = [];
        foreach ($list as $item) {
            $new_item = $this->chopExtension($item);
            $capped_item = ucfirst($new_item);
            array_push($uncap_list, $new_item);
            array_push($capped_list, $capped_item);
        }
        array_push($new_list, $uncap_list);
        array_push($new_list, $capped_list);
        return $new_list;
    }
    function getonlyfilelswithoutexuncap($type, $path)
    {
        return $this->getonlyfilelswithoutex($type, $path)[0];
    }
    function getonlyfilelswithoutexcapped($type, $path)
    {
        return $this->getonlyfilelswithoutex($type, $path)[1];
    }
    # Include all files with only extension
    function includer($type, $path)
    {
        $files = $this->getonlyfilels($type, $path);
        foreach ($files as $stuff) {
            include "$path/$stuff";
        }
    }
    # This removes the extension in a filename
    function chopExtension($filename)
    {
        return substr($filename, 0, strrpos($filename, '.'));
    }
    function capNextWhenSeparated($symbol, $string)
    {
        $sentence = "";
        $cap_next = true;
        $total = strlen($string);
        $count = 0;
        while ($count < $total) {
            if ($string[$count] == $symbol) {
                $sentence .= " ";
                $cap_next = true;
            } elseif ($cap_next) {
                $sentence .= ucfirst($string[$count]);
                $cap_next = false;
            } else {
                $sentence .= $string[$count];
            }
            $count += 1;
        }
        return $sentence;
    }
    # This make webpage tab title according to file name
    function titlebyfilename()
    {
        $title = $this->chopExtension(basename($_SERVER['PHP_SELF']));
        $title = $this->capNextWhenSeparated("_", $title);
        $title_title = "$title | Library";
?>
        <title><?php echo $title_title; ?></title>
<?php
        return $title_title;
    }

    public function autoloader($classname)
    {
        spl_autoload_register('autoloader');
        include_once 'path/to/class.files/' . $classname . '.php';
    }
}
