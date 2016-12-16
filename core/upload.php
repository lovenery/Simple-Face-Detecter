<?php
$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]); // ex:"uploads/file.jpg"
$uploadOk = 1;
$imageFileType = pathinfo($target_file, PATHINFO_EXTENSION); // ex:"jpg"
$hashname = uniqid() . '.' . $imageFileType; // ex:"5853e65ae793e.png"

/*
$_FILES["fileToUpload"] is an Array {
    ["name"] => string "真實檔名",
    ["type"] => string "image/jpeg",
    ["tmp_name"]=> string "暫時存放的資料夾",
    ["error"]=> int (0),
    ["size"]=> int (245578)
}

getimagesize() return an Array {
    [0]=> int(1706)
    [1]=> int(960)
    [2]=> int(2)
    [3]=> string(25) "width="1706" height="960""
    ["bits"]=> int(8)
    ["channels"]=> int(3)
    ["mime"]=> string(10) "image/jpeg"
}
*/

// 檢查檔案是不是圖片
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        echo "File is an image - " . $check["mime"] . ".<br>";
        $uploadOk = 1;
    } else {
        echo "File is not an image.<br>";
        $uploadOk = 0;
    }
}

// 檢查檔案是否已存在
if (file_exists($target_file)) {
    echo "Sorry, file already exists.<br>";
    $uploadOk = 0;
}

// 檢查檔案大小
if ($_FILES["fileToUpload"]["size"] > 500000) {
   echo "Sorry, your file is too large.<br>";
   $uploadOk = 0;
}

// 允許的副檔名
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
    $uploadOk = 0;
}

// 最後檢查是否通過驗證
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.<br>";
// 如果以上驗證都過就上傳
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_dir.$hashname)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.<br>";
        runcpp($target_dir.$hashname, $imageFileType, "afters/".$hashname);
    } else {
        echo "Sorry, Something Wrong.<br>";
    }
}

function runcpp($file, $type, $after)
{
    $cmd  = "./face-detect -i=\"{$file}\" -o=\"{$after}\"";
    $last = exec($cmd);
    echo "<img src=\"{$after}\"><br><br><a href=\"../\">Go Back</a>";
}
?>
