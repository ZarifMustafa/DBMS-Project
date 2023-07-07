<?php
    $totalAmount = $_POST['amount'];
    echo $totalAmount;
    $paymentID = null;

    $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

    // $query = "INSERT INTO payment (payment_id, payment_date, payment_amount) 
    // VALUES ('PAYM'||LPAD(payment_id_sequence.nextval,4,'0'), (select SYSDATE from dual), :totalAmount) RETURNING payment_id INTO :paymentID";
    // $statement=oci_parse($connection, $query);
    // oci_bind_by_name($statement, ':totalAmount', $totalAmount);
    // oci_bind_by_name($statement, ':paymentID', $paymentID, 50);
    // oci_execute($statement);

    $query = "update temp set payment_id=:paymentID";
    $statement=oci_parse($connection, $query);
    oci_bind_by_name($statement, ':paymentID', $paymentID);
    oci_execute($statement);

    $query = "INSERT INTO books 
    (customer_id, menu_id, hall_id, dec_id, catering_id, payment_id, booking_date, status, booked_slot, head_count)
    VALUES (
        (select user_id from temp where id=1), 
        (select menu_id from temp where id=1), 
        (select hall_id from temp where id=1), 
        (select dec_id from temp where id=1), 
        (select catering_id from temp where id=1), 
        'PAYM'||LPAD(payment_id_sequence.nextval,4,'0'), 
        (select booking_date from temp where id=1), 
        'Booked', 
        (select booking_slot from temp where id=1),
        (select head_count from temp where id=1)
    )";

    // $query = "insert into books 
    // (customer_id, menu_id, hall_id, dec_id, catering_id, payment_id, booking_date, status, booked_slot, head_count)
    // select 
    //     (select user_id from temp where id=1), 
    //     (select menu_id from temp where id=1), 
    //     (select hall_id from temp where id=1), 
    //     (select dec_id from temp where id=1), 
    //     (select catering_id from temp where id=1),
    //     'PAYM'||LPAD(payment_id_sequence.nextval,4,'0'), 
    //     (select booking_date from temp where id=1),
    //     'booked',
    //     (select booking_slot from temp where id=1),
    //     (select head_count from temp where id=1)
    // from dual";


    $statement=oci_parse($connection, $query);
    oci_execute($statement);

    $query = "INSERT INTO booking_history
    (booking_id, customer_id, hall_id, menu_id, dec_id, catering_id, payment_id, head_count, booking_date, booking_slot, booking_status)
    VALUES (
        'BOOK'||LPAD(booking_id_sequence.nextval,4,'0'),
        (select user_id from temp where id=1),  
        (select hall_id from temp where id=1), 
        (select menu_id from temp where id=1),
        (select dec_id from temp where id=1), 
        (select catering_id from temp where id=1), 
        (select payment_id from temp where id=1), 
        (select head_count from temp where id=1),
        (select booking_date from temp where id=1), 
        (select booking_slot from temp where id=1),
        'Booked'
    )";
    $statement=oci_parse($connection, $query);
    oci_execute($statement);

    oci_free_statement($statement);
    oci_close($connection);

    header("Location: booking_confirmed.html");
?>
