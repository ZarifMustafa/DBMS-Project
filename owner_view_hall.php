<?php

$conn = oci_connect('HELLO', 'hello', 'localhost/XEPDB1');

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

$query = "DECLARE
    CURSOR ownr_pay_cursor IS
        SELECT TO_CHAR(p.payment_date, 'DD-MM-YYYY') AS \"Payment Date\",
               LTRIM(b.payment_id, 'PAY10') AS \"Payment No\",
               c.customer_name AS \"Customer Name\",
               LISTAGG(INITCAP(h.hall_name), ', ') WITHIN GROUP (ORDER BY h.hall_name) AS \"Hall Name\",
               b.booked_slot AS \"Booking Slot\",
               SUM((b.head_count * m.m_price) + (b.head_count * ca.catering_price) + d.dec_price + h.hall_cost) AS \"Total Payment\"
        FROM books b
        JOIN payment p ON b.payment_id = p.payment_id 
        JOIN customer c ON b.customer_id = c.customer_id
        JOIN hall h ON b.hall_id = h.hall_id
        JOIN menu m ON b.menu_id = m.menu_id
        JOIN catering_service ca ON b.catering_id = ca.catering_id
        JOIN decorations d ON b.dec_id = d.dec_id
        JOIN owns o ON b.hall_id = o.hall_id
        WHERE b.status = 'Booked' AND o.owner_id = 'OWNR0001'
        GROUP BY TO_CHAR(p.payment_date, 'DD-MM-YYYY'),
                 LTRIM(b.payment_id, 'PAY10'),
                 c.customer_name,
                 b.booked_slot
        ORDER BY LTRIM(b.payment_id, 'PAY10');

    ownr_pay_val ownr_pay_cursor%ROWTYPE;
BEGIN
    OPEN ownr_pay_cursor;

    LOOP
        FETCH ownr_pay_cursor INTO ownr_pay_val;

        EXIT WHEN ownr_pay_cursor%NOTFOUND;

        DBMS_OUTPUT.PUT_LINE('Payment Date: ' || ownr_pay_val.\"Payment Date\");
        DBMS_OUTPUT.PUT_LINE('Payment No: ' || ownr_pay_val.\"Payment No\");
        DBMS_OUTPUT.PUT_LINE('Customer Name: ' || ownr_pay_val.\"Customer Name\");
        DBMS_OUTPUT.PUT_LINE('Hall Name: ' || ownr_pay_val.\"Hall Name\");
        DBMS_OUTPUT.PUT_LINE('Booking Slot: ' || ownr_pay_val.\"Booking Slot\");
        DBMS_OUTPUT.PUT_LINE('Total Payment: ' || ownr_pay_val.\"Total Payment\");
        DBMS_OUTPUT.PUT_LINE('------------------------------');
    END LOOP;

    CLOSE ownr_pay_cursor;
END;";

$statement = oci_parse($conn, $query);
oci_execute($statement);

echo '<html>
<head>
    <title>Owner Payments</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        
        th, td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        
        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <h1>Owner Payments</h1>';

echo '<table>
        <tr>
            <th>Payment Date</th>
            <th>Payment No</th>
            <th>Customer Name</th>
            <th>Hall Name</th>
            <th>Booking Slot</th>
            <th>Total Payment</th>
        </tr>';

while ($row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo '<tr>
            <td>' . $row['Payment Date'] . '</td>
            <td>' . $row['Payment No'] . '</td>
            <td>' . $row['Customer Name'] . '</td>
            <td>' . $row['Hall Name'] . '</td>
            <td>' . $row['Booking Slot'] . '</td>
            <td>' . $row['Total Payment'] . '</td>
        </tr>';
}

echo '</table>';

oci_free_statement($statement);
oci_close($conn);
?>
