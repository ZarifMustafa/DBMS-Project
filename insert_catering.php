<html>
    <head>
        <title>Oracle Demo</title>
    </head>
    <body>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $catering_name = $_POST["catering_name"];
            $catering_price = $_POST["catering_price"];

            $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

            if (!$connection) {
                $error = oci_error();
                die("Connection failed: " . $error['message']);
            }

            $catering_query = "INSERT INTO catering_service (catering_id, catering_name, catering_price) VALUES ('CATR'||LPAD(catering_id_sequence.nextval,4,'0'), :catering_name, :catering_price)";
            $catering_statement = oci_parse($connection, $catering_query);
            oci_bind_by_name($catering_statement, ':catering_name', $catering_name);
            oci_bind_by_name($catering_statement, ':catering_price', $catering_price);

            $catering_result = oci_execute($catering_statement);

            if ($catering_result) {
                    $commit_query = "COMMIT";
                    $commit_statement = oci_parse($connection, $commit_query);
                    oci_execute($commit_statement);

                    header('Location: Admin.html');
                    exit();
                oci_free_statement($catering_statement);
                oci_close($connection);
            } else {
                $error = oci_error($catering_statement);
                echo "catering insertion failed: " . $error['message'];
            }
        }
        ?>
    </body>
</html>
