<?php require_once "../../../conn.php"?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> HMS </title>
   
    <link rel="stylesheet" href="./fullcalendar/lib/main.min.css">
    
    <script src="./js/bootstrap.min.js"></script>
    <script src="./fullcalendar/lib/main.min.js"></script>
    <style>
        :root {
            --bs-success-rgb: 71, 222, 152 !important;
        }

        html,
        body {
            height: 100%;
            width: 100%;
            font-family: Apple Chancery, cursive;
        }

        .btn-info.text-light:hover,
        .btn-info.text-light:focus {
            background: #000;
        }
        table, tbody, td, tfoot, th, thead, tr {
            border-color: #ededed !important;
            border-style: solid;
            border-width: 1px !important;
        }
    </style>
</head>
<?php require_once "header.php"?>
<?php require_once "nav.php"?>

<?php

$id=$_GET['id'];



?>
   
    <div class="container py-5" id="page-container">
    <div class="container mt-5">
        <div class="row mt-5">
        <div class="row mt-5">
            <div class="col-md-9">
                <div id="calendar"></div>
            </div>
            <div class="col-md-3">
                <div class="cardt rounded-0 shadow">
                    <div class="card-header bg-gradient bg-primary text-light">
                        <h5 class="card-title">Booking Form</h5>
                    </div>
                    <div class="card-body">
                  
                <form id="BookingForm" method="post" action="custBooking.php">
                    <!-- Hidden inputs for booking and hotel IDs -->
                    <input type="hidden" class="form-control" id="bid" name="bid">
                    <input type="hidden" class="form-control" id="hid" name="hid" value="<?php echo $id ?>">

                    <!-- Start Date and End Date inputs -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="startDate" class="form-label">Start Date</label>
                                <input type="date" class="form-control" id="startDate" name="startDate" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endDate" class="form-label">End Date</label>
                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                            </div>
                        </div>
                    </div>

                    <!-- Start Time and End Time inputs -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="starttime" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="starttime" name="starttime" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="endtime" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="endtime" name="endtime" required>
                            </div>
                        </div>
                    </div>

                    <!-- Attendee input -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="attend" class="form-label">Attend</label>
                                <input type="text" class="form-control" id="attend" name="attend" placeholder="Enter Attendee"
                                    required>
                            </div>
                        </div>
                    </div>

                    <!-- Food selection -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="food" class="form-label">Food</label>
                                <select name="food" class="form-control" id="food" required>
                                    <?php
                                        $sql = "select * from food";
                                        $result = mysqli_query($conn, $sql);
                                        if (mysqli_num_rows($result) > 0) {
                                            while ($row = mysqli_fetch_array($result)) {
                                                $foodId = htmlspecialchars($row['foodId']);
                                                $foodType = htmlspecialchars($row['foodType']);
                                                echo "<option value=\"$foodId\">$foodType</option>";
                                            }
                                        } else {
                                            echo "<option value=\"\">No Data found</option>";
                                        }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="upfront" class="form-label">Upfront</label>
                                <input type="text" class="form-control" id="upfront" name="upfront"
                                    placeholder="Enter Upfront Amount">
                            </div>
                        </div>
                    </div>

                    <!-- Hidden input for Rate -->
                    <div class="mb-3">
                        <input type="hidden" class="form-control" id="rate" name="rate" readonly>
                    </div>

                    <!-- Facility selection -->
                    <div class="mb-3">
                        <center>
                            <h6 class="choose-facility-heading">Choose Facility That would be included in your
                                service</h6>
                        </center>
                        <?php
                            $sql = "select * from facility";
                            $result = mysqli_query($conn, $sql);
                            if (mysqli_num_rows($result) > 0) {
                                $checkboxCounter = 1;
                                while ($row = mysqli_fetch_array($result)) {
                                    $facilityId = htmlspecialchars($row['facility_id']);
                                    $facilityName = htmlspecialchars($row['facility_name']);
                                    echo "<div class=\"form-check\">";
                                    echo "<input type=\"checkbox\" id=\"facility$checkboxCounter\" class=\"form-check-input\" name=\"facility_id[]\" value=\"$facilityId\">";
                                    echo "<label for=\"facility$checkboxCounter\" class=\"form-check-label\">$facilityName</label>";
                                    echo "</div>";
                                    $checkboxCounter++;
                                }
                            } else {
                                echo "<p>No facilities found</p>";
                            }
                        ?>
                    </div>


                    <div class="card-footer">
                        <div class="text-center">
                            <button class="btn btn-primary btn-sm rounded-0" type="submit" ><i class="fa fa-save"></i> Save</button>
                            <button class="btn btn-default border btn-sm rounded-0" type="reset" form="schedule-form"><i class="fa fa-reset"></i> Cancel</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Event Details Modal -->
    <div class="modal fade" tabindex="-1" data-bs-backdrop="static" id="event-details-modal">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded-0">
                <div class="modal-header rounded-0">
                    <h5 class="modal-title">Booking Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body rounded-0">
                    <div class="container-fluid">
                        <dl>
                            <dt class="text-muted">Title</dt>
                            <dd id="title" class="fw-bold fs-4"></dd>
                            <!-- <dt class="text-muted">customer</dt>
                            <dd id="customer" class=""></dd> -->
                            <dt class="text-muted">Start</dt>
                            <dd id="start" class=""></dd>
                            <dt class="text-muted">End</dt>
                            <dd id="end" class=""></dd>
                            <dt class="text-muted">Start Time</dt>
                            <dd id="stime" class=""></dd>
                            <dt class="text-muted">End Time</dt>
                            <dd id="etime" class=""></dd>
                        </dl>
                    </div>
                </div>
                <div class="modal-footer rounded-0">
                    <div class="text-end">
                    
                        <button type="button" class="btn btn-secondary btn-sm rounded-0" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php 
