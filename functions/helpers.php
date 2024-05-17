<?php

session_start();

function clear($str)
{
    return htmlentities((trim($str)));
}

function redirect($page)
{
    header("Location: /$page");
    exit;
}

function show_session_data($val_name)
{
    if (isset($_SESSION[$val_name])) {
        list($text, $type) = $_SESSION[$val_name];
        echo "<div class='text-$type'>$text</div>";
        unset($_SESSION[$val_name]);
    }
}
