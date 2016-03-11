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
$pass="password";
$database="demo";

  $con = new mysqli($servername, $username, $pass, $database);

  if($con->connect_error || mysqli_connect_error())
{
	echo"DIDNT CONNECT";
    die("Connection Failed: ".$con->connect_error());
}


  $query1 = "SELECT * from  Eateries WHERE Name = '$param' OR City = '$param' OR State = '$param' OR Zip ='$param'";

  $query2 = "SELECT * from Eatery_Type WHERE Type_Name = '$param'";

  $query3 = "SELECT * from Eatery_Owners WHERE First_Name = '$param' OR Last_Name = '$param' OR Phone = '$param'";

  $result1 = $con->query($query1);
  $result2 = $con -> query($query2);
  $result3 = $con -> query($query3);
 



  if($result1->num_rows > 0)
  {
    while( $row = $result1->fetch_assoc())
    {
      $query2 = "SELECT Type_Name FROM Eatery_Type WHERE ID = $row[Type]";
      $query3 = "SELECT First_Name, Last_Name, Phone FROM Eatery_Owners  WHERE ID = $row[Owner]";

      $result2 = $con->query($query2);
      $result3 = $con->query($query3);

      echo "<ul>
              <li>".$row['Name'].": ";

      if($result2->num_rows > 0)
      {
        while( $row2 = $result2->fetch_assoc())
        {
          echo $row2['Type_Name'];
        }
      }

      echo "</li>
                <ul>
                  <li> Owned by: ";

      if($result3->num_rows > 0)
      {
        while( $row3 = $result3->fetch_assoc())
        {
            echo $row3['First_Name']." ".$row3['Last_Name']." | Phone:".$row3['Phone'];
        }
      }

      echo "</li>
            <li> Located in: ".$row['City'].", ".$row['State']." ".$row['Zip'].
            "</li>
            </ul>
          </ul>";
    }
  }
  else if($result2->num_rows > 0)
  {
      while( $row2 = $result2->fetch_assoc())
      {
        $query1 = "SELECT * from Eateries WHERE Type=$row2[ID]";
        $result1 = $con->query($query1);

        if($result1->num_rows > 0)
        {
          while( $row1 = $result1->fetch_assoc())
          {
              $query3 = "SELECT * from Eatery_Owners WHERE ID=$row1[Owner]";
              $result3 = $con->query($query3);

              if($result3->num_rows > 0)
              {
                while( $row3 = $result3->fetch_assoc())
                {
                  echo "<ul>
                          <li>".$row1['Name'].": ".$row2['Type_Name']."</li>
                          <ul>
                            <li> Ownerd by: ".$row3['First_Name']." "
                              .$row3['Last_Name']." | Phone: ".$row3['Phone']
                            ."</li>
                            <li> Located in: ".$row1['City'].", ".$row1['State']
                              ." ".$row1['Zip']
                              ."</li>
                            </ul>
                          </ul>";
                }
              }
          }
        }
      }
  }
  else if($result3->num_rows > 0)
  {
    while( $row3 = $result3->fetch_assoc())
    {
      $query1 = "SELECT * from Eateries WHERE Owner=$row3[ID]";
      $result1 = $con->query($query1);

      if($result1->num_rows > 0)
      {
        while( $row1 = $result1->fetch_assoc())
        {
            $query2 = "SELECT * from Eatery_Type WHERE ID=$row1[Type]";
            $result2 = $con->query($query2);

            if($result2->num_rows > 0)
            {
              while( $row2 = $result2->fetch_assoc())
              {
                echo "<ul>
                        <li>".$row1['Name'].": ".$row2['Type_Name']."</li>
                        <ul>
                          <li> Owned by: ".$row3['First_Name']." ".$row3['Last_Name']." | Phone: ".$row3['Phone']
                          ."</li>
                          <li> Located in: ".$row1['City'].", ".$row1['State']
                            ." ".$row1['Zip']
                            ."</li>
                          </ul>
                        </ul>";
              }
            }
        }
      }
    }
  }
  else
  {
    echo "Please check spelling and try again";
  }




}


?>



</body>
</html>
