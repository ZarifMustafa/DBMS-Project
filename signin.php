<html>
    <head>
    <title>Oracle Demo</title></head>
    <body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //var_dump($_POST); // Debug statement to check the contents of the $_POST array

        $id = $_POST["login_id"];
        $password = $_POST["p"];

        echo $id;
        echo $password;

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$connection) {
            $error = oci_error();
            die("Connection failed: " . $error['message']);
        }

        $query = "truncate table temp";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);

        $query = "insert into temp (id, user_id) values(1, :id)";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':id', $id);
        oci_execute($statement);

        
        $query = "SELECT password from login_credentials where login_id=:id";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':id', $id);
        oci_execute($statement);
        if ($row = oci_fetch_assoc($statement)) {
            $correct_password = $row['PASSWORD'];
            if($password==$correct_password){
                $identity=substr($id, 0, 4);
                if($id == "ADMIN"){
                    $query = "update temp set logged_in_user='admin' where id=1";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    header('Location: Admin.html');
                }
                else if($identity == "CUST"){
                    $query = "update temp set logged_in_user='customer' where id=1";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    header('Location: Customer.html');
                }
                else if($identity == "STAF"){
                    $query = "update temp set logged_in_user='staff' where id=1";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    header('Location: home_staff.html');
                }
                else if($identity == "OWNR"){
                    $query = "update temp set logged_in_user='owner' where id=1";
                    $statement = oci_parse($connection, $query);
                    oci_execute($statement);

                    header('Location: Owner.html');
                }
                else{
                    echo 'Wrong ID';
                }
            }
            else{
                echo 'Wrong Password';
            }
        }
        else{
            echo 'Data not fetched';
        }
    }
    else{
        echo "Wrong Credentials.\n";
    }
    oci_free_statement($statement);
    oci_close($connection);
    ?>
    </body>
</html>