<?php

/**
 * @return path, get the endpoint 
 * https://www.myapp.com/test 
 * return -> test
 */
use App\Permission_role_default;
use App\Permission;

function getEndPoint()
{
    $path = Request::path();
    $path = ucfirst(trim(substr($path, strpos($path, '/') + 1)));
    return $path;
}
function dechexper($perName,$type){
    $sectionsNumber = 6; //change if number of sections exceeded 6
    $authuser = Auth::user();
    $number = $authuser->permission;
    if (empty($number)){
        $number = Permission_role_default::where('role', $authuser->role)->get();
        $number = $number[0]['permission'];
    }
    $hex = dechex( (int) $number);
    while (strlen($hex)<$sectionsNumber){
        $hex = "0" . $hex;
    }
    $perIndex = Permission::where('name', $perName)->get();
    $perIndex = $perIndex[0]['index'];
    $permission = substr($hex, $perIndex-1,1);
    $permission = base_convert($permission, 16, 2);
    while (strlen($permission)<4){
        $permission = "0" . $permission;
    }
    return substr($permission, $type,1);
}
function canCreate($perName){
    return dechexper($perName,0);
}
function canRead($perName){
    return dechexper($perName,1);
}
function canUpdate($perName){
    return dechexper($perName,2);
}
function canDelete($perName){
    return dechexper($perName,3);
}
