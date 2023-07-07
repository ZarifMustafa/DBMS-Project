<html>
    <head>
    <title>Logout</title></head>
    <body>
    <?php
        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');
        $query = "truncate table temp";
        $statement = oci_parse($connection, $query);
        oci_execute($statement);
        header("Location: Home4.html");
    ?>
    </body>
    </html>