<?php
include("../../config/connection.php");
session_start();
if (isset($_POST['Add-to-cart'])) {
    $meals_array = array();
    if (!isset($_SESSION["meal_cart"])) {
        $meals_array = array(
            'meal_id' => (int) $_POST["Meal_ID"],
            'meal_name' => $_POST["Meal_Name"],
            'meal_price' => $_POST["Meal_Price"] * $_POST["Meal_Quantity"],
            'meal_type' => $_POST["Meal_Type"],
            'quantity' => $_POST["Meal_Quantity"]
        );
        $_SESSION["meal_cart"][0] = $meals_array;
    } else {
        if (!in_array($_POST["Meal_ID"], $meals_array)) {
            $meal_id = array_column($_SESSION["meal_cart"], 'meal_id');
            $count = count($_SESSION['meal_cart']);
            $meals_array = array(
                'meal_id' => (int) $_POST["Meal_ID"],
                'meal_name' => $_POST["Meal_Name"],
                'meal_price' => $_POST["Meal_Price"] * $_POST["Meal_Quantity"],
                'meal_type' => $_POST["Meal_Type"],
                'quantity' => $_POST["Meal_Quantity"]
            );
            $_SESSION['meal_cart'][$count] = $meals_array;
            echo var_dump($_SESSION["meal_cart"]);
            echo $count;
        } else {
            echo '<script>alert("Meal has been already added")</script>';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Meal Selection</title>
    <link rel="stylesheet" href="../../public/css/style.css">
    <style>
        body {
            background-image: url("../../public/images/suite-form-img.jpeg");
            background-repeat: no-repeat;
            background-size: cover;

        }
    </style>
</head>

<body>
    <div class=" suite-rooms-form-container detail-meals" id="form-page-mealuser">
        <div class="suite-form-header meals" id="suite-form-header">
            <h3>Room Details & Availability</h3>
            <h3 style="font-weight: bolder;color:black">Customized Meals</h3>
            <h3>User & Payment Details</h3>
        </div>

        <div class="meal-type-selector">
            <h4 id="meal-header-breakfast" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;color:white;cursor:pointer" onclick="showBreakfastFood()">Breakfast</h4>
            <hr>
            <h4 id="meal-header-lunch" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;cursor:pointer" onclick="showLunchFood()">Lunch</h4>
            <hr>
            <h4 id="meal-header-dinner" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;cursor:pointer" onclick="showDinnerFood()">Dinner</h4>
        </div>
        <div class="meal-selection" id="breakfast-meal" style="display: grid;grid-template-columns:100px 100px 100px 100px;column-gap:250px">
            <?php
            include('../../config/connection.php');
            $mealType = "Breakfast";
            $selectBreakfastFood = mysqli_query($con, "SELECT * FROM meals WHERE Meal_Type='$mealType'");
            if (mysqli_num_rows($selectBreakfastFood) > 0) {
                while ($rowBreakfast = mysqli_fetch_assoc($selectBreakfastFood)) {
                    echo '
                            <div class="set-menu-meals-card" style="position:relative">
                                <form action="stayingin-meals.php" method="POST">
                                    <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowBreakfast["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                                    <input type="hidden" name="Meal_ID" value="' . $rowBreakfast["Meals_ID"] . '">
                                    <input type="hidden" name="Meal_Type" value="' . $rowBreakfast["Meal_Type"] . '">
                                    <input type="hidden" name="Meal_Price" value="' . $rowBreakfast["Price"] . '">
                                    <input type="hidden" name="Meal_Name" value="' . $rowBreakfast["Meals_Name"] . '">
                                    <input type="hidden" name="Meal_Price" value="' . $rowBreakfast["Price"] . '">
                                    <div class="set-menu-card-text">' . $rowBreakfast["Meals_Name"] . '<br><span style="position:absolute;top:215px;font-weight:bolder;left:50px">LKR ' . $rowBreakfast["Price"] . '.00<span style="font-size:10px">(Price per plate)</span></span>
                                        <div class="add-to-cart"><input type="submit" name="Add-to-cart" value="Add to Cart" style="position:absolute;background-color:green;color:white;padding:10px;border:none;border-radius:5px;bottom:10px;left:120px">
                                        <input type="number min="1" max="10" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity" required> </div>
                                    </div>
                                </form>
                            </div>
                           ';
                }
            }


            ?>
        </div>
        <div class="meal-selection" id="lunch-meal" style="display:none;grid-template-columns:100px 100px 100px 100px;column-gap:250px">
            <?php
            include('../../config/connection.php');
            $mealType = "Lunch";
            $selectBreakfastFood = mysqli_query($con, "SELECT * FROM meals WHERE Meal_Type='$mealType'");
            if (mysqli_num_rows($selectBreakfastFood) > 0) {
                while ($rowBreakfast = mysqli_fetch_assoc($selectBreakfastFood)) {
                    echo '<form action="" method="POST">
                            <div class="set-menu-meals-card">
                                <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowBreakfast["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                                <input type="hidden" name="Meal_Type" value="' . $rowBreakfast["Meal_Type"] . '">
                                <div class="set-menu-card-text">' . $rowBreakfast["Meals_Name"] . '<span style="display: inline-block;font-weight:bolder;">LKR ' . $rowBreakfast["Price"] . '.00</span>
                                    <div class="add-to-cart"><input type="submit" name="Add to cart" value="Add to Cart" style="background-color:green;color:white;padding:10px;border:none;border-radius:5px;margin-bottom:-4px;"></div>
                                    <input type="number" min="1" max="10" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity" required> </div>
                                </div>
                            </div>
                           </form>';
                }
            }


            ?>
        </div>
        <div class="meal-selection" id="dinner-meal" style="display: none;grid-template-columns:100px 100px 100px 100px;column-gap:250px">
            <?php
            include('../../config/connection.php');
            $mealType = "Dinner";
            $selectBreakfastFood = mysqli_query($con, "SELECT * FROM meals WHERE Meal_Type='$mealType'");
            if (mysqli_num_rows($selectBreakfastFood) > 0) {
                while ($rowBreakfast = mysqli_fetch_assoc($selectBreakfastFood)) {
                    echo '<form action="" method="POST">
                            <div class="set-menu-meals-card">
                                <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowBreakfast["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                                <input type="hidden" name="Meal_Type" value="' . $rowBreakfast["Meal_Type"] . '">
                                <div class="set-menu-card-text">' . $rowBreakfast["Meals_Name"] . '<span style="display: inline-block;font-weight:bolder;">LKR ' . $rowBreakfast["Price"] . '.00</span>
                                    <div class="add-to-cart"><input type="submit" name="Add to cart" value="Add to Cart" style="background-color:green;color:white;padding:10px;border:none;border-radius:5px;margin-bottom:-4px;"></div>
                                    <input type="number" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity"> </div>
                                </div>
                            </div>
                          </form>';
                }
            }


            ?>
        </div>
        <div class="view-items-cart" style="position: absolute;top:140px;right:20px;background-color:green;padding:10px;border-radius:10px;width:110px;height:40px;cursor:pointer;" onclick="openCart()"><span style="font-size:15px;color:white;">View Cart</span><i class="fas fa-shopping-cart" style="color:white;position:absolute;right:10px;"></i></div>
        <div class="payment-shower" style="display: none;" id="payment-shower">
            <div class="close">+</div>
            <h1 style="font-size:22px;text-align:center;margin-right:8px;margin-top:5px;">Meal Cart</h1>
            <?php
            if (!empty($_SESSION['meal_cart'])) {
                $total = 0;
                foreach ($_SESSION['meal_cart'] as $keys => $values) {
                    $total += $values["meal_price"];
                    echo '<div style="display: inline-block;padding:10px;border-radius:5px;margin-top:30px;border:1px solid black;margin-left:5px;margin-right:5px">
                        <span style="font-weight: bolder;font-size:20px;border:1px solid black;padding:5px;cursor:pointer;background-color:green;color:white;">-</span>
        
                        <span style="font-size: 10px;font-weight:bolder">' . $values["meal_name"] . '</span>
                        <span style="font-size: 10px;font-weight:bolder">' . $values["quantity"] . '</span>
                        <span style="font-size: 10px;font-weight:bolder">' . $values["meal_price"] . '</span>
                        <span style="font-weight: bolder;font-size:15px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">+</span>
                    </div>                  ';
                };
                echo '<span>Total Price For Meal is Rs.' . $total . '.00/=';
            } else {
                echo '<div style="display: inline-block;padding:10px;border-radius:5px;margin-top:30px;border:1px solid black;margin-left:5px;margin-right:5px">
                        <span style="font-weight: bolder;font-size:20px;border:1px solid black;padding:5px;cursor:pointer;background-color:green;color:white;">-</span>
        
                        <span style="font-size: 10px;font-weight:bolder">No Meals has been added</span>
                        <span style="font-weight: bolder;font-size:15px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">+</span>
                    </div>';
            }
            ?>
            <!-- <div style="display: inline-block;padding:10px;border-radius:5px;margin-top:15px;border:1px solid black;margin-left:5px;margin-right:5px">
                <span style="font-weight: bolder;font-size:20px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">-</span>
                <span style="font-size: 10px;font-weight:bolder">Noodles with Chicken Devilled curry 2 plates</span>
                <span style="font-weight: bolder;font-size:15px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">+</span>
            </div>
            <div style="display: inline-block;padding:10px;border-radius:5px;margin-top:15px;border:1px solid black;margin-left:5px;margin-right:5px">
                <span style="font-weight: bolder;font-size:20px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">-</span>
                <span style="font-size: 10px;font-weight:bolder">Pineapple Pudding</span>
                <span style="font-weight: bolder;font-size:15px;padding:5px;border:1px solid black;cursor:pointer;background-color:green;color:white;">+</span>
            </div> -->
        </div>
        <div style="width:100px;border-radius:5px; padding:8px;font-size:10px;background-color:green;color:white;border:none;position:absolute;top:140px;left:200px;padding:10px;border-radius:10px;width:200px;height:40px;font-size:15px;">Search Food<i class="fas fa-search" style="color: white;margin-left:10px;cursor:pointer;"></i></div>
        <div class="button-container-suite-form" style="margin-top:20px;margin-left:30%;">
            <input type="button" value="Back" id="room-details-availability" style="padding:10px;color:white;background-color: goldenrod;border:none;width:170px;height:60px;font-size:22px;cursor:pointer;margin-top:20px;margin-right:30px;" onclick="roomDetails()">
            <input type="button" value="Next" id="user-payment-details" style="padding:10px;color:white;background-color: goldenrod;border:none;width:170px;height:60px;font-size:22px;cursor:pointer;margin-top:20px;" onclick="userMealPayment()">
        </div>
    </div>

</body>
<script>
    //to open the items which were added to the cart
    function openCart() {
        document.getElementById('payment-shower').style.display = 'block';
    }

    //to close the view cart 
    document.querySelector(".close").addEventListener("click", function() {
        document.querySelector(".payment-shower").style.display = "none";
    });

    //to show the breakfast food
    function showBreakfastFood() {
        document.getElementById("breakfast-meal").style.display = "grid";
        document.getElementById("lunch-meal").style.display = "none";
        document.getElementById("dinner-meal").style.display = "none";

        //to change the header color of Breakfast
        document.getElementById("meal-header-breakfast").style.color = "white"
        document.getElementById("meal-header-lunch").style.color = "black"
        document.getElementById("meal-header-dinner").style.color = "black"

    }

    //to show the lunch food
    function showLunchFood() {
        document.getElementById("breakfast-meal").style.display = "none";
        document.getElementById("lunch-meal").style.display = "grid";
        document.getElementById("dinner-meal").style.display = "none";

        //to change the header color of Breakfast
        document.getElementById("meal-header-breakfast").style.color = "black"
        document.getElementById("meal-header-lunch").style.color = "white"
        document.getElementById("meal-header-dinner").style.color = "black"
    }

    //to show the Dinner food
    function showDinnerFood() {
        document.getElementById("breakfast-meal").style.display = "none";
        document.getElementById("lunch-meal").style.display = "none";
        document.getElementById("dinner-meal").style.display = "grid";

        //to change the header color of Breakfast
        document.getElementById("meal-header-breakfast").style.color = "black"
        document.getElementById("meal-header-lunch").style.color = "black"
        document.getElementById("meal-header-dinner").style.color = "white"
    }
</script>



</html>