<h1>Slider</h1>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $action = $_POST['action'];

    if ($action === 'add_slider') {
        $sName = $_POST['sName'];
        if ($sName !== '')
            if (!is_dir("sliders-img/$sName")) {
                mkdir("sliders-img/$sName");
                mkdir("sliders-img/$sName/$sName-origin");
                mkdir("sliders-img/$sName/$sName-small");
            }
    } else {
        $file = $_FILES['uploads'];
        $dName = $_POST['dName'];
        $allows_types = ['image/gif', 'image/png', 'image/jpeg', 'image/webp', 'image/avif'];

        for ($i = 0; $i < count($file['name']); $i++) {
            if (in_array($file['type'][$i], $allows_types)) {
                $fName = uniqid() . '_' . $file['name'][$i];
                move_uploaded_file($file['tmp_name'][$i], "sliders-img/$dName/$dName-origin/$fName");
                resizeAndSaveImage("sliders-img/$dName/$dName-origin/$fName", 600, "copy_" . $fName, "sliders-img/$dName/$dName-origin");
                resizeAndSaveImage("sliders-img/$dName/$dName-origin/$fName", 200, $fName, "sliders-img/$dName/$dName-small");
                unlink("sliders-img/$dName/$dName-origin/$fName");
            }
        }
    }
}

?>






<div class="form-box-style">

    <div>
        <div>Add new slider</div>
        <form action="/slider-add" method="post">
            <input type="hidden" name="action" value="add_slider">
            <div class="mt-1"><input type="text" name="sName" placeholder="Enter themes for slider"></div>
            <button class="btn btn-primary">add</button>
        </form>
    </div>

    <div class="border-style"></div>


    <div>
        <div>Add images to slider</div>
        <form action="/slider-add" method="post" enctype="multipart/form-data">
            <input type="hidden" name="action" value="add_imgs">
            <div class="mt-1"><input type="file" name="uploads[]" multiple required></div>
            <div class="mt-1">
                <select name="dName" id="" required>
                    <?php
                    $directories = scandir("sliders-img");
                    $directories = array_diff($directories, ['.', '..']);
                    foreach ($directories as $d) {
                        echo "<option value='$d'>$d</option>";
                    }
                    ?>
                </select>
            </div>
            <button class="btn btn-primary">add</button>
        </form>
    </div>

</div>