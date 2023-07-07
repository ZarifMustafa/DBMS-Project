<html>
    <head>
        <title>Oracle Demo</title>
    </head>
    <body>
        <?php

        // Retrieve data from the form

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Retrieve form data
            $type = $_POST["type"];
            $m_price = $_POST["m_price"];

            // Perform database connection and insertion

            $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

            if (!$connection) {
                $error = oci_error();
                die("Connection failed: " . $error['message']);
            }

            // Insert into menu table
            $menu_query = "INSERT INTO menu (menu_id, type, m_price) VALUES ('MENU'||LPAD(menu_id_sequence.nextval,4,'0'), :type, :m_price)";
            $menu_statement = oci_parse($connection, $menu_query);
            oci_bind_by_name($menu_statement, ':type', $type);
            oci_bind_by_name($menu_statement, ':m_price', $m_price);

            $menu_result = oci_execute($menu_statement);

            if ($menu_result) {
                    $commit_query = "COMMIT";
                    $commit_statement = oci_parse($connection, $commit_query);
                    oci_execute($commit_statement);

                    header('Location: Admin.html');
                    exit();
                oci_free_statement($menu_statement);
                oci_close($connection);
            } else {
                $error = oci_error($menu_statement);
                echo "menu insertion failed: " . $error['message'];
            }
        }
        ?>
    </body>
</html>
