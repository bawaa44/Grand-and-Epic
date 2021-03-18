<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successfull</title>
</head>

<body>
    Your Payment has been Successfully completed & we are looking forward to having you here
    <?php
    include('../../config/connection.php');
    if ($_GET['type'] == 'events') {
        $events_ID = $_GET['id'];
        $getEventDetailsTemp = mysqli_query($con, "SELECT * FROM events_booking_temp WHERE Events_ID='$events_ID'");
        while ($row = mysqli_fetch_assoc($getEventDetailsTemp)) {
            $customer_Name = $row["Customer_Name"];
            $customer_Email = $row["Customer_Email"];
            $num_Guests = $row["Num_Guests"];
            $event_Type = $row["Event_Type"];
            $reservation_Date = $row["Reservation_Date"];
            $starting_Time = $row["Starting_Time"];
            $ending_Time = $row["Ending_Time"];
            $mealPackage_ID = $row["MealPackage_ID"];
            $totalAmount = $row["Price"];
            $paidAmount = $row["Price"] * 0.2;
            $paymentSuccessEvent = mysqli_query($con, "INSERT into events_booking(Customer_Name,Customer_Email,Num_Guests,Event_Type,Reservation_Date,Starting_Time,Ending_Time,MealPackage_ID,Total_Amount,Paid_amount) VALUES('$customer_Name','$customer_Email','$num_Guests','$event_Type','$reservation_Date','$starting_Time','$ending_Time','$mealPackage_ID','$totalAmount','$paidAmount')");
            if ($paymentSuccessEvent) {
                $deleteTempEvtDetails = mysqli_query($con, "DELETE * FROM events_booking_temp WHERE Events_ID='$events_ID'");
            }
        }
    } else if ($_GET['type'] == 'staying-in') {
        $stayingInId = $_GET['order_id'];
        $selectTemp = mysqli_query($con, "SELECT * FROM stayingin_booking_temp WHERE StayingIn_ID='$stayingInId'");
        while ($rowStayingIn = mysqli_fetch_assoc($selectTemp)) {
            $occupancy = $rowStayingIn['Occupancy'];
            $noOccupants = $rowStayingIn['No_Occupants'];
            $noRooms = $rowStayingIn['No_Rooms'];
            $mealSelection = $rowStayingIn['Meal_Selection'];
            $reservationType = $rowStayingIn['Reservation_Type'];
            $checkInDate = $rowStayingIn['CheckIn_Date'];
            $checkOutDate = $rowStayingIn['CheckOut_Date'];
            $checkInTime = $rowStayingIn['CheckIn_Time'];
            $checkOutTime = $rowStayingIn['CheckOut_Time'];
            $roomType = $rowStayingIn['Room_Type'];
            $emailUser = $rowStayingIn['User_Email'];
            $roomPrice = $rowStayingIn['Room_Price'];
            $mealPrice = $rowStayingIn['Meal_Price'];
            $totalAmountStayingIn = $mealPrice + $roomPrice;
            $paidAmountStayingIn = $totalAmountStayingIn * 0.2;
            $paymentSuccessStayingIn = mysqli_query($con, "INSERT into stayingin_booking (Occupancy,No_Occupants,No_Rooms,Meal_Selection,Reservation_Type,CheckIn_Date,CheckOut_Date,CheckIn_Time,CheckOut_Time,Room_Type,User_Email,Room_Price,Meal_Price,Paid_Amount,Total_Amount) VALUES('$occupancy','$noOccupants','$noRooms','$mealSelection','$reservationType','$checkInDate','$checkOutDate','$checkInTime','$checkOutTime','$roomType','$emailUser','$roomPrice','$mealPrice','$paidAmountStayingIn','$totalAmountStayingIn')");
            if ($paymentSuccessStayingIn) {
                $deleteTempStayDetails = mysqli_query($con, "DELETE * FROM stayingin_booking_temp WHERE StayingIn_ID='$stayingInId'");
                if (!$deleteTempStayDetails) {
                    echo 'noo';
                }
            }
        }
    }
    ?>
</body>

</html>