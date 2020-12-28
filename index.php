<?php include('connection.php') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Invoice</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/bootstrap/css/bootstrap.min.css">
    <script src="bootstrap/js/bootstrap.min.js"></script>
</head>


<div class="jumbotron text-center">
    <h1>Give Some Heading</h1>
</div>
<div class="d-flex justify-content-around p-3">
    <div class="p-6">
    </div>
</div>


<div class="container">
    <div class="row">
        <table class="table table-bordered">
            <thead>

                <body>

                    <tr>
                        <th>#</th>
                        <th>Price</th>
                        <th>Qty</th>
                        <th>Total</th>
                        <th>Action</th>
                    </tr>

            </thead>
            <tbody>
                <?php
                //-------------------------------------- Code for reset---------------------------
                $id = $_GET['id'];
                $total = $_GET['total'];
                $reset = $_GET['reset'];
                if ($reset) {
                    $sql = "UPDATE invoices SET total = 0 WHERE invoice = 599;";

                    if ($connection->query($sql) === TRUE) {
                        echo "All Records Restored";
                    } else {
                        echo "Error: " . $conn->error;
                    }
                }
                // --------------------------------/reset--------------------------------------------

                //-------------------- Code for update Total in each field ---------------------------
                if ($id && $total) {
                    $sql = "UPDATE invoices SET total=$total WHERE id=$id";

                    if ($connection->query($sql) === TRUE) {
                        echo "Record updated successfully";
                    } else {
                        echo "Error updating record: " . $conn->error;
                    }
                }

                // ------------------- /total ------------------------------------------------------------

                // ------------------------- fetching invoices where invoice equals to 599 --------------------------------------
                $query = "select * from invoices where invoice= 599";
                if ($result = mysqli_query($connection, $query) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($connection), E_USER_ERROR)) {
                    $serial = 1;
                    while ($row = $result->fetch_row()) {
                ?>
                        <tr>
                            <td><?php echo $serial++ ?></td>
                            <td><?php echo $row[2]; ?></td>
                            <td><?php echo $row[3]; ?></td>
                            <td><?php echo $row[4]; ?></td>
                            <td><a href="?id=<?php echo +$row[0]; ?>&&total=<?php echo $row[2] * $row[3] ?>"><button class="btn btn-success">Update Total</button></a></td>
                        </tr>

                    <?php

                    }
                    // ----------------------------------- / fetching-------------------------------------------

                    // ---------------------------- Sum of columns --------------------------------------------
                    $tableTotal = "SELECT SUM(qty) as qtyTotal, SUM(total) as totalSum FROM invoices where invoice = 599";
                    if ($result = mysqli_query($connection, $tableTotal) or trigger_error("Query Failed! SQL: $sql - Error: " . mysqli_error($connection), E_USER_ERROR)) {
                        $row = $result->fetch_assoc();
                    }
                    ?>

                    <tr>
                        <td><b>Total<b></td>
                        <td></td>
                        <td><b><?php echo $row['qtyTotal']; ?></b></td>
                        <td><b><?php echo $row['totalSum']; ?></b></td>
                        <td><a href="?reset=1"><button class="btn btn-danger">Reset</button></a></td>
                    </tr>
                <?php
                    // -----------------------------/ sum ------------------------------------------------
                }

                //  ------------------------------- closing the db connection ------------------------------------ 
                $result->free_result();
                $con->close();
                ?>

            </tbody>
        </table>
    </div>
    </body>

</html>