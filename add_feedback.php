<!DOCTYPE html>
<html>
<head>
    <title>Give Rating</title>
    <style>
        .rating-container {
            margin-bottom: 10px;
        }
        .rating-container label {
            font-size: 30px;
            color: #ccc;
            cursor: pointer;
        }
        .rating-container label:hover,
        .rating-container label:hover ~ label,
        .rating-container input[type="radio"]:checked ~ label {
            color: #ffcc00;
        }
        .feedback-container {
            margin-top: 20px;
        }
        .feedback-container label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .feedback-container textarea {
            width: 100%;
            height: 100px;
        }
    </style>
</head>
<body>
    <h1>Give Rating</h1>
    <form action="process_ratings.php" method="POST">
        <?php
        $hall_id = $_POST['hall_id'];
        $booked_slot = $_POST['booked_slot'];
        $booking_date = $_POST['booking_date'];
        //echo $hall_id;
        //echo $booking_date;
        //echo $booked_slot;
        ?>
        <input type="hidden" name="hall_id" value="<?php echo $hall_id; ?>">
        <input type="hidden" name="booked_slot" value="<?php echo $booked_slot; ?>">
        <input type="hidden" name="booking_date" value="<?php echo $booking_date; ?>">
        <div class="rating-container">
            <label for="hall-rating">Rate the hall:</label>
            <input type="radio" name="hall_rating" value="5" id="hall-rating-5">
            <label for="hall-rating-5">&#9733;</label>
            <input type="radio" name="hall_rating" value="4" id="hall-rating-4">
            <label for="hall-rating-4">&#9733;</label>
            <input type="radio" name="hall_rating" value="3" id="hall-rating-3">
            <label for="hall-rating-3">&#9733;</label>
            <input type="radio" name="hall_rating" value="2" id="hall-rating-2">
            <label for="hall-rating-2">&#9733;</label>
            <input type="radio" name="hall_rating" value="1" id="hall-rating-1">
            <label for="hall-rating-1">&#9733;</label>
        </div>
        <div class="rating-container">
            <label for="food-rating">Rate the food:</label>
            <input type="radio" name="food_rating" value="5" id="food-rating-5">
            <label for="food-rating-5">&#9733;</label>
            <input type="radio" name="food_rating" value="4" id="food-rating-4">
            <label for="food-rating-4">&#9733;</label>
            <input type="radio" name="food_rating" value="3" id="food-rating-3">
            <label for="food-rating-3">&#9733;</label>
            <input type="radio" name="food_rating" value="2" id="food-rating-2">
            <label for="food-rating-2">&#9733;</label>
            <input type="radio" name="food_rating" value="1" id="food-rating-1">
            <label for="food-rating-1">&#9733;</label>
        </div>
        <div class="rating-container">
            <label for="decoration-rating">Rate the decoration:</label>
            <input type="radio" name="decoration_rating" value="5" id="decoration-rating-5">
            <label for="decoration-rating-5">&#9733;</label>
            <input type="radio" name="decoration_rating" value="4" id="decoration-rating-4">
            <label for="decoration-rating-4">&#9733;</label>
            <input type="radio" name="decoration_rating" value="3" id="decoration-rating-3">
            <label for="decoration-rating-3">&#9733;</label>
            <input type="radio" name="decoration_rating" value="2" id="decoration-rating-2">
            <label for="decoration-rating-2">&#9733;</label>
            <input type="radio" name="decoration_rating" value="1" id="decoration-rating-1">
            <label for="decoration-rating-1">&#9733;</label>
        </div>
        <div class="rating-container">
            <label for="service-rating">Rate the service:</label>
            <input type="radio" name="service_rating" value="5" id="service-rating-5">
            <label for="service-rating-5">&#9733;</label>
            <input type="radio" name="service_rating" value="4" id="service-rating-4">
            <label for="service-rating-4">&#9733;</label>
            <input type="radio" name="service_rating" value="3" id="service-rating-3">
            <label for="service-rating-3">&#9733;</label>
            <input type="radio" name="service_rating" value="2" id="service-rating-2">
            <label for="service-rating-2">&#9733;</label>
            <input type="radio" name="service_rating" value="1" id="service-rating-1">
            <label for="service-rating-1">&#9733;</label>
        </div>
        <div class="feedback-container">
            <label for="feedback">Feedback:</label>
            <textarea name="feedback" id="feedback" placeholder="Enter your feedback here..."></textarea>
        </div>
        <input type="submit" value="Submit">
    </form>
</body>
</html>
