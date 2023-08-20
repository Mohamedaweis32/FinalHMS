<?php include './application/views/admin/header.php'; 
include '../application/views/admin/nav.php'; ?>   
    
<!-- ============================================================== -->
<!-- Start right Content here -->
<!-- ============================================================== -->

<!-- CSS styles -->
<style>  
    .btn-primary {
        color: #fff;
        background-color: #00487a !important;
        border-color: #00487a !important;
    }

    .selected-image-container {
        text-align: center;
    }

    #selected-image {
        max-width: 100%;
        max-height: 200px;
        border-radius: 50px;
    }

    .logo-thumbnail {
    max-width: 100px;
    max-height: 100px;
    border-radius: 50px;
    }
</style>
            
<div class="main-content">
    <div class="page-content">
        <div class="container-fluid">
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                        <h4 class="mb-sm-0 font-size-18">Company</h4>

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
                                                    <button type="button" class="btn btn-success btn-rounded waves-effect waves-light mb-2 me-2" data-bs-toggle="modal" data-bs-target=".orderdetailsModal"><i class="mdi mdi-plus me-1"></i> Add Company</button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>

                                    <div class="table-responsive mt-2">
                                        <table class="table table-hover datatable dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col">Company Name</th>
                                                    <th scope="col">Address</th>
                                                    <th scope="col">Email</th>
                                                    <th scope="col">Description</th>
                                                    <th scope="col">Logo</th>
                                                    <th scope="col">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                    include 'conn.php';

                                                    // Select query
                                                    $sql = "SELECT * FROM company WHERE 1";
                                                    $result = mysqli_query($conn, $sql);

                                                    // Check if the query was successful
                                                    if ($result) {
                                                        // Check if there are any rows returned
                                                        if (mysqli_num_rows($result) > 0) {
                                                            while ($row = mysqli_fetch_assoc($result)) {
                                                                $companyId = $row['CompanyID'];
                                                                $companyName = $row['CompanyName'];
                                                                $address = $row['Address'];
                                                                $email = $row['Email'];
                                                                $description = $row['Description'];
                                                                $logo = $row['Logo'];

                                                                // Display the data
                                                                echo "<tr>";
                                                                echo "<td>$companyId</td>";
                                                                echo "<td>$companyName</td>";
                                                                echo "<td>$address</td>";
                                                                echo "<td>$email</td>";
                                                                echo "<td>$description</td>";
                                                                echo "<td><img src='images/$logo' alt='Company Logo' class='logo-thumbnail'></td>";
                                                                echo "<td>
                                                                <li class='list-inline-item'>
                                                                    <a href='#' class='text-success p-2 edit-btn' data-bs-toggle='modal' data-bs-target='.orderdetailsModal' data-id='$companyId'><i class='bx bxs-edit-alt'></i></a>
                                                                </li>
                                                                <li class='list-inline-item'>
                                                                    <a href='#' class='text-danger p-2'><i class='bx bxs-trash'></i></a>
                                                                </li></td>";
                                                                echo "</tr>";
                                                            }
                                                        } else {
                                                            echo "<tr><td colspan='6'>No companies found</td></tr>";
                                                        }
                                                    } else {
                                                        echo "Error: " . mysqli_error($conn);
                                                    }

                                                    mysqli_close($conn);
                                                ?>
                                                <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

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
        </div><!-- container-fluid -->
    </div>
    <!-- End Page-content -->
    <!-- Modal -->
    <div class="modal fade orderdetailsModal" tabindex="-1" role="dialog" aria-labelledby="orderdetailsModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="orderdetailsModalLabel">Company</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form method="post" action="company.php">
                        <div class="mb-3">
                            <label for="formrow-firstname-input" class="form-label">Company Name</label>
                            <input type="text" class="form-control" id="cname" name="cname" placeholder="Enter Company Name">
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-address-input" class="form-label">Address</label>
                                    <input type="text" class="form-control" id="caddress" name="caddress" placeholder="Enter Company Address">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Phone</label>
                                    <input type="number" class="form-control" id="tell" name="tell" placeholder="Enter Company Phone">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="cemail" name="cemail" placeholder="Enter Company Email">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="formrow-email-input" class="form-label">Description</label>
                                    <input type="text" class="form-control" id="cdesc" name="cdesc" placeholder="Description....">
                                </div>
                            </div>
                        </div>              

                        <div class="row">
                            <div class="mb-3">
                                <label for="formrow-address-input" class="form-label">Company Logo</label>
                                <input type="file" class="form-control" id="clogo" name="clogo" placeholder="Enter Company Logo">
                            </div>
                        </div>
                        <div class="row">
                            <div class="modal-body">
                                <div class="selected-image-container">
                                    <img id="selected-image" src="" alt="Perview Logo">
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" id="btnSubmit" class="btn btn-primary" data-bs-dismiss="modal">Save Changes</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end modal -->        
</div>
<!-- end main content-->

<?php
    include 'conn.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $companyName = $_POST['cname'];
        $address = $_POST['caddress'];
        $phone = $_POST['tell'];
        $email = $_POST['cemail'];
        $logo = $_POST['clogo'];
        $description = $_POST['cdesc'];

        $companyName = mysqli_real_escape_string($conn, $companyName);
        $address = mysqli_real_escape_string($conn, $address);
        $phone = mysqli_real_escape_string($conn, $phone);
        $email = mysqli_real_escape_string($conn, $email);
        $description = mysqli_real_escape_string($conn, $description);

        $sql = "INSERT INTO company (CompanyName, Address, Phone, Email, Description, Logo)
                VALUES ('$companyName', '$address', '$phone', '$email', '$description', '$logo')";

        if (mysqli_query($conn, $sql)) {
            echo    "<script>
                        Swal.fire({
                            icon: 'success',
                            title: 'Success',
                            text: 'Company registered successfully!',
                            }).then(function() {
                                window.location.href = 'company.php';
                            });
                    </script>";
        } else {
                    echo "<script>
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: " . mysqli_error($conn) . "',
                        });
                    </script>";
        }
    }

    mysqli_close($conn);
?>


<script>

$(document).ready(function() {
    // When a file is selected, display the image
    $('#clogo').change(function(e) {
        var file = e.target.files[0];
        var reader = new FileReader();
        
        reader.onload = function(e) {
            $('#selected-image').attr('src', e.target.result);
        }
        
        reader.readAsDataURL(file);
    });
});



$(document).ready(function() {
    $('.edit-btn').click(function() {
        var companyId = parseInt($(this).data('id'), 10);
        console.log(companyId)
        $.ajax({
            url: 'get_company.php',
            type: 'POST',
            data: { companyId: companyId },
            success: function(response) {
                var companyData = JSON.parse(response);
                console.log(companyData.Logo);
                $('#cname').val(companyData.CompanyName);
                $('#caddress').val(companyData.Address);
                $('#tell').val(companyData.Phone);
                $('#cemail').val(companyData.Email);
                $('#cdesc').val(companyData.Description);
                $('#selected-image').attr('src', 'images/' + companyData.Logo);
            }
        });
    });
});
</script>




<?php include './application/views/admin/footer.php'; ?>
