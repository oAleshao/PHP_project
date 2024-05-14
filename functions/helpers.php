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
