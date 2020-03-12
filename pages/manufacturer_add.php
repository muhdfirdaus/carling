<?php 

include('../dist/includes/dbcon.php');

	$manufacturer = $_POST['manufacturer'];
	
	$query2=mysqli_query($con,"select * from manufacturer where manufacturer_name='$manufacturer'")or die(mysqli_error($con));
		$count=mysqli_num_rows($query2);

		if ($count>0)
		{
			echo "<script type='text/javascript'>alert('Manufacturer already exist!');</script>";
			echo "<script>document.location='manufacturer.php'</script>";  
		}
		else
		{			
			mysqli_query($con,"INSERT INTO manufacturer(manufacturer_name) VALUES('$manufacturer')")or die(mysqli_error($con));

			echo "<script type='text/javascript'>alert('Successfully added new manufacturer!');</script>";
					  echo "<script>document.location='manufacturer.php'</script>";  
		}
?>