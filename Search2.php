<html>
<head>
<title> Search Me!</title>
</head>
<body>

What would you like to search for?

<form action="" method="post">
	<input type="text" name="keyword">
	<input type="submit" type="submit">
</form>

<?php
if(!empty($_POST))
{
$keyword= $_POST['keyword'];
echo $keyword;
}
search($keyword);
function search($param)
{
$servername="localhost";
$username="root";
$pass="";
$database="demo";
  $con = new mysqli($servername, $username, $pass, $database);
  if($con->connect_error || mysqli_connect_error())
{
	echo"DIDNT CONNECT";
    die("Connection Failed: ".$con->connect_error());
}


	$query5 = "Select * from Eatery_Type inner join Eateries on Eateries.Type=Eatery_Type.ID inner join Eatery_Owners on Eateries.Owner=Eatery_Owners.ID
	where Eatery_Type.Type_Name = '$param' or Eateries.Name='$param' or Eateries.City='$param' or Eateries.State='$param' or Eateries.Zip='$param'
	 or Eatery_Owners.Last_Name='$param' or Eatery_Owners.First_Name='$param' or Eatery_Owners.Phone='$param'";

	$result5 = $con -> query($query5);

	if($result5->num_rows > 0)
	{
		while ($row5 = $result5->fetch_assoc()) {
			echo "<ul>
							<li>".$row5['Name'].": ".$row5['Type_Name']."</li>
							<ul>
								<li> Owned2 by: ".$row5['First_Name']." "
									.$row5['Last_Name']." | Phone: ".$row5['Phone']
								."</li>
								<li> Located in: ".$row5['City'].", ".$row5['State']
									." ".$row5['Zip']
									."</li>
								</ul>
							</ul>";
		}
	}
  else
  {
    echo "<br> Please check spelling and try again";
  }
}
?>



</body>
</html>
