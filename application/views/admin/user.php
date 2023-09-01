<?php include 'header.php'; ?>
<?php include 'nav.php'; ?>
<?php include '../../../conn.php'; ?>

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


<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->
<div class="main-content">

    <div class="page-content">
        <div class="container-fluid">
            <div id="loader" class="loader"></div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Users</h4>

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
                                            <div class="col-xl col-sm-6 align-self-end">
                                                <div class="mb-3">
                                                    <button type="button"
                                                        class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2"
                                                        data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i
                                                            class="mdi mdi-plus me-1"></i> Add New User</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive mt-2">
                                        <table class="table table-hover datatable dt-responsive nowrap" id="tblCustomer"
                                            style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">User Name</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Passowrd</th>
                                                    <!-- <th scope="col">Status</th> -->
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Action</th>
                                                </tr>

                                            </thead>
                                            <?php
                                            // Select query
                                            $sql = "SELECT * FROM users WHERE 1";
                                            $result = mysqli_query($conn, $sql);
                                            $n = 1;

                                            // Check if the query was successful
                                            if ($result) {
                                                // Check if there are any rows returned
                                                if (mysqli_num_rows($result) > 0) {
                                                    while ($row = mysqli_fetch_assoc($result)) {
                                                        $userid = $row['user_id'];
                                                        $username = $row['username'];
                                                        $pass = $row['password'];
                                                        $email = $row['email'];
                                                        $type = $row['type'];
                                                        $status = $row['status'];
                                                        $maskedPassword = str_repeat('*', strlen($pass));

                                                        // Display the data
                                                        echo "<tr>";
                                                        echo "<td>$n</td>";
                                                        echo "<td>$username</td>";
                                                        echo "<td>$email</td>";
                                                        echo "<td>$maskedPassword</td>";
                                                        // if ($status == 1) {
                                                        //     echo "<td>Active</td>";
                                                        // } else {
                                                        //     echo "<td>InACtive</td>";
                                                        // }
                                            

                                                        echo "<td>$type</td>";
                                                        echo "<td>
                            <li class='list-inline-item'>
                            <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-item-id='$userid'><i class='bx bxs-edit-alt'></i></a>
                            </li>
                            <li class='list-inline-item'>
                            <a href='#' class='text-danger p-2 delete-btn' data-item-id='$userid'><i class='bx bxs-trash'></i></a>
                        </li></td>";
                                                        echo "</tr>";
                                                        $n++;

                                                    }
                                                } else {
                                                    echo "<tr><td colspan='6'>No users found</td></tr>";
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
    <div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby=orderdetailsModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="users" action="../../../apis/users/users.php" method="post">
                        <input type="hidden" class="form-control" id="userid" name="userid">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">User Name</label>
                            <input type="text" class="form-control form-control-sm" id="uname" name="uname"
                                placeholder="Enter Fullname">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">User Password</label>
                                    <input type="text" class="form-control form-control-sm" id="upass" name="upass"
                                        placeholder="Enter User Password">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Email</label>
                                    <input type="email" class="form-control form-control-sm" id="email" name="email"
                                        placeholder="Enter Email">
                                </div>
                            </div>
                        </div>



                        <div class="mb-3">
                            <select class="form-control form-control-sm" name="type" id="type">
                                <option value="">Choose User Type</option>
                                <option value="admin">Admin</option>
                                <option value="customer">Customer</option>

                            </select>
                        </div>


                        <!-- <div class="mb-3">
                            <select class="form-control form-control-sm" name="status" id="status">
                                <option value="">Choose User Status</option>
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>

                            </select>
                        </div> -->

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary" id="btnCustomer">Save Changes</button>
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


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.0.18/dist/sweetalert2.all.min.js"></script>

<!-- Your HTML and form code here -->

<div id="loader" class="loader"></div> <!-- Add this loader element to your HTML -->

<script>
    $(document).ready(function () {
        $('#tblCustomer').DataTable();
        $('.dataTables_length').addClass('bs-select');

        $('.delete-btn').click(function (e) {
            e.preventDefault();
            var itemId = $(this).data('item-id');
            deleteItem(itemId);
        });

        $(document).ready(function () {
            $('.delete-btn').click(function (e) {
                e.preventDefault();
                var itemId = $(this).data('item-id');
                deleteItem(itemId);
            });

            $("#error").css("display", "none");
            $("#success").css("display", "none");

        })
        $('.edit-btn').click(function () {
            var user_id = $(this).data('item-id');
            console.log(user_id)
            $.ajax({
                url: "../../../apis/users/getusers.php",
                type: 'POST',
                data: {
                    user_id: user_id
                },
                success: function (response) {
                    console.log(response)
                    var userData = JSON.parse(response);

                    $('#uname').val(userData.name);
                    $('#userid').val(userData.id);
                    $('#upass').val(userData.pass);
                    $('#email').val(userData.email);
                    $('#type').val(userData.type);
                    $('#status').val(userData.status);
                }
            });
        });

        $("#users").submit(function (e) {
            e.preventDefault(); // Prevent the form from submitting
            var formData = new FormData($(this)[0]);
            console.log(formData)
            // Show the loader
            $("#loader").show();

            $.ajax({
                url: '../../../apis/users/users.php',
                data: formData,
                cache: false,
                contentType: false,
                processData: false,
                method: 'POST',
                type: 'POST',
                dataType: 'json', // Specify that the response is JSON
                success: function (resp) {
                    console.log(resp); // Print the response to the console
                    if (resp.status == 200) {
                        // Show success alert
                        Swal.fire({
                            icon: 'success',
                            title: 'Success!',
                            text: resp.message,
                            timer: 2000, // Show success message for 2 seconds
                            timerProgressBar: true,
                            showConfirmButton: false
                        }).then(() => {
                            // Reload the page after the timer expires
                            window.location.reload();
                        });
                    } else if (resp.status == 404) {
                        // Show error alert
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: resp.message,
                            confirmButtonText: 'OK'
                        });
                    }
                },

                error: function (xhr, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'An error occurred while processing the request.'
                    });
                },
                complete: function () {
                    // Always hide the loader when the AJAX request is complete
                    $("#loader").hide();
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
                    url: '../../../apis/users/delete.php',
                    method: 'POST',
                    data: {
                        itemId: itemId
                    },
                    success: function (resp) {
                        window.location.reload();

                    },
                    error: function (xhr, status, error) {
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