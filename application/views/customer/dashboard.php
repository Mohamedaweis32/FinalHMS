
<?php include_once 'header.php'; ?>
<?php include_once 'nav.php'; ?>
<?php include_once '../../../conn.php'; ?>
<head>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

    <link href="fullcalendar/lib/locales/main.css" rel="stylesheet">
    <script src="fullcalendar/lib/locales/main.js"></script>
</head>




<style>
/* CSS for facility checkboxes */
.form-check {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.form-check-input {
    width: 20px;
    height: 20px;
    margin-right: 10px;
    cursor: pointer;
}

.form-check-label {
    cursor: pointer;
    font-size: 16px;
    font-weight: 500;
    color: #333;
}

/* Custom checkbox style */
.form-check-input[type="checkbox"] {
    -webkit-appearance: none;
    -moz-appearance: none;
    appearance: none;
    border: 2px solid #6c757d;
    border-radius: 4px;
    outline: none;
    transition: 0.2s;
}

.choose-facility-heading {
    font-size: 18px;
    font-weight: bold;
    color: #333;
    margin-bottom: 10px;
}

.form-check-input[type="checkbox"]:checked {
    background-color: #007bff;
    border-color: #007bff;
}

.form-check-input[type="checkbox"]:checked::before {
    content: "\2713";
    display: block;
    text-align: center;
    font-size: 14px;
    line-height: 16px;
    color: #fff;
}

/* Hover style */
.form-check-input[type="checkbox"]:hover {
    background-color: #f1f1f1;
}

/* Focus style */
.form-check-input[type="checkbox"]:focus {
    box-shadow: 0 0 0 3px rgba(0, 123, 255, 0.25);
}
</style>

<!-- end main content-->
<div class="main-content">
    <!-- START Page-content -->
    <div class="page-content">
        <div class="container-fluid">
            <!-- container-fluid -->
            <?php 
$email=$_SESSION['email'];
$sql="select * from Customers where email='$email'";
$result=mysqli_query($conn,$sql);
$record=mysqli_fetch_array($result);
$fullname=$record['firstname'];

?>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18"><?php echo $fullname ?></h4>
                        <div class="col-md-6">
            
            </div>
                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="javascript: void(0);">Armaan Halls</a></li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
           

            <!-- begin row -->
            <?php

                $sql="select * from halls ";
                $result=mysqli_query($conn,$sql);
                if($result){

                
                if( mysqli_num_rows($result)>0){

                    while($row = mysqli_fetch_assoc($result)){
                        ?> 
                        <div class="row" onclick="showCalendar(<?php echo $row['hall_id']; ?>)">
                        <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8 align-self-start">
                                    <div class="d-flex">
                                        <div class="me-3">
                                            <img src="../../<?php echo $row['hall_photo']?> " height="70px" width="70px"
                                                alt="" class="">
                                        </div>
                                        <div class="flex-grow-1 align-self-center">
                                            <div class="text-muted">
                                                <p class="mb-2">Hall Type ☕</p>
                                                <h5 class="mb-1"><?php echo $row['hall_type']?></h5>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-3 align-self-center">
                                    <div class="text-lg-center mt-4 mt-lg-0">
                                        <div class="row">
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Capacity</p>
                                                    <h5 class="mb-0"><?php echo $row['capacity']?></h5>
                                                </div>
                                            </div>

                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Hall Price</p>
                                                    <h5 class="mb-0"><?php echo $row['hallPrice']?></h5>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div>
                                                    <p class="text-muted text-truncate mb-2">Locattion</p>
                                                    <h5 class="mb-0"><?php echo $row['location']?></h5>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-1 d-none d-lg-block">
                                    <div class="clearfix mt-4 mt-lg-0">
                                        <div class="dropdown float-end">
                                            <button class="btn btn-sm btn-primary btn-book dropdown-toggle "
                                                data-bs-target=".orderdetailsModal" data-bs-toggle="modal"
                                                data-item-id="<?php echo $row['hall_id']; ?>" type="button"
                                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                <i class=""></i>Book Now</button>
                                            <!-- <div class="dropdown-menu dropdown-menu-end">
                                                    <a class="dropdown-item" href="#">Action</a>
                                                    <a class="dropdown-item" href="#">Manage Halls</a>
                                                    <a class="dropdown-item" href="#">View Halls</a>
                                                </div> -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- end row -->
                        </div>
                    </div>
                </div>
            </div>
            <?php
                    }
                }

                }
                else{
                    echo "no Records halls found";
                }

                ?>

            <!-- end row -->
         <!-- Modal -->
<div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetailsModalLabel">Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="BookingForm" method="post" action="custBooking.php">
                    <!-- Hidden inputs for booking and hotel IDs -->
                    <input type="hidden" class="form-control" id="bid" name="bid">
                    <input type="hidden" class="form-control" id="hid" name="hid">

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

                    <div class="row">
                        <!-- Additional rows if needed -->
                    </div>
            </div>
            <div class="modal-footer">
                <button type="submit" class="btn btn-primary">Save Changes</button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
            </div>
            </form>
        </div>
    </div>
</div>

        <!-- end modal -->


        <!-- end row -->


    </div> <!-- container-fluid -->
</div>
<!-- End Page-content -->

</div>
<!-- end main content-->
<?php include 'footer.php'; ?>

<!-- Include jQuery, Bootstrap, and DataTables -->

<script>
$(".btn-book").click(function() {
    // Get the ID from the clicked button
    var id = $(this).data("item-id");

    // Set the ID to the hidden input field
    $("#hid").val(id);


});
$("#BookingForm").submit(function(e){   
            e.preventDefault();
            $.ajax({
                url:"custBooking.php",
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
                                //window.location.href = 'dashboard.php';
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
  
        function showCalendar(hallId) {
    var modalContent = `
        <div class="modal fade" id="bookingCalendarModal" tabindex="-1" aria-labelledby="bookingCalendarModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="bookingCalendarModalLabel">Booking Calendar</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Placeholder content -->
                    </div>
                </div>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', modalContent);

    $('#bookingCalendarModal').modal('show'); // Show the modal
}



    </script>
