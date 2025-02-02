<?php
$temp_id = $_GET['temp_id'];
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
        $meal_array_id = array_column($_SESSION["meal_cart"], 'meal_id');
        if (!in_array($_POST["Meal_ID"], $meal_array_id)) {
            $count = count($_SESSION['meal_cart']);
            $meals_array = array(
                'meal_id' => (int) $_POST["Meal_ID"],
                'meal_name' => $_POST["Meal_Name"],
                'meal_price' => $_POST["Meal_Price"] * $_POST["Meal_Quantity"],
                'meal_type' => $_POST["Meal_Type"],
                'quantity' => $_POST["Meal_Quantity"]
            );
            $_SESSION['meal_cart'][$count] = $meals_array;
        } else {
            echo '<script>alert("Meal has been already added")
                  window.location.href="stayingin-meals.php?temp_id="' . $_GET['temp_id'] . '</script>
                ';
        }
    }
}
if (isset($_GET["action"])) {
    if ($_GET["action"] == 'Delete') {
        foreach ($_SESSION['meal_cart'] as $keys => $values) {
            if ($values["meal_id"] == $_GET["remove_id"]) {
                unset($_SESSION['meal_cart'][$keys]);

                echo '<script>alert("Prduct has been removed")
                              window.location.href="stayingin-meals.php?temp_id=' . $_GET['temp_id'] . '"</script>';
            }
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
            height: "1000px";
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

        <?php
        include('../../config/connection.php');
        $selectMealType = mysqli_query($con, "SELECT * FROM stayingin_booking_temp WHERE StayingIn_ID='" . $temp_id . "'");
        $rowMealType = mysqli_fetch_assoc($selectMealType);
        if ($rowMealType['Reservation_Type'] == 'Full-Board') {
        ?>
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
                                <form action="" method="POST">
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
                    while ($rowLunch = mysqli_fetch_assoc($selectBreakfastFood)) {
                        echo '<div class="set-menu-meals-card" style="position:relative">
                        <form action="" method="POST">
                            <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowLunch["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                            <input type="hidden" name="Meal_ID" value="' . $rowLunch["Meals_ID"] . '">
                            <input type="hidden" name="Meal_Type" value="' . $rowLunch["Meal_Type"] . '">
                            <input type="hidden" name="Meal_Price" value="' . $rowLunch["Price"] . '">
                            <input type="hidden" name="Meal_Name" value="' . $rowLunch["Meals_Name"] . '">
                            <input type="hidden" name="Meal_Price" value="' . $rowLunch["Price"] . '">
                            <div class="set-menu-card-text">' . $rowLunch["Meals_Name"] . '<br><span style="position:absolute;top:215px;font-weight:bolder;left:50px">LKR ' . $rowLunch["Price"] . '.00<span style="font-size:10px">(Price per plate)</span></span>
                                <div class="add-to-cart"><input type="submit" name="Add-to-cart" value="Add to Cart" style="position:absolute;background-color:green;color:white;padding:10px;border:none;border-radius:5px;bottom:10px;left:120px">
                                <input type="number min="1" max="10" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity" required> </div>
                            </div>
                        </form>
                    </div>';
                    }
                }


                ?>
            </div>

            <div class="meal-selection" id="dinner-meal" style="display: none;grid-template-columns:100px 100px 100px 100px;column-gap:250px">
                <?php
                include('../../config/connection.php');
                $mealType = "Dinner";
                $selectDinner = mysqli_query($con, "SELECT * FROM meals WHERE Meal_Type='$mealType'");
                if (mysqli_num_rows($selectDinner) > 0) {
                    while ($rowDinner = mysqli_fetch_assoc($selectDinner)) {
                        echo '<div class="set-menu-meals-card" style="position:relative">
                        <form action="" method="POST">
                            <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowDinner["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                            <input type="hidden" name="Meal_ID" value="' . $rowDinner["Meals_ID"] . '">
                            <input type="hidden" name="Meal_Type" value="' . $rowDinner["Meal_Type"] . '">
                            <input type="hidden" name="Meal_Price" value="' . $rowDinner["Price"] . '">
                            <input type="hidden" name="Meal_Name" value="' . $rowDinner["Meals_Name"] . '">
                            <input type="hidden" name="Meal_Price" value="' . $rowDinner["Price"] . '">
                            <div class="set-menu-card-text">' . $rowDinner["Meals_Name"] . '<br><span style="position:absolute;top:215px;font-weight:bolder;left:50px">LKR ' . $rowDinner["Price"] . '.00<span style="font-size:10px">(Price per plate)</span></span>
                                <div class="add-to-cart"><input type="submit" name="Add-to-cart" value="Add to Cart" style="position:absolute;background-color:green;color:white;padding:10px;border:none;border-radius:5px;bottom:10px;left:120px">
                                <input type="number min="1" max="10" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity" required> </div>
                            </div>
                        </form>
                    </div>';
                    }
                }
                ?>
            </div>
        <?php } else if ($rowMealType['Reservation_Type'] == 'Half-Board') { ?>

            <div class="meal-type-selector">
                <h4 id="meal-header-breakfast" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;color:white;cursor:pointer" onclick="showBreakfastHBFood()">Breakfast</h4>
                <hr>
                <h4 id="meal-header-dinner" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;cursor:pointer" onclick="showDinnerHBFood()">Dinner</h4>
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
                                <form action="" method="POST">
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
            <div class="meal-selection" id="dinner-meal" style="display: none;grid-template-columns:100px 100px 100px 100px;column-gap:250px">
                <?php
                include('../../config/connection.php');
                $mealType = "Dinner";
                $selectDinner = mysqli_query($con, "SELECT * FROM meals WHERE Meal_Type='$mealType'");
                if (mysqli_num_rows($selectDinner) > 0) {
                    while ($rowDinnerHB = mysqli_fetch_assoc($selectDinner)) {
                        echo '<div class="set-menu-meals-card" style="position:relative">
                                    <form action="" method="POST">
                                        <div class="set-menu-card-image"><img src="data:image;base64,' . base64_encode($rowDinnerHB["Meal_Image"]) . '" style="border-radius:10px 10px 0px 0px;height:163.5px;width:100%" alt=""></div>
                                        <input type="hidden" name="Meal_ID" value="' . $rowDinnerHB["Meals_ID"] . '">
                                        <input type="hidden" name="Meal_Type" value="' . $rowDinnerHB["Meal_Type"] . '">
                                        <input type="hidden" name="Meal_Price" value="' . $rowDinnerHB["Price"] . '">
                                        <input type="hidden" name="Meal_Name" value="' . $rowDinnerHB["Meals_Name"] . '">
                                        <input type="hidden" name="Meal_Price" value="' . $rowDinnerHB["Price"] . '">
                                        <div class="set-menu-card-text">' . $rowDinnerHB["Meals_Name"] . '<br><span style="position:absolute;top:215px;font-weight:bolder;left:50px">LKR ' . $rowDinnerHB["Price"] . '.00<span style="font-size:10px">(Price per plate)</span></span>
                                            <div class="add-to-cart"><input type="submit" name="Add-to-cart" value="Add to Cart" style="position:absolute;background-color:green;color:white;padding:10px;border:none;border-radius:5px;bottom:10px;left:120px">
                                            <input type="number min="1" max="10" name="Meal_Quantity" style="position:absolute;background-color:black;color:white;padding:2px;border:none;border-radius:5px;bottom:10px;left:20px;width:80px;padding:10px" placeholder="quantity" required> </div>
                                        </div>
                                    </form>
                                </div>';
                    }
                }
                ?>
            </div>
        <?php } else { ?>
            <div class="meal-type-selector" style="width: 250px;">
                <h4 id="meal-header-breakfast" style="margin-right: 20px;font-size: 25px;width: 1810px;margin-left:10px;color:white;cursor:pointer" onclick="showBreakfastFood()">Breakfast</h4>
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
                                <form action="" method="POST">
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

        <?php } ?>


    </div>

    <div class="view-items-cart" style="position: absolute;top:140px;right:20px;background-color:green;padding:10px;border-radius:10px;width:110px;height:40px;cursor:pointer;" onclick="openCart()"><span style="font-size:15px;color:white;">View Cart</span><i class="fas fa-shopping-cart" style="color:white;position:absolute;right:10px;"></i></div>
    <div class="bg-modal">
        <div class="modal-content-meal-selection-stayingin" style="display: none;" id="payment-shower">
            <div class="close">+</div>
            <h1 style="font-size:22px;text-align:center;margin-right:8px;margin-top:5px;margin-bottom:10px">Meal Cart</h1>
            <tbody>
                <?php
                if (!empty($_SESSION['meal_cart'])) {
                    echo '<table style="border:1px solid black;margin-top:20px;margin-left:40px;border-radis:5px">
                            <thead>
                                <tr>
                                    <th style="border:1px solid black;padding:5px">Meal Name</th>
                                    <th style="border:1px solid black;padding:5px">Quantity</th>
                                    <th style="border:1px solid black;padding:5px">Meal Price</th>
                                    <th style="border:1px solid black;">Remove</th>
                                </tr>
                            </thead>';
                    $total = 0;
                    foreach ($_SESSION['meal_cart'] as $keys => $values) {
                        $total += $values["meal_price"];
                        echo '<tr style="border:1px solid black;">
                                
                                <td style="font-size: 10px;font-weight:bolder;border:1px solid black;padding:5px">' . $values["meal_name"] . '</span>
                                <td style="font-size: 10px;font-weight:bolder;border:1px solid black;padding:5px">' . $values["quantity"] . '</span>
                                <td style="font-size: 10px;font-weight:bolder;border:1px solid black;padding:5px">' . $values["meal_price"] . '</span>
                                <td style="border:1px solid black;padding:5px"><a href="stayingin-meals.php?action=Delete&remove_id=' . $values['meal_id'] . '&temp_id=' . $temp_id . '"><span style="font-weight: bolder;font-size:15px;padding:1px 2px;border:1px solid black;cursor:pointer;background-color:green;color:white;">-</span></td>
                                     </tr>';
                    };
                    echo '</table><br><br><span style="font-weight:bold;font-size:20px">Total Price For Meal is Rs.' . $total . '.00/=';
                } else {
                    echo '
        
                        <span style="font-size: 25px;font-weight:bolder;margin-top:100px">Currently No Meals has been added</span>
                    </div>';
                }
                ?>
            </tbody>
            </table>
        </div>
    </div>
    <form action="suite-insert.php" method="POST">
        <div class="button-container-suite-form" style="margin-top:20px;margin-left:30%;">
            <input type="hidden" name="total_price" value="<?php echo $total ?>">
            <input type="hidden" name="temp_id" value="<?php echo $temp_id ?>">
            <input type="submit" value="Next" name="user-meals" id="user-payment-details" style="padding:10px;color:white;background-color: goldenrod;border:none;width:170px;height:60px;font-size:22px;cursor:pointer;margin-top:20px;" onclick="userMealPayment()">
        </div>
    </form>

</body>
<script>
    //to open the items which were added to the cart
    function openCart() {
        document.querySelector('.bg-modal').style.display = "flex";
        document.getElementById('payment-shower').style.display = 'block';

    }

    //to close the view cart 
    document.querySelector(".close").addEventListener("click", function() {
        document.getElementById("payment-shower").style.display = "none";
        document.querySelector('.bg-modal').style.display = "none";


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
    //to show the breakfast food
    function showBreakfastHBFood() {
        document.getElementById("breakfast-meal").style.display = "grid";
        document.getElementById("dinner-meal").style.display = "none";

        //to change the header color of Breakfast
        document.getElementById("meal-header-breakfast").style.color = "white"
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
    //to show the Dinner food
    function showDinnerHBFood() {
        document.getElementById("breakfast-meal").style.display = "none";
        document.getElementById("dinner-meal").style.display = "grid";

        //to change the header color of Breakfast
        document.getElementById("meal-header-breakfast").style.color = "black"
        document.getElementById("meal-header-dinner").style.color = "white"
    }
</script>


</html>