<?php
use function PHPSTORM_META\type;

require '../../conn.php';
require '../functions.php';

$cname = @$_POST['cname'];
$cid = @$_POST['cid'];
$address = @$_POST['address'];
$email = @$_POST['email'];
$phone = @$_POST["number"];
$date= date('y-m-d');
$pass=1234;

if (empty($cid)) {
    if (empty($address) && empty($email) && empty($phone) && empty($cname)) {
        $result = [
            'message' => 'all this fields are required',
            'status' => 404
        ];
    } 

    $sql="select * from customers where email='$email'";
    $query=mysqli_query($conn,$sql);
    if($query && mysqli_num_rows($query) > 0){

   $result = [
            'message' => 'Record already exists',
            'status' => 404
        ];
    }
    else {

        $sql = "insert into customers values (null,'$cname','$phone','$address','$email','$date')";
        $query = mysqli_query($conn, $sql);
        if ($query) {



            $sql = "insert into users values (null,'$cname','$pass','$email','customer','active','$date')";
            $query = mysqli_query($conn, $sql);
            if ($query) {
            
            $result = [
                'message' => 'successfully inserted a new row',
                'status' => 200
            ];
            echo json_encode($result);
            return;
        }
        else{
            $result = [
                'message' => 'User inserted failed',
                'status' => 404
            ];
            echo json_encode($result);
            return;
        }
        
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
    $sql = "update customers set firstname='$cname',address='$address',email='$email',phone='$phone' where custid='$cid' ";
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





