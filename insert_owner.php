<html>
    <head>
    <title>Oracle Demo</title></head>
    <body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
        $owner_nid = $_POST["owner_nid"];
        $owner_name = $_POST["owner_name"];
        $owner_city = $_POST["owner_city"];
        $owner_street = $_POST["owner_street"];
        $owner_house_no = $_POST["owner_house_no"];
        $owner_zipcode = $_POST["owner_zipcode"];
        $owner_email = $_POST["owner_email"];
        $owner_password = $_POST["p"];

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$connection) {
            $error = oci_error();
            die("Connection failed: " . $error['message']);
        }
        
        $ownr_id=' ';
        $query = "INSERT INTO owner (owner_id, owner_nid, owner_name, owner_city, owner_street, owner_house_no, owner_zipcode, owner_email) VALUES ('OWNR'||LPAD(owner_id_sequence.nextval,4,'0'), :owner_nid, :owner_name, :owner_city, :owner_street, :owner_house_no, :owner_zipcode, :owner_email) RETURNING owner_id INTO :ownr_id";

        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':owner_nid', $owner_nid);
        oci_bind_by_name($statement, ':owner_name', $owner_name);
        oci_bind_by_name($statement, ':owner_city', $owner_city);
        oci_bind_by_name($statement, ':owner_street', $owner_street);
        oci_bind_by_name($statement, ':owner_house_no', $owner_house_no);
        oci_bind_by_name($statement, ':owner_zipcode', $owner_zipcode);
        oci_bind_by_name($statement, ':owner_email', $owner_email);
        oci_bind_by_name($statement, ':ownr_id', $ownr_id, 10);

        $result = oci_execute($statement);
        if ($result) {
            echo 'inserted';
            //$query = "commit";
            //$statement = oci_parse($connection, $query);
            //oci_execute($statement);
            $query = "insert into login_credentials (login_id, password, status) values(:ownr_id, :owner_password, 'OUT')";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':ownr_id', $ownr_id);
            oci_bind_by_name($statement, ':owner_password', $owner_password);
            oci_execute($statement);
            //echo $ownr_id;
            //echo $owner_password;
            echo 'Password inserted';

            $query = "truncate table temp";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            $query = "insert into temp (id, user_id, logged_in_user) values(1, :ownr_id, 'owner')";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':ownr_id', $ownr_id);
            oci_execute($statement);
            header('Location: show_ownr_id.html');
            //header('Location: signin.html');
            //echo "Data inserted successfully!";
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