<?php 

include('../dist/includes/dbcon.php');

	$location = $_POST['location'];
	
	$query2=mysqli_query($con,"select * from location where location_name='$location'")or die(mysqli_error($con));
		$count=mysqli_num_rows($query2);

		if ($count>0)
		{
			echo "<script type='text/javascript'>alert('Location already exist!');</script>";
			echo "<script>document.location='location.php'</script>";  
		}
		else
		{			
			mysqli_query($con,"INSERT INTO location(location_name) VALUES('$location')")or die(mysqli_error($con));

			echo "<script type='text/javascript'>alert('Successfully added new location!');</script>";
					  echo "<script>document.location='location.php'</script>";  
		}
?>