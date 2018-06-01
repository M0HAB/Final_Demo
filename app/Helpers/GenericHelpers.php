<?php

/**
 * @return path, get the endpoint
 * https://www.myapp.com/test
 * return -> test
 */
use App\Permission;
use App\Role;
use \App\Http\Controllers\MessagesController;
//Function to get current location in app Used in breadcrumbs
function getEndPoint()
{
    $path = Request::path();
    $path = ucfirst(trim(substr($path, strpos($path, '/') + 1)));
    return $path;
}
//Function to Extract specific index from Hex and convert it to binary
function hex2binPer($hex,$perIndex){
    //Extract only the requested permission index from hex
    $permission = substr($hex, $perIndex-1, 1);
    //Covert the hex to binary
    $permission = base_convert($permission, 16, 2);
    //Add leading zeroes to prevent errors
    while (strlen($permission)<4){
        $permission = "0" . $permission;
    }
    //Return the selected section permissions in binary
    return $permission;
}
//Function to get permissions of a specific Module for current auth user
function dechexper($perName,$type){
    //number of Modules in permission table
    $sectionsNumber = Permission::count();
    //Get Auth user
    $authuser = Auth::user();
    //Get current Auth user permission
    $number = $authuser->permission;
    //Get requested Module Data from permission table
    $perIndex = Permission::where('name', $perName)->get();
    //Extract index from received data
    $perIndex = $perIndex[0]['index'];
    //If current Auth user has no special permissions get the default ones
    if (empty($number)){
        $number = Role::find($authuser->role_id)->permission;
    }
    //Decimal to hex of permission
    $hex = dechex( (int) $number);
    //Add leading zeroes to prevent errors
    while (strlen($hex)<$sectionsNumber){
        $hex = "0" . $hex;
    }
    //Use method hex2binPer which takes the converted hex and the index
    $permission = hex2binPer($hex,$perIndex);
    //Return 1 char of the returned permission according to its type
    //0->Create, 1->Read, 2->Update, 3->Delete
    return substr($permission, $type, 1);
}
/*
Methods to ask about permission of a specific section utilizess previous method
Sends arguments:
    $perName -> Name of permission Modules to inquire about
    $type    -> can be (0, 1, 2, 3) donates the create, read, update, delete respectively
*/
function canCreate($perName){
    return dechexper($perName, 0);
}
function canRead($perName){
    return dechexper($perName, 1);
}
function canUpdate($perName){
    return dechexper($perName, 2);
}
function canDelete($perName){
    return dechexper($perName, 3);
}

function messageNav(){
  $msgController = new MessagesController;
  return $msgController->latestMessages();
}
