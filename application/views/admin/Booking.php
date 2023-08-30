<?php include 'header.php'; 
include 'nav.php';   


include '../../../conn.php'; ?>
<style>
.checkbox-label {
    display: inline-block;
    margin-left: 5px;
    font-size: 12px;
    font-weight: bold;

    color: #333;
}

.custom-checkbox {
    appearance: none;
    -webkit-appearance: none;
    -moz-appearance: none;
    width: 20px;

    height: 20px;
    border: 2px solid #ccc;
    border-radius: 4px;
    outline: none;
    cursor: pointer;
    transition: background-color 0.3s, border-color 0.3s;


}

.btn-primary {
    color: #fff;
    background-color: #00487a !important;
    border-color: #00487a !important;
}

.custom-checkbox:checked {
    background-color: #2196F3;
    border-color: #2196F3;
}

.custom-checkbox:focus {
    box-shadow: 0 0 3px #2196F3;
}
</style>



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
                                                <div class="mb-3">
                                                    <button type="button"
                                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"
                                                        data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i
                                                            class="mdi mdi-plus me-1"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive mt-2">
                                        <table class="table table-hover datatable dt-responsive nowrap" id="tblBooking"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
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
                                                    <th scope="col">All Action</th>

                                                </tr>

                                            </thead>
                                            <?php
                // Select query
                $sql = "SELECT  b.bookingType as btype, b.booking_id AS id, DATE(b.created_at) AS bdate, b.updated_at AS bupdatedate, c.firstname AS cname, b.booking_status AS STATUS, h.hall_type AS htype, b.start_date AS sdate, b.end_date AS edate, b.attendee AS attend, b.Rate AS rate, SUM(tr.debit - tr.credit) AS balance FROM hbs.bookings b LEFT JOIN hbs.transactions tr ON b.booking_id = tr.refID LEFT JOIN hbs.customers c ON c.custid = tr.custid LEFT JOIN hbs.halls h ON h.hall_id = b.hall_id GROUP BY b.booking_id";
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
                        //     echo "<td>
                        //     <li class='list-inline-item'>
                        //     <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-id='$id '><i class='bx bxs-edit-alt'></i></a>
                        //     </li>
                        //     <li class='list-inline-item'>
                        //     <a href='#' class='text-danger p-2 delete-btn' data-item-id='$id'><i class='bx bxs-trash'></i></a>
                        // </li>
                       

                        // </td>";
                        ?>

                                            <td>
                                                <button class='btn btn-info btn-sm dropdown-toggle' type='button'
                                                    data-bs-toggle='dropdown' aria-haspopup='true' aria-expanded='false'
                                                    data-item-id='<?php echo $id; ?>'>Action</button>
                                                <div class='dropdown-menu dropdown-menu-end'>
                                                    <a class='dropdown-item text-success p-2 edit-btn'
                                                        data-bs-toggle='modal' data-bs-target='.orderdetailsModal'
                                                        data-item-id='<?php echo $id; ?>' href='#'><i
                                                            class='bx bxs-edit-alt'></i>Update</a>
                                                    <a class='dropdown-item text-danger p-2 receipt-btn'
                                                        data-bs-toggle='modal' data-bs-target='.receiptModal'
                                                        data-item-id='<?php echo $id; ?>' href='#'><i
                                                            class='bx bxs-edit-alt'></i>Reception</a>
                                                    <a class='dropdown-item text-secondary p-2 delete-btn'
                                                        data-bs-toggle='modal' data-item-id='<?php echo $id; ?>'
                                                        href='#'><i class='bx bxs-trash'></i>Delete</a>
                                                    <a class='dropdown-item text-dark p-2 refund-btn'
                                                        data-bs-toggle='modal' data-bs-target='.refundModal'
                                                        data-item-id='<?php echo $id; ?>' href='#'><i
                                                            class='bx bxs-edit-alt'></i>Refund</a>
                                                    <a class='dropdown-item text-warning p-2 discount-btn'
                                                        data-bs-toggle='modal' data-bs-target='.discountModal'
                                                        data-item-id='<?php echo $id; ?>' href='#'><i
                                                            class='bx bxs-edit-alt'></i>Discount</a>
                                                    <a class='dropdown-item text-secondary p-2 cancel-btn'
                                                        data-bs-toggle='modal' data-item-id='<?php echo $id; ?>'
                                                        href='#'><i class='bx bxs-cancel'></i><i
                                                            class='bx bxs-edit-alt'></i>Cancel</a>
                                                </div>
                                            </td>
                                            <?php
                    
                            echo "</tr>";
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
                                        </table>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <!-- end row -->

        </div> <!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <!-- Receiption Modal -->
    <div class="modal fade receiptModal" id="facilityModal" tabindex="-1" role="dialog"
        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Receiption</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="Receipt" action="../../../apis/booking/receipt.php" method="post">
                        <input type="hidden" class="form-control" id="rid" name="rid">
                        <input type="hidden" class="form-control" id="rbid" name="rbid">

                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Receipt Type</label>
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
                                    <input type="text" class="form-control" id="rcname" name="rcname">
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
    <!-- refund Modal -->
    <div class="modal fade refundModal" id="facilityModal" tabindex="-1" role="dialog"
        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Receiption</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="Refund" action="../../../apis/booking/Refund.php" method="post">
                        <input type="hidden" class="form-control" id="refid" name="refid">
                        <input type="hidden" class="form-control" id="refbid" name="refbid">

                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">refund Type</label>
                            <select name="rtype" class="form-control" id="rtype">
                                <option value="">Choose Refund Type</option>
                                <option value="EVC">EVC</option>
                                <option value="Edahab">Edahab</option>
                                <option value="Premier Wallet">Premier Wallet</option>
                            </select>
                        </div>
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Customer</label>
                                    <input type="text" class="form-control" id="refcname" name="refcname">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Amount</label>
                                    <input type="text" class="form-control" id="refamount" name="refamount"
                                        placeholder="Enter Price">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Amount Due</label>
                                    <input type="text" class="form-control" id="refdue" name="refdue"
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
    <!-- Discount Modal -->
    <div class="modal fade discountModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Discount</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="Discount" action="../../../apis/booking/discount.php" method="post">
                        <input type="hidden" class="form-control" id="desid" name="desid">
                        <input type="hidden" class="form-control" id="descbid" name="descbid">


                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Customer</label>
                                    <input type="text" class="form-control" id="descname" name="descname">
                                </div>
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Discount Amount</label>
                                    <input type="text" class="form-control" id="desamount" name="desamount"
                                        placeholder="Enter Price">
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Amount Due</label>
                                    <input type="text" class="form-control" id="desdue" name="desdue"
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
                    <div class="alert alert-danger" id="error"> </div>
                    <div class="alert alert-success" id="success"></div>
                    <form id="Book" method="post" action="../../../apis/booking/book.php">
                        <input type="hidden" class="form-control" id="bookid" name="bookid">

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Hall Name</label>
                                    <select class="form-select" name="hallId" id="hallId">
                                        <?php
                                        $query="select * from halls";
                                        $result=mysqli_query($conn,$query);
                                        ?>
                                        <option value=""> Choose Customer </option>
                                        <?php
                                        if($result&& mysqli_num_rows($result)>0){
                                            while($row = mysqli_fetch_assoc($result)){
                                                ?>
                                        <option value="<?php echo $row['hall_id']?>"><?php echo $row['hall_type']?>
                                        </option>
                                        <?php
                                            }

                                        }
                                        else{
                                            ?>
                                        <option> NO Data found</option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Customer Name</label>
                                    <select class="form-select" aria-label="Default select example" name="cid" id="cid">

                                        <?php
                                        $sql="select * from customers";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0 ){
                                      ?>
                                        <option value=""> Choose Customer </option>
                                        <?php
                                            while($row = mysqli_fetch_array($result)){
                                                ?>

                                        <option value="<?php echo $row['custid']?>"><?php echo $row['firstname']?>
                                        </option>
                                        <?php
                                            }

                                        }
                                        else{
                                            ?>
                                        <option> NO Data found</option>
                                        <?php
                                        }
                                        ?>

                                    </select>
                                </div>
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Start Date</label>
                                    <input type="date" class="form-control" id="startDate" name="startDate">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">End Date</label>
                                    <input type="date" class="form-control" id="endDate" name="endDate">
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Start Time</label>
                                    <input type="time" class="form-control" id="starttime" name="starttime">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">End Time</label>
                                    <input type="time" class="form-control" id="endtime" name="endtime">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Book Status</label>
                                    <select class="form-select" aria-label="Default select example" name="bstatus"
                                        id="bstatus">
                                        <option value="">Choose Booking Status</option>
                                        <option value="0">pending</option>
                                        <option value="1">approved</option>
                                        <option value="2">cancelled</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">attend</label>
                                    <input type="text" class="form-control" id="attend" name="attend"
                                        placeholder="Enter Attendee">
                                </div>


                            </div>
                        </div>

                        <div class="row">


                            <div class="mb-3">
                                <label for="Food">Food</label>
                                <select name="food" class="form-control" id="food">
                                    <?php

                                        $sql="select * from food";
                                        $result=mysqli_query($conn,$sql);
                                        if(mysqli_num_rows($result) > 0 ){
                                            ?>
                                    <option value="">choose food Type </option>
                                    <?php
                                            while($row = mysqli_fetch_array($result)){
                                  
                                                ?>


                                    <option value="<?php echo $row['foodId']?>"><?php echo $row['foodType']?></option>
                                    <?php
                                            }

                                        }
                                        else{
                                            ?>
                                    <option> NO Data found</option>
                                    <?php
                                        }
                                        ?>
                                </select>
                            </div>




                        </div>

                        <div class="mb-3">
                            <!-- Hidden input to hold the rate value -->
                            <input type="hidden" class="form-control" id="rate" name="rate" readonly=true>
                        </div>

                        <div class="mb-3">
                            <!-- Hidden input to hold the rate value -->
                            <input type="hidden" class="form-control" id="rate" name="rate" readonly=true>
                        </div>

                        <div class="mb-3">
                            <?php
    $sql = "select * from facility";
    $result = mysqli_query($conn, $sql);
    if (mysqli_num_rows($result) > 0) {
        ?>
                            <h6>Choose Facility</h1>
                                <?php
        foreach ($result as $row) {
            ?>
                                <!-- Use value attribute to store the facility ID -->
                                <input type="checkbox" class="facility-checkbox" name="facility_id[]" id="facilityID"
                                    value="<?php echo $row['facility_id']?>">
                                <label class="form-label checkbox-label"><?php echo $row['facility_name']?></label>
                                <?php
        }
    } else {
        ?>
                                <option> NO Data found</option>
                                <?php
    }
    ?>
                        </div>



                        <div class="row">

                        </div>

                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnbooking">Save Changes</button>

                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>

                </div>
                </form>
            </div>

        </div>
    </div>
