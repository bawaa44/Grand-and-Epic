<?php include("../../config/connection.php");
if(isset($_POST['ADD'])){
    
    $empID=$_POST['empID'];
    $empFname=$_POST['empFname'];
    $empSname=$_POST['empSname'];
    $empEmail=$_POST['empEmail'];    
    $password=sha1($_POST['password']);    
    $empContact=$_POST['empContact'];
    $empType=$_POST['empType'];

    $sql="INSERT into employee(Employee_ID,First_Name,Last_Name,Email,Password,Contact_No,User_Role) VALUES ('".$empID."','".$empFname."','".$empSname."','".$empEmail."','".$password."','".$empContact."','".$empType."')";
    $query_run = mysqli_query($con,$sql);

    if ($query_run) {
		echo "<script>
		alert('New Employee Has been Added');
		window.location.href='HotelManagerManageStaff.php';
		</script>";
	} else {
		echo '<script> alert("Data Not Added") </script>';
	}
}
?>  

