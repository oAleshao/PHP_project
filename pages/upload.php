<h1>Uploads</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $file = $_FILES['file'];
    extract($file);

    if ($error === 4) {
        $_SESSION['message_upload'] = ['File is required', 'danger'];
        redirect('upload');
    }
    if ($error !== 0) {
        $_SESSION['message_upload'] = ["File isn't uploaded", 'danger'];
        redirect('upload');
    }

    $allows_types = ['image/gif', 'image/png', 'image/jpeg', 'image/webp', 'image/avif'];
    if (!in_array($type, $allows_types)) {
        $_SESSION['message_upload'] = ["File isn't allowed", 'danger'];
        redirect('upload');
    }


    $fName = uniqid() . '_' . $name;
    move_uploaded_file($tmp_name, 'uploads-file/from-clients/' . $fName);
    //addWaterStamp('images/' . $fName, $fName);
    resize_image('uploads-file/from-clients/' . $fName, 100, true, '1.jpg', 'uploads-file/small-image');
    //resize_image('images/' . $fName, 100, false, '2.jpg', 'images');
    $_SESSION['message_upload'] = ["File is uploaded", 'success'];
}

function resize_image(string $path, int $size, bool $crop, string $imgName, string $dirName)
{

    extract(pathinfo($path));

    $functionCreate = 'imagecreatefrom' . ($extension === 'jpg' ? 'jpeg' : $extension);
    $src = $functionCreate($path);

    list($src_width, $src_height) = getimagesize($path);

    if ($crop) { // tight crop
        $dest = imagecreatetruecolor($size, $size);
        if ($src_width > $src_height) {
            imagecopyresampled($dest, $src, 0, 0, (int)($src_width / 2 - $src_height / 2), 0, $size, $size, $src_width, $src_height);
        } else {
            imagecopyresampled($dest, $src, 0, 0, 0, (int)($src_height / 2 - $src_width / 2), $size, $size, $src_width, $src_height);
        }
    } else { // normal crop
        $dest_width = (int)$size;
        $dest_height = (int)($size * $src_height / $src_width);
        $dest = imagecreatetruecolor($dest_width, $dest_height);
        imagecopyresampled($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);
    }

    $functionSave = 'image' . ($extension === 'jpg' ? 'jpeg' : $extension);

    $functionSave($dest, "$dirName/$imgName");
    echo "<img src='$dirName/$imgName' alt='$imgName'>";
}

function addWaterStamp(string $path, string $imgName, string $dirName)
{
    extract(pathinfo($path));

    $functionCreate = 'imagecreatefrom' . ($extension === 'jpg' ? 'jpeg' : $extension);
    $src = $functionCreate($path);
    $watermark = imagecreatefrompng("images/WaterStamp.png");
    list($watermark_width, $watermark_height) = getimagesize("images/WaterStamp.png");

    imagecopyresampled($src, $watermark, 0, 0, 0, 0, 100, 30, $watermark_width, $watermark_height);

    $functionSave = 'image' . ($extension === 'jpg' ? 'jpeg' : $extension);

    $functionSave($src, "$dirName/(watermark)$imgName");
    echo "<img src='$dirName/(watermark)$imgName' alt='(watermark)$imgName'>";
}
?>

<?php
show_session_data('message_upload');
?>

<form action="/upload" method="post" enctype="multipart/form-data">
    <input type="file" name="file">
    <button>Submit</button>
</form>

<?php

// $files = scandir('uploads-file');
// $files = array_diff($files, ['.', '..']);
// foreach ($files as $file) {
//     if (!is_dir("uploads-file/$file")) {
//         echo "<img src='uploads-file/$file' alt='$file'>";
//     }
// }

//print_r($files);
//dump($files);
$files = glob('uploads-file/*{jpeg,jpg,png}');
dump($files);


?>