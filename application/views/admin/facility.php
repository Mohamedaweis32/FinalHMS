<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<?php include '../../../conn.php'; ?>



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
                        <h4 class="mb-sm-0 font-size-18">Facility</h4>

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
                                            <!-- <div class="col-xl col-sm-6">
                                                        </div>
                                                        <div class="col-xl col-sm-6">
                                                        </div> -->
                                            <div class="col-xl col-sm-6 align-self-end">
                                                <div class="mb-3">
                                                    <button type="button"
                                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"
                                                        data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i
                                                            class="mdi mdi-plus me-1"></i> Add New Facility</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive mt-2">
                                        <table class="table table-hover datatable dt-responsive nowrap" id="tblFacility"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Facility Name</th>
                                                    <th scope="col">Price</th>
                                                    <th scope="col">Action</th>
                                                </tr>

                                            </thead>
                                            <?php
                // Select query
                $sql = "SELECT * FROM facility WHERE 1";
                $result = mysqli_query($conn, $sql);
                $n=1;
                // Check if the query was successful
                if ($result) {
                    // Check if there are any rows returned
                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_assoc($result)) {
                            $Faci_id = $row['facility_id'];
                            $Faci_name = $row['facility_name'];
                            $price = $row['Price'];
                           
                      
                            // Display the data
                            echo "<tr>";
                            echo "<td>$n</td>";                         
                            echo "<td>$Faci_name</td>";                         
                            echo "<td>$price</td>";
                         
                            echo "<td>
                            <li class='list-inline-item'>
                            <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='#facilityModal' data-id='$Faci_id'><i class='bx bxs-edit-alt'></i></a>
                            </li>
                            <li class='list-inline-item'>
                            <a href='#' class='text-danger p-2 delete-btn' data-item-id='$Faci_id' ><i class='bx bxs-trash'></i></a>
                        </li></td>";
                            echo "</tr>";
                            $n++;
                        }
                    } else {
                        echo "<tr><td colspan='6'>No Facility found</td></tr>";
                    }
                } else {
                    echo "Error: " . mysqli_error($conn);
                }

                mysqli_close($conn);
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

    <!-- Modal -->
    <div class="modal fade orderdetailsModal" id="facilityModal" tabindex="-1" role="dialog"
        aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Facility</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="facility" action="../../../apis/Facility/facilities.php" method="post">
                        <input type="hidden" class="form-control" id="fac_id" name="fac_id">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Facility Name</label>
                            <input type="text" class="form-control" id="fname" name="fname"
                                placeholder="Enter Facility Name">
                        </div>

                        <div class="row">
                            <div class="col-md-">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Price</label>
                                    <input type="text" class="form-control" id="price" name="price"
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
    <!-- end modal -->

</div>

<?php include 'footer.php'; ?>

<style>
/* Custom styles for the table */
.dataTables_wrapper {
    padding: 20px;
}

.dataTables_filter {
    float: right;
}

.dataTables_paginate {
    float: right;
}
</style>
<!-- Include jQuery, Bootstrap, and DataTables -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

<!-- Add this to your HTML file -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<!-- SweetAlert CSS -->
<link rel="stylesheet" href="path/to/sweetalert2.min.css">

<!-- Your other HTML code -->

<!-- SweetAlert JS -->
<script src="path/to/sweetalert2.min.js"></script>





<script>
$(document).ready(function() {

    $('#tblFacility').DataTable();
    $('.dataTables_length').addClass('bs-select');

    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        deleteItem(itemId);
    });

    $("#error").css("display", "none");
    $("#success").css("display", "none");

})


$(document).ready(function() {
    $('.delete-btn').click(function(e) {
        e.preventDefault();
        var itemId = $(this).data('item-id');
        deleteItem(itemId);
    });

    $("#error").css("display", "none");
    $("#success").css("display", "none");

})


$("#facility").submit(function(e) {
    e.preventDefault();
    var form = $(this); // Store the form element in a variable

    $.ajax({
        url: "../../../apis/Facility/facilities.php",
        data: new FormData(form[0]),
        cache: false,
        contentType: false,
        processData: false,
        method: 'POST',
        type: 'POST',
        success: function(resp) {
            var res = jQuery.parseJSON(resp);
            if (res.status == 200) {
                // Use SweetAlert success alert
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: res.message
                }).then(function() {
                    // Redirect to the 'food.php' page after successful submission
                    window.location.href = 'facility.php';
                });
            } else if (res.status == 404) {
                // Use SweetAlert error alert
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: res.message
                });
            }
        }
    });
});





$(document).ready(function() {
    $('.edit-btn').click(function() {
        var fac_id = parseInt($(this).data('id'), 10);
        $.ajax({
            url: "../../../apis/Facility/getFacility.php",
            type: 'POST',
            data: {
                facility_id: fac_id
            },
            success: function(response) {
                // alert(response)
                var FaciData = JSON.parse(response);


                $('#fname').val(FaciData.type);
                $('#fac_id').val(FaciData.fid);
                $('#price').val(FaciData.price);



            }
        });
    });
});


function deleteItem(itemId) {
    // Use SweetAlert for delete confirmation
    Swal.fire({
        title: 'Are you sure?',
        text: 'You are about to delete this item. This action cannot be undone.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Delete',
    }).then((result) => {
        if (result.isConfirmed) {
            // If the user clicks 'Delete', proceed with the delete operation
            $.ajax({
                url: "../../../apis/Facility/delete.php",
                method: 'POST',
                data: {
                    itemId: itemId
                },
                success: function(response) {
                    // Use SweetAlert success alert
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted',
                        text: 'The item has been successfully deleted.',
                    }).then(() => {
                        // After showing the success alert, redirect to 'facility.php'
                        window.location.href = 'facility.php';
                    });
                },
                error: function(xhr, status, error) {
                    // Use SweetAlert error alert
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while deleting the item.',
                    });
                    console.error(error);
                }
            });
        }
    });
}
</script>



<!-- gooood Joooop -->