<?php
use function PHPSTORM_META\type;

require '../../conn.php';
require '../functions.php';

$Faci_id = @$_POST['fac_id'];
$Faci_name = @$_POST['fname'];
$price = @$_POST['price'];


if (empty($Faci_id)) {
    if (empty($Faci_name) && empty($price)) {
        $result = [
            'message' => 'All the Fields are required',
            'status' => 400
        ];
        echo json_encode($result);
        return;
    } 
    $sql="select * from facility where facility_name='$Faci_name'" ;
    $result=if_record_exists($conn,$sql);
    if($result){
        $result = [
            'message' => 'facility already exist',
            'status' => 400
        ];
        echo json_encode($result);
        return;
    }
    else {

        $sql = "insert into facility values (null,'$Faci_name','$price')";
        $query = mysqli_query($conn, $sql);
        if ($query) {
            $result = [
                'message' => 'successfully inserted a new row',
                'status' => 200
            ];
            echo json_encode($result);
            return;
        } else {

            $result = [
                'message' => 'Could Not Create new Hall',
                'status' => 404
            ];
            echo json_encode($result);
            return;
        }
    }
} else {
    $sql = "update facility set facility_name='$Faci_name',Price='$price' where facility_id='$Faci_id' ";
    $query = mysqli_query($conn, $sql);

    if ($query) {
       
        $result = [
            'message' => 'successfully Updated a new row',
            'status' => 200
        ];
        echo json_encode($result);
        return;
    } else {

        $result = [
            'message' => 'Could Not Updated',
            'status' => 404
        ];
        echo json_encode($result);
        return;
    }

    
}







// gooood jop