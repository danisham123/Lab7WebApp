<?php
require_once "pdo.php";
// Demand a GET parameter
if ( ! isset($_GET['name']) || strlen($_GET['name']) < 1  ) {
    die('Name parameter missing');
}

if ( isset($_POST['logout'] ) ) {
    // Redirect the browser to index.php
    header("Location: index.php");
    return;
}
$failure = false;
$success = false;

if (isset($_POST['mk'])&& isset($_POST['yr'])&& isset($_POST['mi'])){
  if ( strlen($_POST['mk']) < 1 ) {
      $failure = "Make is required";
  } else {
    if (is_numeric($_POST['yr']) || is_numeric($_POST['mi'])) {
      $sql = "INSERT INTO autos (make, year, mileage) VALUES ( :mk, :yr, :mi)";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
            ':mk' => $_POST['mk'],
            ':yr' => $_POST['yr'],
            ':mi' => $_POST['mi'])
          );
      $success = "Record inserted";

    }
    else{
      $failure = "Mileage and year must be numeric";
    }

  }
}
 ?>

 <!DOCTYPE html>
 <html>
 <head>
 <title>Danish 205647 LAB7</title>
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"
 integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
 <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css"
 integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">
 <link rel="stylesheet" href="style.css">

 </head>
 <body>
   <h1>Tracking Autos for</h1>
   <h2>UNIVERSITY PUTRA MALAYSIA</h2>

   <?php
   if ( $failure !== false ) {
       echo('<p style="color: red;">'.htmlentities($failure)."</p>\n");
   }

   if ($success !== false){
     echo('<p style="color: green;">'.htmlentities($success)."</p>\n");
   }

   ?>

   <form method="post">
     <label for="make">Make</label>
     <input type="text" name="mk" id="make"></br>
     <label for="year">Year</label>
     <input type="text" name="yr" id="year"></br>
     <label for="mileage">Mileage</label>
     <input type="text" name="mi" id="mileage"></br>
     <input type="submit" name="add" value="Add">
     <input type="submit" name="logout" value="Log out">
   </form>


   <?php
     $stmt = $pdo->query("SELECT make, year, mileage FROM autos");

     echo("<b>\nAutomobiles</b>");

     echo "<ul>";
     while ( $row = $stmt->fetch(PDO::FETCH_ASSOC) ) {

       echo "<li>";
       echo($row['year']);
       echo(" ");
       echo(htmlentities($row['make']));
       echo(" / ");
       echo($row['mileage']);
       echo("\n");
       echo("</li>");
     }
     echo("</ul>");

 ?>


 </body>
 </html>
