<html>
    <head>
        <title>Oracle Demo</title>
    </head>
    <body>
        <?php

        if ($_SERVER["REQUEST_METHOD"] == "POST") {

            $theme = $_POST["theme"];
            $description = $_POST["description"];
            $dec_price = $_POST["dec_price"];

            $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

            if (!$connection) {
                $error = oci_error();
                die("Connection failed: " . $error['message']);
            }

            $decorations_query = "INSERT INTO decorations (dec_id, theme, description, dec_price) VALUES ('DECO'||LPAD(decorations_id_sequence.nextval,4,'0'), :theme, :description, :dec_price)";
            $decorations_statement = oci_parse($connection, $decorations_query);
            oci_bind_by_name($decorations_statement, ':theme', $theme);
            oci_bind_by_name($decorations_statement, ':description', $description);
            oci_bind_by_name($decorations_statement, ':dec_price', $dec_price);

            $decorations_result = oci_execute($decorations_statement);

            if ($decorations_result) {
                    $commit_query = "COMMIT";
                    $commit_statement = oci_parse($connection, $commit_query);
                    oci_execute($commit_statement);

                    header('Location: Admin.html');
                    exit();
                oci_free_statement($decorations_statement);
                oci_close($connection);
            } else {
                $error = oci_error($decorations_statement);
                echo "decorations insertion failed: " . $error['message'];
            }
        }
        ?>
    </body>
</html>
