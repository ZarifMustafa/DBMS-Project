<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $hall_id = $_POST['hall_id'];
        $booking_date = $_POST['booking_date'];
        $booked_slot = $_POST['booked_slot'];

        //echo $hall_id;
        //echo $booking_date;
        //echo $booked_slot;

        $hall_rating = $_POST['hall_rating'];
        $food_rating = $_POST['food_rating'];
        $decoration_rating = $_POST['decoration_rating'];
        $service_rating = $_POST['service_rating'];
        $feedback = $_POST['feedback'];

        //echo $hall_rating;
        //echo $food_rating;
        //echo $decoration_rating;
        //echo $service_rating;
        //echo $feedback;

        $connection = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

        $query = "update booking_history set hall_rating=:hall_rating, menu_rating=:food_rating, decoration_rating=:decoration_rating, catering_rating=:service_rating
                  where hall_id=:hall_id and booking_date=:booking_date and lower(booking_slot)=:booked_slot";
        $statement = oci_parse($connection, $query);
        oci_bind_by_name($statement, ':hall_rating', $hall_rating);
        oci_bind_by_name($statement, ':food_rating', $food_rating);
        oci_bind_by_name($statement, ':decoration_rating', $decoration_rating);
        oci_bind_by_name($statement, ':service_rating', $service_rating);
        oci_bind_by_name($statement, ':hall_id', $hall_id);
        oci_bind_by_name($statement, ':booking_date', $booking_date);
        oci_bind_by_name($statement, ':booked_slot', $booked_slot);

        oci_execute($statement);

        $affectedRows = oci_num_rows($statement);

        if($affectedRows){

            $query = "BEGIN Update_Hall_Rating(:hall_id); END;";
            $statement=oci_parse($connection, $query);
            oci_bind_by_name($statement, ':hall_id', $hall_id);
            oci_execute($statement);

            $affectedRows = oci_num_rows($statement);
            echo $affectedRows;

            $query = "(SELECT menu_id FROM booking_history WHERE hall_id = :hall_id AND booking_date = :booking_date AND LOWER(booking_slot) = :booked_slot)";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':hall_id', $hall_id);
            oci_bind_by_name($statement, ':booking_date', $booking_date);
            oci_bind_by_name($statement, ':booked_slot', $booked_slot);
            oci_execute($statement);

            $row = oci_fetch_assoc($statement);
            $menu_id = $row['MENU_ID'];

            $query = "BEGIN Update_Menu_Rating(:menu_id); END;";
            $statement=oci_parse($connection, $query);
            oci_bind_by_name($statement, ':menu_id', $menu_id);
            oci_execute($statement);

            $affectedRows = oci_num_rows($statement);
            echo $affectedRows;

            $query = "(SELECT dec_id FROM booking_history WHERE hall_id = :hall_id AND booking_date = :booking_date AND LOWER(booking_slot) = :booked_slot)";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':hall_id', $hall_id);
            oci_bind_by_name($statement, ':booking_date', $booking_date);
            oci_bind_by_name($statement, ':booked_slot', $booked_slot);
            oci_execute($statement);

            $row = oci_fetch_assoc($statement);
            $dec_id = $row['DEC_ID'];
            
            $query = "BEGIN Update_Dec_Rating(:dec_id); END;";
            $statement=oci_parse($connection, $query);
            oci_bind_by_name($statement, ':dec_id', $dec_id);
            oci_execute($statement);

            $affectedRows = oci_num_rows($statement);
            echo $affectedRows;

            $query = "(SELECT catering_id FROM booking_history WHERE hall_id = :hall_id AND booking_date = :booking_date AND LOWER(booking_slot) = :booked_slot)";
            $statement = oci_parse($connection, $query);
            oci_bind_by_name($statement, ':hall_id', $hall_id);
            oci_bind_by_name($statement, ':booking_date', $booking_date);
            oci_bind_by_name($statement, ':booked_slot', $booked_slot);
            oci_execute($statement);

            $row = oci_fetch_assoc($statement);
            $catering_id = $row['CATERING_ID'];

            $query = "BEGIN Update_Catering_Rating(:catering_id); END;";
            $statement=oci_parse($connection, $query);
            oci_bind_by_name($statement, ':catering_id', $catering_id);
            oci_execute($statement);

            $affectedRows = oci_num_rows($statement);
            echo $affectedRows;

            if(!empty($feedback)){
                $query = "SELECT user_id FROM temp where id=1";
                $statement = oci_parse($connection, $query);
                oci_execute($statement);
                $row = oci_fetch_assoc($statement);
                $cust_id = $row['USER_ID'];

                $query = "insert into feedback(customer_id, hall_id, feedback_description) values(:cust_id, :hall_id, :feedback)";
                $statement = oci_parse($connection, $query);
                oci_bind_by_name($statement, ':hall_id', $hall_id);
                oci_bind_by_name($statement, ':cust_id', $cust_id);
                oci_bind_by_name($statement, ':feedback', $feedback);
                oci_execute($statement);
            }

            header("Location: thank_you_for_your_feedback.html");
        }
        else{
            echo 'Unsuccessful';
        }
    }
?>
