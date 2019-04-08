<?php 
$q = intval($_GET['q']);
$n = intval($_GET['n']);
    $con = new mysqli('localhost', 'root', '', "countrylist");

    if ($con->connect_error) 
    {
        die("Connection failed: " . $con->connect_error);
    } 
    else
    {
        $query = "SELECT name, location_id FROM `location` WHERE location_type = '".$n."' and parent_id = '".$q."'";
        $result = mysqli_query($con, $query);
        $data = array();
        while ($row = mysqli_fetch_array($result,MYSQLI_ASSOC))
        {
            $data[] = $row;
        }                      
        //console.log($data);
        echo json_encode($data);
        //echo "Hello";
    }
?>