<?php
/**
 * Created by PhpStorm.
 * User: Davos
 * Date: 27-Dec-17
 * Time: 17:47
 */

$file = 'download/app-debug.apk';

if (file_exists($file)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/vnd.android.package-archive');
    header('Content-Disposition: attachment; filename=pitalice.apk');
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}
echo "downloaded";

?>