<?php require_once 'conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
<link rel="stylesheet" href="style.css">
</head>
<style>
.print-button {
    background-color: #333; /* Change to dark grey */
    color: white;
    border: none;
    padding: 10px 20px;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin-top: 2%;
}

.print-button:hover {
    background-color: #0056b3;
}
</style>
<body>
<div class="container">
        <div class="receipt_header">
            <h1>Receipt of Booking <span>Armaan Halls</span></h1>
            <h2>Address:Benadir Afgooye Road, 1234-5 <span>Tel:+252 615147843 </span></h2>
        
   
    <!-- Use the styled print button -->
    <button class="print-button" onclick="printReceipt()">Print Receipt</button>
        </div>
        <div class="receipt_body">
            <div class="date_time_con">
                <div class="date"><?php echo date('m/d/Y'); ?></div>
                <div class="time"><?php echo date('h:i:s A'); ?></div>
            </div>
            <div class="items">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Hall</th>
                            <th>Event date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $custid=$_GET['id'];
                        $due = 0;
                        $balance = 0;
                        $paid = 0;
                        $previousName = null; // Track previous customer name
                        $date=date('y-m-d');
                        $sql = "SELECT h.hall_type AS hall, c.firstname AS name,b.start_date as sdate ,
                            COALESCE(t.credit, 0) AS paid, t.debit AS due,
                            COALESCE(t.debit - t.credit, t.debit) AS balance
                            FROM bookings AS b
                            LEFT JOIN transactions AS t ON b.booking_id = t.refID
                            LEFT JOIN halls AS h ON b.hall_id = h.hall_id
                            LEFT JOIN customers AS c ON b.customer_id = c.custid where 
                            b.customer_id='$custid' and t.transactionDate='$date'";

                        $query = mysqli_query($conn, $sql);
                        if ($query && mysqli_num_rows($query) > 0) {
                            while ($row = mysqli_fetch_assoc($query)) {
                                if ($previousName !== $row["name"]) {
                                    // Display customer name only when it changes
                                    echo "<tr>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["hall"] . "</td>";
                                    echo "<td>" . $row["sdate"] . "</td>";
                                    echo "</tr>";
                                    $previousName = $row["name"];
                                }

                                $paid += $row["paid"];
                                $due += $row["due"];
                                $balance += $row["balance"];
                            }

                            // Display total rows
                            echo "<tr>";
                            echo "<td>Total due</td>";
                            echo "<td></td>";
                            echo "<td>" . $due ."$" ."</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td>Total Paid</td>";
                            echo "<td></td>";
                            echo "<td>" . $paid ."$". "</td>";
                            echo "</tr>";
                            echo "<tr>";
                            echo "<td>Total Balance</td>";
                            echo "<td></td>";
                            echo "<td>" . $balance ."$". "</td>";
                            echo "</tr>";
                        } else {
                            echo "<tr><td colspan='3'>No data available</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <h3>Thank You !</h3>
    </div>
</body>
</html>
<script>
// Function to print the receipt
function printReceipt() {
    // Hide the print button before printing
    var printButton = document.querySelector('button');
    printButton.style.display = 'none';

    // Print the page
    window.print();

    // Restore the print button after printing is done
    printButton.style.display = 'block';
}
</script>