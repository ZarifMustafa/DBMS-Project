<?php
    $hall_id = $_POST['hall_id'];
    $booking_date = $_POST['booking_date'];
    $booked_slot = $_POST['booked_slot'];

    echo "Hall ID: " . $hall_id . "<br>";
    echo "Booking Date: " . $booking_date . "<br>";
    echo "Booked Slot: " . $booked_slot . "<br>";

    $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

    $query = "UPDATE books SET status = 'cancelled' WHERE hall_id = :hall_id AND booking_date = :booking_date AND booked_slot = :booked_slot";
    $stmt = oci_parse($connection, $query);

    oci_bind_by_name($stmt, ':hall_id', $hall_id);
    oci_bind_by_name($stmt, ':booking_date', $booking_date);
    oci_bind_by_name($stmt, ':booked_slot', $booked_slot);
    echo $booked_slot;

    $query2 = "UPDATE booking_history SET status = 'cancelled' WHERE hall_id = :hall_id AND booking_date = :booking_date AND lower(booking_slot) = :booked_slot";
    $stmt2 = oci_parse($connection, $query);

    oci_bind_by_name($stmt2, ':hall_id', $hall_id);
    oci_bind_by_name($stmt2, ':booking_date', $booking_date);
    oci_bind_by_name($stmt2, ':booked_slot', $booked_slot);

    if (oci_execute($stmt)) {
        header("Location: cancel.html");
        echo "Booking cancelled successfully.";
    } else {
        echo "Failed to cancel booking.";
    }

?>
