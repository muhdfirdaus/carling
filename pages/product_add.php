<?php 
session_start();
$branch=$_SESSION['branch'];
include('../dist/includes/dbcon.php');

	$equip_name = str_replace(',', ' ', $_POST['equip_name']);
	$equip_no = str_replace(',', ' ', $_POST['equip_no']);
	$model = str_replace(',', ' ', $_POST['model']);
	$accuracy=str_replace(',', ' ', $_POST['accuracy']);
	$manufacturer = $_POST['manufacturer'];
	$accuracy = str_replace(',', ' ', $_POST['accuracy']);
	$rangee = str_replace(',', ' ', $_POST['rangee']);
	$location = $_POST['location'];
	$category=$_POST['category'];
	$dept=$_POST['dept'];
	$certno=str_replace(',', ' ', $_POST['cert_no']);
	$creation = $_POST['creation_date'];
	$ddate = $_POST['due_date'];
	$remark=$_POST['remark'];
	$validation=$_POST['validation'];
	$project=str_replace(',', ' ', $_POST['project']);

	// file uploading starts here******************************************
	$target_dir = "../uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	$fileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
	$filename = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_FILENAME);
	$FileType = strtolower($fileType);
	$uploadOk = 1;
	$extmsg = "";
	$stopDB = false;

	if($FileType != "pdf"){
		echo "<script type='text/javascript'>alert('Wrong format file selected! Only PDF is allowed.');</script>";
		echo "<script>window.history.back();</script>"; 
		$stopDB = true; 
	}
	
	if(strlen($filename)<1){
		$uploadOk = 0;
	}
	
	// //if want to change file name, use this one instead
	// $target_file2 = $target_dir . time() .".". $fileType;

	// Check if file already exists
	if (file_exists($target_file)) {
		echo "<script type='text/javascript'>alert('Selected file already existed!');</script>";
		echo "<script>window.history.back();</script>";
		$stopDB = true; 
	}

	if($uploadOk==1){
		if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
			//
		} else {
			$extmsg .= "<br>Sorry, there was an error uploading your file.";
			$filename = 'NULL';
		}
	}
	else{
		$filename = 'NULL';
	}

	// *****************************************file uploading stops here
	if($stopDB != true){
		$query2=mysqli_query($con,"select * from product where equip_no='$equip_no' and branch_id='$branch'")or die(mysqli_error($con));
		$count=mysqli_num_rows($query2);

		if ($count>0)
		{
			echo "<script type='text/javascript'>alert('Equipment with that Serial Number already exist!');</script>";
			echo "<script>document.location='product.php'</script>";  
		}
		else
		{	
			mysqli_query($con,"INSERT INTO product(equip_no,equip_name,model,accuracy,manufacturer,rangee,location,branch_id,category,dept,cert_no,creation_date,due_date,remark,validation, project, file_name)
			VALUES('$equip_no','$equip_name','$model','$accuracy','$manufacturer','$rangee','$location','$branch','$category','$dept','$certno','$creation','$ddate','$remark','$validation', '$project', '$filename')")or die(mysqli_error($con));

			echo "<script type='text/javascript'>alert('Successfully added new product!');</script>";
			echo "<script>document.location='product.php'</script>";  
		}
	}
?>