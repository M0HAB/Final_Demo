<?php

/**
 * @return path, get the endpoint 
 * https://www.myapp.com/test 
 * return -> test
 */
function getEndPoint()
{
    $path = Request::path();
    $path = ucfirst(trim(substr($path, strpos($path, '/') + 1)));
    return $path;
}
