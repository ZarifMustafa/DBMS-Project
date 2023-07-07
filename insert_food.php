<html>
    <head>
        <title>Oracle Demo</title>
    </head>
    <body>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $food_name = $_POST["food_name"];
            $food_description = $_POST["food_description"];

            $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

            if (!$connection) {
                $error = oci_error();
                die("Connection failed: " . $error['message']);
            }

            $food_query = "INSERT INTO food (food_id, food_name, food_description) VALUES ('FOOD'||LPAD(food_id_sequence.nextval,4,'0'), :food_name, :food_description)";
            $food_statement = oci_parse($connection, $food_query);
            oci_bind_by_name($food_statement, ':food_name', $food_name);
            oci_bind_by_name($food_statement, ':food_description', $food_description);

            $food_result = oci_execute($food_statement);

            if ($food_result) {
                    $commit_query = "COMMIT";
                    $commit_statement = oci_parse($connection, $commit_query);
                    oci_execute($commit_statement);

                    header('Location: Admin.html');
                    exit();
                oci_free_statement($food_statement);
                oci_close($connection);
            } else {
                $error = oci_error($food_statement);
                echo "food insertion failed: " . $error['message'];
            }
        }
        ?>
    </body>
</html>
