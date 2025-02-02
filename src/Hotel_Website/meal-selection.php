<html>

<head>
    <title>Meal Selection</title>
    <link rel="stylesheet" href="../../public/css/mealsselection.css">
    <script src="https://kit.fontawesome.com/1d5f2c83e1.js" crossorigin="anonymous"></script>
</head>

<style>
    @import url("https://fonts.googleapis.com/css2?family=Ubuntu:ital,wght@1,700&display=swap");

    body {
        background-image: url('../../public/images/events-meals-bg.jpeg');
        background-repeat: no-repeat;
        background-attachment: fixed;
        background-size: cover;
        font-family: sans-serif;
        color: black;
        font-weight: lighter;
    }

    figcaption {
        color: white;
    }

    .suite-form-header {
        display: flex;
        margin-top: -7px;
        flex-direction: row;
        justify-content: space-evenly;
        padding: 10px;
        background-color: #b88b4a;
        height: 15vh;
        text-align: center;
        color: white;
        width: 100%;
    }

    .suite-form-header h3 {
        font-family: "Ubuntu";
        padding-right: 30px;
        margin-top: 2px;
        padding-top: 5px;
    }

    .suite-form-header h3:last-child {
        border-right: none;
        padding-right: 20px;
    }
</style>

<body>
    <div class="suite-form-header" style="height: 12vh;">
        <h3 style="color:black;font-size:35px">Event Details & Location Availability</h3>
        <div style="border-right:1px solid white;line-height:10px"></div>
        <h3 style="color:white;font-size:35px">Meal Package Selection & Payment</h3>
    </div>

    <h1 style="text-align:center;color: white;margin-left:-5px;"><u>MEAL SELECTION</u></h1>
    <input type="button" value="Proceed to Payment" class="button1 Payment" onclick="showPayments()">
    <a href="events-booking-form.php"><input type="button" value="Start Over" class="button1 Payment" style="padding: 15px;position:absolute;top:20%;width:10%;left:22px"></a>
    <i class="fas fa-redo-alt" style="position:relative;top:-42px;width:10%;left:-30px;color:white"></i>
    <?php
    include('../../config/connection.php');
    $selectMeal = "SELECT * FROM events_meals_packages";
    $excecuteMeals = mysqli_query($con, $selectMeal);
    if (mysqli_num_rows($excecuteMeals) > 0) {
        while ($row = mysqli_fetch_assoc($excecuteMeals)) {
            echo '  <form action="events-booking.php" method="post">
                            <div style="color:white;margin-top:20px;background-color:black;opacity:0.7;padding:10px;" >
                                <h3 style="text-align:center;font-weight:bold;font-size:30px">' . $row["Package_Name"] . '</h2>
                                <div style="display:flex;flex-direction:row;justify-content:space-evenly;margin-top:20px">
                                    <div style="display:flex;flex-direction:column" class="set-menu-meals-card">
                                        <img src="data:image;base64,' . base64_encode($row["Meal1_Image"]) . '" alt="Image" style="width:180px;height:144px;" >
                                        <h4 style="text-align:center;margin-top:5px">' . $row["Meal1"] . '</h4>
                                    </div>
                                    <div style="display:flex;flex-direction:column">
                                        <img src="data:image;base64,' . base64_encode($row["Meal2_Image"]) . '" alt="Image" style="width:180px;height:144px;">
                                        <h4 style="text-align:center;margin-top:5px">' . $row["Meal2"] . '</h4>
                                    </div>
                                    <div style="display:flex;flex-direction:column">
                                        <img src="data:image;base64,' . base64_encode($row["Meal3_Image"]) . '" alt="Image" style="width:180px;height:144px;">
                                        <h4 style="text-align:center;margin-top:5px">' . $row["Meal3"] . '</h4>
                                    </div>
                                    <div style="display:flex;flex-direction:column">
                                        <img src="data:image;base64,' . base64_encode($row["Meal4_Image"]) . '" alt="Image" style="width:180px;height:144px;">
                                        <h4 style="text-align:center;margin-top:5px">' . $row["Meal4"] . '</h4>
                                    </div>
                                    <div style="display:flex;flex-direction:column">
                                        <img src="data:image;base64,' . base64_encode($row["Meal5_Image"]) . '" alt="Image" style="width:180px;height:144px;">
                                        <h4 style="text-align:center;margin-top:5px">' . $row["Meal5"] . '</h4>
                                    </div>
                                </div>
                                <div class="amount-events" style="margin-top:25px;margin-left:1200px"><span> Whole Plate For Rs.' . $row["price"] . '/=</span></div>
                                <input type="submit" style="padding:13px;border-radius:5px;margin-left:600px;margin-bottom:15px;background-color:green;color:white;border:none" value="Select the Package" name="Select_Meal" id="addCart" onsubmit="handleSubmit()">
                                <input type="hidden" value=' . $row["Package_ID"] . ' name="packageID">
                                <input type="hidden" value=' . $_GET["events_id"] . ' name="eventsID">
                            </div>
                            </form>';
        }
    }
    ?>
    <form action="https://sandbox.payhere.lk/pay/checkout" method="post">
        <div style="display:none;position:absolute;top:10px;background-color: black;opacity:0.95;width:100%;height:100%;justify-content:center;align-items:center;height:100vh" id="payments">
            <?php
            $eventID = $_GET["events_id"];
            $getEventDetails = "SELECT * FROM events_booking_temp WHERE Events_ID='$eventID'";
            $excecuteEventDetails = mysqli_query($con, $getEventDetails);
            $getAdvancePercentage = mysqli_query($con, "SELECT Advance_Percentage FROM advance_amount_table WHERE Reservation_Type='Events'");
            $rowAdvance = mysqli_fetch_assoc($getAdvancePercentage);
            $advancePercentageValue = $rowAdvance['Advance_Percentage'];
            if (mysqli_num_rows($excecuteEventDetails) > 0) {
                while ($row = mysqli_fetch_assoc($excecuteEventDetails)) {
                    $mealPackage = $row["MealPackage_ID"];
                    $noGuests = $row["Num_Guests"];
                    $mealPrice = 0;
                    $getPackagePrice = mysqli_query($con, "SELECT * from events_meals_packages WHERE Package_ID='$mealPackage' ");
                    while ($rowPrice = mysqli_fetch_assoc($getPackagePrice)) {
                        $mealPrice = $rowPrice["price"];
                    }
                    $totalMealPrice = $mealPrice * $noGuests;
                    $locationPrice = $row["Location_Price"];
                    $totalAmountBooking = $row["Location_Price"] + $totalMealPrice + $row["Feature_Price"];
                    $advancePrice = ($totalAmountBooking * $advancePercentageValue) / 100;

                    echo '
                            <div style="position: absolute;width:650px;height:680px;background-color:white">
                                <input type="hidden" name="merchant_id" value="1215666"> <!-- Replace your Merchant ID -->
                                <input type="hidden" name="return_url" value="http://localhost/GRAND-AND-EPIC/src/Hotel_Website/payment-thanks.php?type=events&id=' . $row["Events_ID"] . '">
                                <input type="hidden" name="cancel_url" value="abc.php">
                                <input type="hidden" name="notify_url" value="abc.php">
                                <input type="hidden" name="country" value="Sri Lanka">
                                <input type="hidden" name="order_id" value=' . $row["Events_ID"] . '>
                                <input type="hidden" name="items" value=' . $row["Event_Type"] . '><br>
                                <input type="hidden" name="currency" value="LKR">
                                <input type="hidden" name="amount" value=' . $advancePrice . '>
                                <!-- <br><br>Customer Details<br> -->
                                <input type="hidden" name="first_name" value=' . $row["Customer_Name"] . '>
                                <input type="hidden" name="last_name" value="Perera"><br>
                                <input type="hidden" name="email" value=' . $row["Customer_Email"] . '>
                                <input type="hidden" name="phone" value="0771234567"><br>
                                <input type="hidden" name="address" value="No.1, Galle Road">
                                <input type="hidden" name="city" value="Colombo">
                                <i class="fas fa-times-circle" style="position:absolute;top:5%;right:8%;color:black;font-size:25px;cursor:pointer;color:white;width:20px;height:40px;color:black" onclick="closePayments()"></i>
                                <u>
                                    <h2 style="text-align: center;font-weight:bolder;font-size:33px;color:black;margin-top:-20px">Payment Details</h3>
                                </u>
                                <h3 style="position: absolute;top:10%;left:65%;font-size:30px">Amount</h3>
                                <div class="location-payment" style="margin-left:40px;margin-top:70px">
                                    <u>
                                        <h3>Price For the Location</h3>
                                    </u>
                    
                                    <h3 style="margin-left:20px;margin-top:30px">From ' . $row['Starting_Time'] . ' to ' . $row['Ending_Time'] . '</h4>
                                        <h4 style="position:absolute;top:25%;left:65%;">Rs.' . $locationPrice . ' /=</h4>
                                        <h3 style="margin-left:20px;margin-top:10px">Additional Features</h3>
                                        <h4 style="position: absolute;top:32%;left:65%;">Rs.' . $row['Feature_Price'] . ' /=</h4>
                                </div>
                                <div class="location-payment" style="margin-left:40px;margin-top:40px">
                                    <u>
                                        <h3>Price For the Meals</h3>
                                    </u>
                                    <h3 style="margin-left:20px;margin-top:30px">Total Amount for meals</h3>
                                    <h4 style="position: absolute;top:48%;left:65%;">Rs.' . $totalMealPrice . ' /=</h4>
                                </div>
                    
                                <div class="location-payment" style="margin-left:40px;margin-top:40px">
                                    <u>
                                        <h3>Total Amount</h3>
                                    </u>
                                    <h3 style="margin-left:20px;margin-top:30px">Total Amount for Booking</h3>
                                    <h4 style="position: absolute;top:63%;left:65%;font-size:25px;">Rs.' . $totalAmountBooking . ' /=</h4>
                                </div>
                                <div class="location-payment" style="margin-left:40px;margin-top:40px">
                                    <u>
                                        <h3>Advance Amount</h3>
                                    </u>
                                    <h3 style="margin-left:20px;margin-top:20px">Total Amount for Booking *' . $advancePercentageValue . '</h3>
                                    <h4 style="position: absolute;top:76.5%;left:65%;font-size:28px">Rs. ' . $advancePrice . ' /=</h4>
                                </div>
                                <div style="margin-left:160px;margin-top:5px">
                                    <input type="reset" value="Cancel" name="Cancel-btn" style="color: #f0f0f0;background-color: goldenrod;border: none;padding: 10px;text-align: center;width: 110px;cursor:pointer;margin-top:10px">
                                    <input type="submit" name="paymet" value="Book-Now" style=" color: #f0f0f0;background-color: goldenrod;border: none;padding: 10px;text-align: center;width: 110px;margin-left:30px;cursor:pointer;margin-top:10px">
                                </div>';
                }
            }
            ?>


        </div>
        </div>
    </form>

    <script>
        function showMeals() {
            document.getElementById('mealCart').style.display = 'flex';
        }

        function closeFoodCart() {
            document.getElementById('mealCart').style.display = 'none';
        }

        function showPayments() {
            document.getElementById('payments').style.display = 'flex';
        }

        function closePayments() {
            document.getElementById('payments').style.display = 'none';
        }
    </script>
</body>

</html>
<!--  -->