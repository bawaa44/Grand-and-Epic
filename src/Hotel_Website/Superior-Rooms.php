<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Superior Rooms</title>
    <link rel="stylesheet" href="../Css/style.css">
    <script src="https://kit.fontawesome.com/1d5f2c83e1.js" crossorigin="anonymous"></script>
</head>

<body>
    <div class="page-wrapper">
        <div class="header-container-SuperiorRooms" id="header-container">
            <?php include("sticky-nav.php"); ?>
            <?php include("side-nav.php"); ?>
            <div class="text-container">
                <span class="text1">Grand &</span>
                <span class="text2">Epic
                </span>
            </div>
            <?php include('login-signup-template.php'); ?>
        </div>
        <div class="body-container Superior-Rooms">
            <div class="superior-rooms-wrapper">
                <h3>Superior Rooms</h3>
                <div class="superior-room-content">
                    <p>Grand & Epic provide you joy & In the heart of historic Sigiriya, accommodation of the most indulgent kind awaits you at our Superior Rooms. Set in the Dambulla Wing you can relax in the comforts they offer and enjoy views either of the Sigiriya Rock or the lush jungle, and the Dambulla Rock in the distance. After a day of exploring – or even just idling, it is a perfect refuge to return to a long shower.</p>
                </div>
                <button class="book" style="color:black;background-color:goldenrod"><a href="">Book Now</a></button>
            </div>

            <div class="room-container">
                <div class="image-container">
                    <img src="../Images/sup-centara-ceysands-resort.jpg" alt="Superior-Room Image">
                </div>
                <div class="room-details">
                    <h2 style="color:white;font-size:28px">Room-Details</h2>
                    <div class="room-details-wrapper">
                        <div class="grid-room-container"><i class="fa fa-list-ol" aria-hidden="true"><span class="room-detail">Number of Rooms</span><br><span class="Superior-values">23</span></i></div>
                        <div class="grid-room-container"><i class="fa fa-users" aria-hidden="true"><span class="room-detail">Occupancy</span><br><span class="Superior-values">Double or Triple</span></i></div>
                        <div class="grid-room-container"><i class="fas fa-sort-amount-down"><span class="room-detail">Room Size</span><br><span class="Superior-values">229.93 SQ.FT</span></i></div>
                        <div class="grid-room-container"><i class="fas fa-bed"><span class="room-detail">Beds</span><br><span class="Superior-values">King Bed or Twin Bed</span></i></div>
                        <div class="grid-room-container"><i class="fas fa-binoculars"><span class="room-detail">Room View</span><br><span class="Superior-values">Garden View</span></i></div>
                        <div class="grid-room-container"><i class="fas fa-dollar-sign"><span class="room-detail">Prices</span><br><span class="Superior-values">1 Triple Room:$200.00/=</span><br><span class="Superior-values">1 Double Room:$100.00/=</span></i></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include("footer-footer.php"); ?>
    <script src="../Javascript/script.js"></script>
    <script src="../Javascript/sticky-nav.js"></script>
</body>

</html>