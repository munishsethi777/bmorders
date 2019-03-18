<?php
    $fileName = "";
    if(isset($_POST["fname"]) && $_POST['fname'] != null){
        $fileName = $_POST['fname'];
        file_put_contents($fileName, base64_decode($_POST['content']));
    }else{
        $fileName = "data.". $_POST['format'];
        $handle = fopen($fileName, "w");
        fwrite($handle, $_POST['content']);
        fclose($handle);
    }


    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename='.basename($fileName));
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($fileName));
    readfile($fileName);
    exit;
?>
