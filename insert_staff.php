<html>
    <head>
    <title>Oracle Demo</title></head>
    <body>
    <?php


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        $staff_id = $_POST["staff_id"];
        $staff_nid = $_POST["staff_nid"];
        $staff_name = $_POST["staff_name"];
        $staff_city = $_POST["staff_city"];
        $staff_street = $_POST["staff_street"];
        $staff_house_no = $_POST["staff_house_no"];
        $staff_zipcode = $_POST["staff_zipcode"];
        $staff_type = $_POST["staff_type"];
        $staff_email = $_POST["staff_email"];

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$connection) {
            $error = oci_error();
            die("Connection failed: " . $error['message']);
        }

        $query = "INSERT INTO staff (staff_id, staff_nid, staff_name, staff_city, staff_street, staff_house_no, staff_zipcode, staff_type, staff_email) VALUES (:staff_id, :staff_nid, :staff_name, :staff_city, :staff_street, :staff_house_no, :staff_zipcode, :staff_type, :staff_email)";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':staff_id', $staff_id);
        oci_bind_by_name($statement, ':staff_nid', $staff_nid);
        oci_bind_by_name($statement, ':staff_name', $staff_name);
        oci_bind_by_name($statement, ':staff_city', $staff_city);
        oci_bind_by_name($statement, ':staff_street', $staff_street);
        oci_bind_by_name($statement, ':staff_house_no', $staff_house_no);
        oci_bind_by_name($statement, ':staff_zipcode', $staff_zipcode);
        oci_bind_by_name($statement, ':staff_type', $staff_type);
        oci_bind_by_name($statement, ':staff_email', $staff_email);

        $result = oci_execute($statement);
        if ($result) {
            echo "Data inserted successfully!";
        } 
        else {
            $error = oci_error($statement);
            echo "Data insertion failed: " . $error['message'];
        }
    }
    else{
        echo "Data not collected.\n";
    }
    oci_free_statement($statement);
    oci_close($connection);
    ?>
    </body>
</html>