$schedules = $conn->query("SELECT * FROM `Bookings` b  join customers c on c.custid=b.customer_id 
join halls h on h.hall_id=b.hall_id ");
$sched_res = [];
foreach($schedules->fetch_all(MYSQLI_ASSOC) as $row){
    $row['start_date'];
    $row['end_date'];
    $row['starttime'] ;
    $row['endtime'] ;
    $row['endtime'] ;
    $row['firstname'] ;
    $row['hall_type'] ;
    $sched_res[$row['booking_id']] = $row;
}
?>
<?php 
if(isset($conn)) $conn->close();
?>
</body>
<script>
    var scheds = $.parseJSON('<?= json_encode($sched_res) ?>')
    console.log(scheds)
</script>
<script src="script.js"></script>
    <!-- Event Details Modal -->

    <script>
    $(document).ready(function() {
        // Your code to fetch and set the hall price here

        function getHallprice() {
    var hallId = $('#hid').val();

    $.ajax({
        url: 'get_hall_price.php',
        method: 'GET',
        data: { id: hallId },
        dataType: 'json',
        success: function(response) {
            var hallPrice = response.hallPrice;

            var finalPrice = hallPrice / 2;
            $('#upfront').val(finalPrice);
        },
        error: function() {
            console.error('Error fetching hall price');
        }
    });
}


    // Call the getHallprice function when the document is ready
    getHallprice();
    });

    $("#BookingForm").submit(function(e) {   
        e.preventDefault();
        $.ajax({
            url: "custBooking.php",
            data: new FormData($(this)[0]),
            cache: false,
            contentType: false,
            processData: false,
            method: 'POST',
            type: 'POST',
            success: function(resp) {
                var res = jQuery.parseJSON(resp);
                
                if (res.status == 200) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = '../../../invoice.php';
                        }
                    });
                } else if (res.status == 404) {
                    // Use SweetAlert for error message
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: res.message,
                    });
                }
            },
            error: function (xhr, status, error) {
                console.error('Error fetching data:', error);
            }
        });
    });
</script>

