<h1>Gallery</h1>

<div id="Gallery_sliders">

</div>

<?php

$allSliders = scandir("sliders-img");
$allSliders = array_diff($allSliders, ['.', '..']);

$repeatCount = count($allSliders);

$result = [];
foreach ($allSliders as $slider) {
    array_push($result, [$slider, getImages("sliders-img/$slider/$slider-small")]);
}


?>

<script>
    function createSlider(nameSlider, images) {

        let name_slider = document.createElement("div");
        name_slider.textContent = nameSlider;
        name_slider.classList.add('text-title-style');

        let slider_box = document.createElement("div");
        slider_box.classList.add("slider-box");


        let prev_btn = createBtn("prev", nameSlider, images, (images.length - 1), prevImg);

        let next_btn = createBtn("next", nameSlider, images, 1, nextImg);

        let img_box = document.createElement("div");
        let image = document.createElement("img");
        image.id = nameSlider + "_img";
        image.src = `sliders-img/${nameSlider}/${nameSlider}-small/${images[0]}`;
        image.alt = 0;
        image.classList.add("img-in-img-box");
        img_box.classList.add("img-box");
        img_box.appendChild(image);
        image.onclick = () => {
            openImage(nameSlider, images);
        }

        slider_box.appendChild(prev_btn);
        slider_box.appendChild(img_box);
        slider_box.appendChild(next_btn);

        let hr = document.createElement("hr");

        document.getElementById("Gallery_sliders").appendChild(name_slider);
        document.getElementById("Gallery_sliders").appendChild(slider_box);
        document.getElementById("Gallery_sliders").appendChild(hr);

    }

    function openImage(nameSlider, images) {
        let box = document.createElement("div");
        box.classList.add("style-open-image");
        box.id = "origin-img-box";

        let img = document.getElementById(nameSlider + "_img");

        let image_add = document.createElement("img");
        image_add.src = `sliders-img/${nameSlider}/${nameSlider}-origin/copy_${images[+img.alt]}`;
        image_add.alt = images[+img.alt];
        image_add.classList.add("img-origin-style");

        let close = document.createElement("img");
        close.src = "uploads-file/icons/close.png";
        close.alt = "close";
        close.classList.add("close-style");
        close.onclick = () => {
            closeImage();
        }

        box.appendChild(close);
        box.appendChild(image_add);

        document.querySelector("body").appendChild(box);
    }

    function nextImg(nameSlider, images) {
        let image = document.getElementById(nameSlider + "_img");
        let prev_btn = document.getElementById(nameSlider + "_prev");
        let next_btn = document.getElementById(nameSlider + "_next");
        let indx = next_btn.alt.split('-');

        if (+indx[1] + 1 !== images.length) {
            image.src = `sliders-img/${nameSlider}/${nameSlider}-small/${images[indx[1]]}`;
            image.alt = indx[1];
            next_btn.alt = 'next-' + (+indx[1] + 1);
            prev_btn.alt = 'back-' + (+indx[1] - 1);
        } else {
            image.src = `sliders-img/${nameSlider}/${nameSlider}-small/${images[images.length-1]}`;
            image.alt = images.length - 1;
            next_btn.alt = 'next-0';
            prev_btn.alt = 'back-' + (images.length - 1);
        }
    }

    function prevImg(nameSlider, images) {
        let image = document.getElementById(nameSlider + "_img");
        let prev_btn = document.getElementById(nameSlider + "_prev");
        let next_btn = document.getElementById(nameSlider + "_next");
        let indx = prev_btn.alt.split('-');

        if (+indx[1] - 1 >= 0) {
            image.src = `sliders-img/${nameSlider}/${nameSlider}-small/${images[indx[1]]}`;
            image.alt = indx[1];
            prev_btn.alt = 'back-' + (+indx[1] - 1);
            if (+indx[1] + 1 !== images.length)
                next_btn.alt = 'next-' + (+indx[1] + 1);
            else
                next_btn.alt = 'next-0';

        } else {
            image.src = `sliders-img/${nameSlider}/${nameSlider}-small/${images[0]}`;
            image.alt = 0;
            next_btn.alt = 'next-1';
            prev_btn.alt = 'back-' + (images.length - 1);
        }
    }

    function createBtn(nameBtn, nameSlider, images, indx, callback) {
        let btn = document.createElement("div");
        let btn_img = document.createElement("img");
        btn_img.id = nameSlider + "_" + nameBtn;
        btn.classList.add(`btn-${nameBtn}-box`);
        btn_img.src = `/uploads-file/icons/${nameBtn}.png`;
        btn_img.alt = nameBtn + "-" + indx;
        btn.appendChild(btn_img);
        btn.onclick = () => {
            callback(nameSlider, images);
        }
        return btn;
    }

    function closeImage() {
        let image_box = document.getElementById("origin-img-box");
        console.log(image_box);
        document.querySelector("body").removeChild(image_box);
    }


    let repeatCount = <?php echo $repeatCount ?>;
    if (repeatCount !== 0) {
        let result = <?php echo json_encode($result);  ?>;
        for (let i = 0; i < repeatCount; i++) {
            if (result[i][1].length !== 0) {
                createSlider(result[i][0], result[i][1]);
            }
        }

    }
</script>