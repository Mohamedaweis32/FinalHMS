<?php

require_once '../../conn.php';
require_once '../functions.php';


if(isset($_POST["itemId"])){
    $id=$_POST['itemId'];
    $sql="delete from users where user_id ='$id'";
   $sucess= allqueryHandler($conn,$sql);
   if ($sucess){
    $result = [
        'message' => 'Failed to update user.',
        'status' => 404
    ];
   }
  $result = [
        'message' => 'Failed to update user.',
        'status' => 404
    ];

 }