</div>
<!-- end modal -->

</div>

<?php include 'footer.php'; ?>

<script>
$(document).ready(function() {


    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        deleteItem(itemId);
    });
    $('.cancel-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        cancel(itemId);
    });
    $('.edit-btn').click(function() {

        var bid = parseInt($(this).data('item-id'), 10);

        $.ajax({
            url: "../../../apis/booking/getBooking.php",
            type: 'POST',
            data: {
                bid: bid
            },
            success: function(response) {
                
                var bdata = JSON.parse(response);

                $('.facility-checkbox').prop('checked',
                false); // Uncheck all checkboxes initially

                $('#bookid').val(bdata.id);
                $('#bstatus').val(bdata.status);
                $('#rate').val(bdata.rate);
                $('#startDate').val(bdata.sdate);
                $('#hallId').val(bdata.hall_id);
                $('#endDate').val(bdata.edate);
                $('#attend').val(bdata.attend);
                $('#food').val(bdata.food).change();
                $('#cid').val(bdata.cname).change();
                $('#starttime').val(bdata.starttime);
                $('#endtime').val(bdata.endtime);

                // Object to keep track of processed facility IDs
                const processedFacilities = {};

                // Loop through the facilities and set the checkboxes accordingly
                const facilityIds = bdata.facilities;
                facilityIds.forEach((facilityId) => {
                    if (!processedFacilities[facilityId]) {
                        $(`input.facility-checkbox[value="${facilityId}"]`).prop(
                            'checked', true);
                        processedFacilities[facilityId] = true;
                    }
                });









            }
        });
    });
    $('.receipt-btn').click(function() {

        var rid = parseInt($(this).data('item-id'), 10);

        $.ajax({
            url: "../../../apis/booking/getReceiption.php",
            type: 'POST',
            data: {
                rid: rid
            },
            success: function(response) {

                var bdata = JSON.parse(response);

              
                $('#rcname').val(bdata.cname);
                $('#rdue').val(bdata.balance);
                $('#rbid').val(bdata.bid);


            }
        });
    });
    $('.refund-btn').click(function() {

        var rid = parseInt($(this).data('item-id'), 10);

        $.ajax({
            url: "../../../apis/booking/getReceiption.php",
            type: 'POST',
            data: {
                rid: rid
            },
            success: function(response) {

                var bdata = JSON.parse(response);

                console.log(bdata.id);
                $('#refcname').val(bdata.cname);
                $('#refdue').val(bdata.balance);
                $('#refbid').val(bdata.bid);


            }
        });
    });


    $('.discount-btn').click(function() {

        var rid = parseInt($(this).data('item-id'), 10);
 
        $.ajax({
            url: "../../../apis/booking/getReceiption.php",
            type: 'POST',
            data: {
                rid: rid
            },
            success: function(response) {
         
                var bdata = JSON.parse(response);

                console.log(bdata.id);
                $('#descname').val(bdata.cname);
                $('#desdue').val(bdata.balance);
                $('#descbid').val(bdata.bid);


            }
        });
    });

    $("#error").css("display", "none");
    $("#success").css("display", "none");

})
$("#Book").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "../../../apis/booking/book.php",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
           
            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {

                $("#success").css("display", "block");
                $("#success").text(res.message);
                window.location.href = 'Booking.php';
            } else if (res.status == 404) {
                //   $("#success").css("display", "none");
                //    $("#error").css("display", "block");
                //    $("#error").text(res.message);
            }

        }
    });


});
$("#Receipt").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "../../../apis/booking/receipt.php",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {


            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {
                id = res.id;
                var url = '../../../invoice.php?id=' + id;
                window.location.href = url;
                //    $("#success").css("display", "block");
                //     $("#success").text(res.message);

            } else if (res.status == 404) {
                $("#success").css("display", "none");
                $("#error").css("display", "block");
                $("#error").text(res.message);
            }

        }
    });


});
$("#Discount").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "../../../apis/booking/discount.php",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
 
            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {

                $("#success").css("display", "block");
                $("#success").text(res.message);
                window.location.href = 'Booking.php';
            } else if (res.status == 404) {
                //   $("#success").css("display", "none");
                //    $("#error").css("display", "block");
                //    $("#error").text(res.message);
            }

        }
    });


});


