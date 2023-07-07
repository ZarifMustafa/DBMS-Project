<html>
    <head>
    <title>Oracle Demo</title></head>
    <body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //var_dump($_POST);
    
        $customer_nid = $_POST["customer_nid"];
        $customer_name = $_POST["customer_name"];
        $customer_city = $_POST["customer_city"];
        $customer_street = $_POST["customer_street"];
        $customer_house_no = $_POST["customer_house_no"];
        $customer_zipcode = $_POST["customer_zipcode"];
        $customer_email = $_POST["customer_email"];
        $customer_password = $_POST["p"];

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$connection) {
            $error = oci_error();
            die("Connection failed: " . $error['message']);
        }
        
        $cust_id=' ';
        $query = "INSERT INTO customer (customer_id, customer_nid, customer_name, customer_city, customer_street, customer_house_no, customer_zipcode, customer_email) VALUES ('CUST'||LPAD(customer_id_sequence.nextval,4,'0'), :customer_nid, :customer_name, :customer_city, :customer_street, :customer_house_no, :customer_zipcode, :customer_email) RETURNING customer_id INTO :cust_id";

        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':customer_nid', $customer_nid);
        oci_bind_by_name($statement, ':customer_name', $customer_name);
        oci_bind_by_name($statement, ':customer_city', $customer_city);
        oci_bind_by_name($statement, ':customer_street', $customer_street);
        oci_bind_by_name($statement, ':customer_house_no', $customer_house_no);
        oci_bind_by_name($statement, ':customer_zipcode', $customer_zipcode);
        oci_bind_by_name($statement, ':customer_email', $customer_email);
        oci_bind_by_name($statement, ':cust_id', $cust_id, 10);

        $result = oci_execute($statement);
        if ($result) {
            //$query = "commit";
            //$statement = oci_parse($connection, $query);
            //oci_execute($statement);
            $query = "insert into login_credentials (login_id, password, status) values(:cust_id, :customer_password, 'OUT')";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':cust_id', $cust_id);
            oci_bind_by_name($statement, ':customer_password', $customer_password);
            oci_execute($statement);
            //echo $cust_id;
            //echo $customer_password;
            echo 'Password inserted';

            $query = "truncate table temp";
            $statement = oci_parse($connection, $query);
            oci_execute($statement);

            $query = "insert into temp (id, user_id, logged_in_user) values(1, :cust_id, 'customer')";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':cust_id', $cust_id);
            oci_execute($statement);
            header('Location: show_cust_id.html');
            //header('Location: signin.html');
            //echo "Data inserted successfully!";
        } 
        else {
            $error = oci_error($statement);
            echo "Data insertion failed: " . $error['message'];
            //header('Location: unsuccessful_customer_registration.html');
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