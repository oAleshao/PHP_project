<?php
function resizeAndSaveImage(string $path, int $size, string $imgName, string $dirName)
{

    extract(pathinfo($path));

    $functionCreate = 'imagecreatefrom' . ($extension === 'jpg' ? 'jpeg' : $extension);
    $src = $functionCreate($path);
    list($src_width, $src_height) = getimagesize($path);
    if ($src_width > $src_height) {
        $dest_width = (int)$size;
        $dest_height = (int)($size * $src_height / $src_width);
    } else {
        $dest_height = (int)$size;
        $dest_width =
            (int)($size * $src_width / $src_height);
    }
    $dest = imagecreatetruecolor($dest_width, $dest_height);

    imagecopyresampled($dest, $src, 0, 0, 0, 0, $dest_width, $dest_height, $src_width, $src_height);

    $functionSave = 'image' . ($extension === 'jpg' ? 'jpeg' : $extension);
    $functionSave($dest, "$dirName/$imgName");
}

function getImages($dir)
{
    $all_images = scandir($dir);
    $all_images = array_diff($all_images, ['.', '..']);
    $result = [];

    foreach ($all_images as $image) {
        array_push($result, $image);
    }

    return $result;
}
