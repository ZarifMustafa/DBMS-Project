<?php
    if (isset($_GET['hall_id'])) {
        $hallId = $_GET['hall_id'];
    } else {
        header('Location: select_hall.php');
        exit();
    }

    $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

    if (!$connection) {
        $error = oci_error();
        die('Database connection failed: ' . $error['message']);
    }

    $query = 'SELECT * FROM owner';
    $statement = oci_parse($connection, $query);
    oci_execute($statement);

    $owners = array();

    while ($row = oci_fetch_assoc($statement)) {
        $ownerId = $row['OWNER_ID'];
        $ownerName = $row['OWNER_NAME'];

        $owners[$ownerId] = $ownerName;
    }

    oci_free_statement($statement);

    oci_close($connection);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Select Owner</title>
    <style>
        /* CSS styles here */
    </style>
</head>
<body>
    <div class="container">
        <h2>Select Owner</h2>
        <form method="post" action="manage_owns.php">
            <input type="hidden" name="hall_id" value="<?php echo $hallId; ?>">
            <select name="owner_id">
                <?php
                foreach ($owners as $ownerId => $ownerName) {
                    echo '<option value="' . $ownerId . '">' . $ownerName . '</option>';
                }
                ?>
            </select>
            <br>
            <input type="submit" value="Submit">
        </form>
    </div>
</body>
</html>
