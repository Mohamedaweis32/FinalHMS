
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking History</title>

</head>


<?php
session_start();
include_once 'header.php'; 
include_once 'nav.php'; 
include_once 'footer.php'; 

include_once "../../../conn.php";

 $email= $_SESSION['email'];

 $sql="select c.firstname as name from bookings b
  left join customers c on b.customer_id =c.custid where c.email='$email'";
 $query=mysqli_query($conn,$sql);
 if (mysqli_num_rows($query) > 0){
    $row=mysqli_fetch_array($query);
    $firstname=$row['name'];
 }
else{
    $firstname='username not found';
}


?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0 font-size-18">Booking</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Dashboard</a></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!-- Tab panes -->
                                        
                                        <div class="tab-content p-3">
                                            <div class="tab-pane active" id="all-order" role="tabpanel">
                                                <form>
                                                    <div class="row">
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6 align-self-end">
                                                            <!-- <div class="mb-3">
                                                            <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i class="mdi mdi-plus me-1"></i></button>
                                                            </div> -->
                                                        </div>
                                                    </div>
                                                </form>

                                                <div class="table-responsive mt-2">
                                                    <table class="table table-hover datatable dt-responsive nowrap" id ="tblBooking" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                                        <thead>
                                                            <tr>
                                                        <thead>
                                                            <tr>
                                                                <th scope="col">#</th>
                                                                <th scope="col">HallName</th>
                                                                <th scope="col">Customer</th>
                                                                <th scope="col">StarDate</th>
                                                                <th scope="col">EndDate</th>
                                                                <th scope="col">Status</th>
                                                                <th scope="col">Type</th>
                                                                <th scope="col">Attendee</th>
                                                                <th scope="col">Rate</th>
                                                                <th scope="col">Balance</th>
                                                                <th scope="col">date</th>
                                                                <th scope="col">Actions</th>
                                                              
                                                            </tr>
                                                            
                                                        </thead>
                                                        
                                                        <?php
                                                        $email=$_SESSION['email'];
                                                        
                // Select query
                $sql = "SELECT
                b.bookingType AS btype,
                b.booking_id AS id,
                DATE(b.created_at) AS bdate,
                b.updated_at AS bupdatedate,
                c.firstname AS cname,
                b.booking_status AS STATUS,
                h.hall_type AS htype,
                b.start_date AS sdate,
                b.end_date AS edate,
                b.attendee AS attend,
                b.Rate AS rate,
                SUM(tr.debit - tr.credit) AS balance
            FROM
                hbs.bookings b
            LEFT JOIN
                hbs.transactions tr ON b.booking_id = tr.refID
            LEFT JOIN
                hbs.customers c ON c.custid = tr.custid
            LEFT JOIN
                hbs.halls h ON h.hall_id = b.hall_id
            WHERE
                c.email = '$email'
            GROUP BY
                b.booking_id;
            ";
                $result = mysqli_query($conn, $sql);
                $n=1;
                // Check if the query was successful
                if ($result) {
                    //Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $cname  = $row['cname'];
                            $id  = $row['id'];
                            $status = $row['STATUS'];
                            $rate = $row['rate'];
                            $htype  = $row['htype'];
                            $sdate = $row['sdate'];
                            $edate = $row['edate'];
                            $attend = $row['attend'];
                            $balance = $row['balance'];
                            $btype=$row['btype'];
                            $date = $row['bdate'];
                            // $date = $row['bdate'];
                            
                            // Display the data
                        
                            echo "<tr>";
                            echo "<td>$n</td>";   
                            echo "<td>$htype</td>";                      
                            echo "<td>$cname</td>";                         
                            echo "<td>$sdate</td>";                         
                            echo "<td>$edate</td>";     
                                          
                          
                           if($status==0){
                            echo "<td style='color: green;font-weight: bold; font-style: normal;'>Pending</td>";
                           }
                           else if($status==1){
                           echo "<td style='color: blue; font-weight: bold; font-style: italic;'>Approved</td>";
                           }
                           else {
                            echo "<td style='color: Red; font-weight: bold; font-style: italic;'>Cancelled</td>";
                           }
                           if($btype==0){
                            echo "<td>onlyHall</td>";
                           }
                           else{
                            echo "<td>withFood</td>";
                           }
                   
                            echo "<td>$attend</td>";
                            echo "<td>$rate</td>";
                            
                          
                            echo "<td>$balance</td>";
                            echo "<td>$date</td>";
//                             echo "<td>
//                             <li class='list-inline-item'>
//                             <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-id='$id '><i class='fas fa-check-circle'></i></a>
//                             </li>
//                             <li class='list-inline-item'>
//                             <a href='#' class='text-danger p-2 delete-btn' data-item-id='$id '> <i class='fas fa-times-circle'></i></a>
//                         </li></td>";
// echo "</tr>";
?>

<td>
<button class='btn btn-info btn-sm dropdown-toggle' type='button' data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false' data-item-id='<?php echo $id; ?>'>Action</button>
<div class='dropdown-menu dropdown-menu-end  ' >
<a class='dropdown-item text-danger p-2 receipt-btn' data-bs-toggle='modal' data-bs-target='.receiptModal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-edit-alt'></i>Reception</a>
<a class='dropdown-item text-warning p-2 discount-btn' data-bs-toggle='modal' data-bs-target='.adjustmentModal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-edit-alt'></i>Adjustment</a>
    <a class='dropdown-item text-secondary p-2 cancel-btn' data-bs-toggle='modal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-cancel'></i><i class='bx bxs-edit-alt'></i>Cancel</a>
    <a class='dropdown-item text-dark p-2 refund-btn' data-bs-toggle='modal' data-bs-target='.refundModal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-edit-alt'></i>close</a>
    <!-- <a class='dropdown-item text-secondary p-2 delete-btn' data-bs-toggle='modal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-trash'></i>Delete</a>
    
    
    <a class='dropdown-item text-secondary p-2 cancel-btn-btn' data-bs-toggle='modal' data-item-id='<?php echo $id; ?>' href='#'><i class='bx bxs-cancel'></i><i class='bx bxs-edit-alt'></i>Cancel</a> -->
</div>
</td>
<?php

                            // echo "</tr>";
                            $n+=+1;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No Booking found</td></tr>";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

               
            ?>
            

        </tbody>
    
                                                </div>
                                            </div>
                                        </div>


                                    </div>
                                </div>
                            
                        </div>
                        <!-- end row -->
                        
                    </div> <!-- container-fluid -->
                </div>

                <!-- Add this at the end of the <body> section of your HTML, just before </body> -->
<!-- Add this at the end of the <body> section of your HTML, just before </body> -->

    <!-- adjustmentModal Modal -->
<div class="modal fade adjustmentModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="orderdetailsModalLabel">Adjustment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateForm" action="adjustment.php" method="post">
                    <input type="hidden" class="form-control" id="bid" name="bid">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_date" class="form-label">Start date</label>
                                <input type="date" class="form-control" id="start_date" name="start_date">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_date" class="form-label">End date</label>
                                <input type="date" class="form-control" id="end_date" name="end_date">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="start_time" class="form-label">Start Time</label>
                                <input type="time" class="form-control" id="start_time" name="start_time">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="end_time" class="form-label">End Time</label>
                                <input type="time" class="form-control" id="end_time" name="end_time">
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary" id="btnFacility">Save Changes</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                            id="btnClose">Close</button>
                    </div>
                </form>
                <div id="alertContainer" class="mt-3"></div>
            </div>
        </div>
    </div>
</div>


      <!-- Receiption Modal -->
      <div class="modal fade receiptModal" id="facilityModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Receiption</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="Receipt" action="receipt.php" method="post">
                        <input type="hidden" class="form-control" id="rid" name="rid">
                        <input type="hidden" class="form-control" id="rbid" name="rbid">
                      
                        <div class="mb-3">
                            <label for="formrow-firstname-input"  class="form-label">Receipt Type</label>
                          <select name="rtype" class="form-control" id="rtype">
                            <option value="">Choose Receiption Type</option>
                            <option value="EVC">EVC</option>
                            <option value="Edahab">Edahab</option>
                            <option value="Premier Wallet">Premier Wallet</option>
                          </select>
                        </div>
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Customer</label>
                                    <input type="text" class="form-control" id="rcname" name="rcname"
                                       >
                                </div>
                            </div>

                        </div>
                      
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Amount</label>
                                    <input type="text" class="form-control" id="ramount" name="ramount"
                                        placeholder="Enter Price">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Amount Due</label>
                                    <input type="text" class="form-control" id="rdue" name="rdue"
                                        placeholder="Enter Price">
                                </div>
                            </div>

                        </div>
                     

                     
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnFacility">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"
                                id="btnClose">Close</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
    <!-- Add this to your HTML file -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>
<script>
$(document).ready(function() {

    $('.discount-btn').click(function() {
        var id = $(this).data('item-id');
        $('#bid').val(id);
      
    });
    function cancel(itemId) {
        $.ajax({
            url: "../../../apis/booking/cancel.php",
            method: 'POST',
            data: { itemId: itemId },
            success: function(response) {
                window.location.href = 'bookingsHistory.php';
                console.log(response);
                // Reload the page or update the UI as needed
            },
            error: function(xhr, status, error) {
                // Handle errors
                console.error(error);
            }
        });
    }

    $('.cancel-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        cancel(itemId);
    });
});

