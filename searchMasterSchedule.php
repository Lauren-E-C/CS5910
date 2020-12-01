<?php include_once 'MasterSchedule.dbConnection.php';?>   <!-- connect the database -->
<?php error_reporting (E_ALL ^ E_NOTICE); ?> <!-- get rid of undefined index for GET -->

<!DOCTYPE html>
 <!-- web site navigation banner -->

<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<base href="https://www.lakeroyaluniversity.com">

<html>
        <meta charset="utf-10">
        <title>Master Schedule</title>
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
      <title>Master Schedule</title>
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
   		<h1 style="text-align:center">Master Schedule</h1>

        <div style="text-align:center">
          
            <!-- drop down -->
            <form action="" method="GET">
   					<select name="semester">
              <option value="select"selected>Select Term</option>
   						<option value="MasterSchedule">Spring 2021</option>
   						<option value="Fall 2020">Fall 2020</option>
   						<option value="Spring 2020">Spring 2020</option>
   						<option value="Fall 2019">Fall 2019</option>
   						<option value="Spring 2019">Spring 2019</option>
   						<option value="Fall 2018">Fall 2018</option>
   						<option value="Spring 2018">Spring 2018</option>
   						<option value="Fall 2017">Fall 2017</option>
   						<option value="Spring 2017">Spring 2017</option>
   						<option value="Fall 2016">Fall 2016</option>
   						<option value="Spring 2016">Spring 2016</option>
   						<option value="Fall 2015">Fall 2015</option>
   						<option value="Spring 2015">Spring 2015</option>
   						<option value="Fall 2014">Fall 2014</option>
   						<option value="Spring 2014">Spring 2014</option>
   						<option value="Fall 2013">Fall 2013</option>
   						<option value="Spring 2013">Spring 2013</option>
   						<option value="Fall 2012">Fall 2012</option>
   						
   					</select>

            <!-- submit button-->
            <input type="submit" value="Submit" />
            </form>
        </div>

    <br>
    <br>
    
    <div style="text-align:center">
    <table align="center" border="1px" style="width:1200px; line-height:50px;">
      <tr>

      </tr>
      <t>
        <th>CRN</th>
        <th>Depart.</th>
        <th>Course ID</th>
        <th>Course Name</th>
        <th>Section</th>
        <th>Instructor</th>
        <th>Day</th>
        <th>Time</th>
        <th>Capacity</th>
        <th>Location</th>
        <th>Room Type</th>
        <th>Credits</th>
        <th>Level</th>
        <th>Prerequisites</th>
      </t>

    <?php
    $selectedSem=$_GET['semester'];
    
    //takes the selection from the drop down and shows results from the DB
    if ($selectedSem!=$_GET['select'])
    {
      $sql= "Select * FROM masterschedule;"; 
      $result=mysqli_query($conn, $sql);
      $resultCheck=mysqli_num_rows($result);

        if ($resultCheck>0)
        {
          while($row=mysqli_fetch_assoc($result))
          {
              echo "<tr>
              <td>".$row['crn']."</td>
              <td>".$row['department']."</td>
              <td>".$row['courseID']."</td>
              <td>".$row['coursename']."</td>
              <td>".$row['section']."</td>
              <td>".$row['instructor']."</td>
              <td>".$row['day']."</td>
              <td>".$row['timeslot']."</td>
              <td>".$row['capacity']."</td>
              <td>".$row['location']."</td>
              <td>".$row['roomtype']."</td>
              <td>".$row['credits']."</td>
              <td>".$row['level']."</td>
              <td>".$row['prerequisites']."</td>
              </tr>";
          }
        }
    }
    //no semester
    else
    {
      echo "Please Select a term.";
    }
    
        echo"";
    ?>

    </div>
   </body>
</html>