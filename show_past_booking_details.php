<!DOCTYPE html>
<html>
<head>
    <title>Booking Details</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }

        h2 {
            margin-bottom: 20px;
        }

        ul {
            list-style-type: none;
            padding: 0;
        }

        li {
            margin-bottom: 10px;
        }

        .cancel-button {
            margin-top: 20px;
        }

        .booking-details-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .booking-details-container h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        .booking-details-container ul li {
            font-size: 16px;
        }

        .cancel-button input[type="submit"] {
            background-color: #ff4c4c;
            color: #fff;
            border: none;
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border-radius: 4px;
        }

        .cancel-button input[type="submit"]:hover {
            background-color: #e60000;
        }
    </style>
</head>
<body>
    <div class="booking-details-container">
        <h2>Booking Details</h2>

        <?php

        $hall_id = $_POST['hall_id'];
        $booking_date = $_POST['booking_date'];
        $booked_slot = $_POST['booked_slot'];

        //echo $hall_id;
        //echo $booking_date;
        //secho $booked_slot;

        $conn = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        $query = "SELECT hall_name, hall_city, hall_area, hall_street, hall_house_no, menu.type, m_price, dec_id, theme, dec_price, catering_name, catering_price, payment_amount, booking_date, booked_slot, head_count FROM customer NATURAL JOIN books NATURAL JOIN hall NATURAL JOIN catering_service NATURAL JOIN decorations NATURAL JOIN menu NATURAL JOIN payment WHERE hall_id=:hall_id AND booking_date=:booking_date AND lower(booked_slot)=:booked_slot";
        $statement = oci_parse($conn, $query);
        oci_bind_by_name($statement, ':hall_id', $hall_id);
        oci_bind_by_name($statement, ':booking_date', $booking_date);
        oci_bind_by_name($statement, ':booked_slot', $booked_slot);
        oci_execute($statement);

        $row = oci_fetch_assoc($statement);

        if ($row) {
            // Display the booking details in a list format
            echo "<ul>";
            echo "<li><strong>Hall Name:</strong> " . $row['HALL_NAME'] . "</li>";
            echo "<li><strong>Hall City:</strong> " . $row['HALL_CITY'] . "</li>";
            echo "<li><strong>Hall Area:</strong> " . $row['HALL_AREA'] . "</li>";
            echo "<li><strong>Hall Street:</strong> " . $row['HALL_STREET'] . "</li>";
            echo "<li><strong>Hall House No:</strong> " . $row['HALL_HOUSE_NO'] . "</li>";
            echo "<li><strong>Menu Type:</strong> " . $row['TYPE'] . "</li>";
            echo "<li><strong>Menu Price:</strong> " . $row['M_PRICE'] . "</li>";
            echo "<li><strong>Decoration ID:</strong> " . $row['DEC_ID'] . "</li>";
            echo "<li><strong>Theme:</strong> " . $row['THEME'] . "</li>";
            echo "<li><strong>Decoration Price:</strong> " . $row['DEC_PRICE'] . "</li>";
            echo "<li><strong>Catering Name:</strong> " . $row['CATERING_NAME'] . "</li>";
            echo "<li><strong>Catering Price:</strong> " . $row['CATERING_PRICE'] . "</li>";
            echo "<li><strong>Payment Amount:</strong> " . $row['PAYMENT_AMOUNT'] . "</li>";
            echo "<li><strong>Booking Date:</strong> " . $row['BOOKING_DATE'] . "</li>";
            echo "<li><strong>Booked Slot:</strong> " . $row['BOOKED_SLOT'] . "</li>";
            echo "<li><strong>Head Count:</strong> " . $row['HEAD_COUNT'] . "</li>";
            echo "</ul>";

            // Add the Cancel Booking button
            echo '<form action="customer_view_history.php" method="post" class="cancel-button">';
            echo '<input type="hidden" name="hall_id" value="' . $hall_id . '">';
            echo '<input type="hidden" name="booking_date" value="' . $row['BOOKING_DATE'] . '">';
            echo '<input type="hidden" name="booked_slot" value="' . $row['BOOKED_SLOT'] . '">';
            echo '<input type="submit" value="Go Back">';
            echo '</form>';
        } else {
            echo "No booking details found.";
        }

        oci_close($conn);
        ?>

    </div>
</body>
</html>
