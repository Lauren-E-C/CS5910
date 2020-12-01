<?php include_once 'academicCal.dbConnection.php';?>   <!-- connect the database -->
<?php error_reporting (E_ALL ^ E_NOTICE); ?> <!-- get rid of undefined index for GET -->

<!DOCTYPE html>
 <!-- web site navigation banner -->

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href="https://www.lakeroyaluniversity.com">

<html>
        <meta charset="utf-10">
        <title>Academic Calendar</title>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    
        </head> 

        <body style="font-family: Apple Chancery"> 
         
        <header>
            <nav class="navbar navbar-expand-sm bg-warning navbar-transparent fixed-top justify-content-left">

                <span class="navbar-brand" href ="lakeroyaluniversity.com">
                    <img src="LakeRoyal.png" alt="Logo" style="width:50px;"> 
                </span>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="index.html">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="academicCalendar.php">Academic Calender</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="searchMasterSchedule.php">Master Schedule</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link" href="viewCatalog.php">Course Catalog</a>
                    </li>
                    
                    <li class="nav-item" >
                        <a class="nav-link " href="login.php">Log In</a>
                    </li>
                </ul>
            </nav>
        
        </header> 
   <head>
      <meta charset = "utf-8">
      <title>Academic Calendar</title>
   </head>

   <body style="text-align:center">
        <div>
        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        </div>
   		<h1 style="text-align:center">Academic Calendar</h1>

        <div style="text-align:center">
          
            <!-- drop down -->
            <form action="" method="GET">
   					<select name="semester">
              <option value="select"selected>Select Term</option>
   						<option value="Spring 2021">Spring 2021</option>
   						<option value="Fall 2020">Fall 2020</option>
   						<option value="Spring 2020">Spring 2020</option>
   						<option value="Fall 2019">Fall 2019</option>
   						<option value="Spring 2019">Spring 2019</option>
   						<option value="Fall 2018">Fall 2018</option>
   						<option value="Spring 2018">Spring 2018</option>
   						<option value="Fall 2017">Fall 2017</option>
   					</select>

            <!-- submit button-->
            <input type="submit" value="Submit" />
            </form>
        </div>

    <br>
    <br>
    
    <div style="text-align:center">
    <table align="center" border="1px" style="width:600px; line-height:40px;">
      <tr>
          <th colspan="2"><h2><?php echo $selectedSem=$_GET['semester'];?> Calendar</h2></th>
      </tr>
      <t>
        <th>Date</th>
        <th>Event</th>
      </t>

    <?php
    $selectedSem=$_GET['semester'];
    
    //fall semester section
    if($selectedSem=='Fall 2020')
    {
      $sql= "Select * FROM fall;"; 
      $result=mysqli_query($conn, $sql);
      $resultCheck=mysqli_num_rows($result);

        if ($resultCheck>0)
        {
          while($row=mysqli_fetch_assoc($result))
          {
              echo "<tr>
              <td>".$row['date']."</td>
              <td>".$row['event']."</td>
              </tr>";
          }
        }
    }

    //spring semester
    else if ($selectedSem=='Spring 2021')
    {
      $sql= "Select * FROM spring;";
      $result=mysqli_query($conn, $sql);
      $resultCheck=mysqli_num_rows($result);

        if ($resultCheck>0)
        {
          while($row=mysqli_fetch_assoc($result))
          {
            echo "<tr>
              <td>".$row['date']."</td>
              <td>".$row['event']."</td>
              </tr>";
          }
        }
    }
    //no semester
    else
    {
      echo "Please select a term.";
    }

    ?>
    </div>
   </body>
</html>