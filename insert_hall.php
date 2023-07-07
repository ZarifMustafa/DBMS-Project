<html>
    <head>
    <title>Oracle Demo</title></head>
    <body>
    <?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        //var_dump($_POST);
        $hall_name = $_POST["hall_name"];
        $hall_city = $_POST["hall_city"];
        $hall_area = $_POST["hall_area"];
        $hall_street = $_POST["hall_street"];
        $hall_house_no = $_POST["hall_house_no"];
        $hall_cost = $_POST["hall_cost"];
        $hall_capacity = $_POST["hall_capacity"];

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$connection) {
            $error = oci_error();
            die("Connection failed: " . $error['message']);
        }
        
        $halll_id=' ';
        $query = "INSERT INTO hall (hall_id, hall_name, hall_city, hall_area, hall_street, hall_house_no, hall_cost, hall_capacity) VALUES ('HALL'||LPAD(hall_id_sequence.nextval,4,'0'), :hall_name, :hall_city, :hall_area, :hall_street, :hall_house_no, :hall_cost, :hall_capacity) RETURNING hall_id INTO :halll_id";

        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':hall_name', $hall_name);
        oci_bind_by_name($statement, ':hall_city', $hall_city);
        oci_bind_by_name($statement, ':hall_area', $hall_area);
        oci_bind_by_name($statement, ':hall_street', $hall_street);
        oci_bind_by_name($statement, ':hall_house_no', $hall_house_no);
        oci_bind_by_name($statement, ':hall_cost', $hall_cost);
        oci_bind_by_name($statement, ':hall_capacity', $hall_capacity);
        oci_bind_by_name($statement, ':halll_id', $halll_id, 10);

        $result = oci_execute($statement);
        if ($result) {

            if(isset($_POST['morning'])){
                //echo 'morning';
                $query = "insert into hall_time_slot (hall_id, time_slot) values(:halll_id, 'morning')";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ':halll_id', $halll_id);
                oci_execute($statement);
            }

            if(isset($_POST['evening'])){
                //echo 'evening';
                $query = "insert into hall_time_slot (hall_id, time_slot) values(:halll_id, 'evening')";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ':halll_id', $halll_id);
                oci_execute($statement);
            }

            header('Location: hall_inserted.html');

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