$("#Refund").submit(function(e) {
    e.preventDefault();
    $.ajax({
        url: "../../../apis/booking/refund.php",
        data: new FormData($(this)[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            alert(resp)
            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {

                $("#success").css("display", "block");
                $("#success").text(res.message);
                window.location.href = 'Booking.php';
            } else if (res.status == 404) {
                //   $("#success").css("display", "none");
                //    $("#error").css("display", "block");
                //    $("#error").text(res.message);
            }

        }
    });


});







function deleteItem(itemId) {
    $.ajax({
        url: "../../../apis/booking/delete.php",
        method: 'POST',
        data: {
            itemId: itemId
        },
        success: function(response) {
            window.location.href = 'booking.php';
            console.log(response);
            // Reload the page or update the UI as needed
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });
}

function cancel(itemId) {
    $.ajax({
        url: "../../../apis/booking/cancel.php",
        method: 'POST',
        data: {
            itemId: itemId
        },
        success: function(response) {
       
            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {

                $("#success").css("display", "block");
                $("#success").text(res.message);
                window.location.href = 'Booking.php';
            } else if (res.status == 404) {
                //   $("#success").css("display", "none");
                //    $("#error").css("display", "block");
                //    $("#error").text(res.message);
            }
        },
        error: function(xhr, status, error) {
            // Handle errors
            console.error(error);
        }
    });
}
</script>
<!-- 
goood jop -->