$(document).ready(function() {
    $("#updateForm").submit(function(e){   
            e.preventDefault();
            $.ajax({
                url:"adjustment.php",
                    data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                    method: 'POST',
                type: 'POST',
                success: function(resp) {
                    var res = jQuery.parseJSON(resp);
                    alert(res)
                    if (res.status == 200) {
                        Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: res.message,
                        }).then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = 'bookingsHistory.php';
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


  
});

$('.receipt-btn').click(function() {

var rid = parseInt($(this).data('item-id'), 10);

$.ajax({
    url:"../../../apis/booking/getReceiption.php",
    type: 'POST',
    data: { rid: rid },
    success: function(response) {
        
        var bdata = JSON.parse(response);
        
        alert(bdata.bid); 
        $('#rcname').val(bdata.cname);
        $('#rdue').val(bdata.balance);
        $('#rbid').val(bdata.bid);
 
        
    }
});
});

$("#Receipt").submit(function(e){   
             e.preventDefault();
             $.ajax({
                url:"receipt.php",
                 data: new FormData($(this)[0]),
                cache: false,
                contentType: false,
                processData: false,
                 method: 'POST',
                type: 'POST',
                success: function(resp) {

                 var res = jQuery.parseJSON(resp);
                 if (res.status == 200) {
                 id=res.id;
                 var url = '../../../invoice.php?id='+id;
                 window.location.href = url;
                //    $("#success").css("display", "block");
                //     $("#success").text(res.message);
            
              }     else if (res.status == 404) {
                  $("#success").css("display", "none");
                   $("#error").css("display", "block");
                   $("#error").text(res.message);
              }
            
                 }
             });


         });
</script>



