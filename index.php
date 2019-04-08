<?php
    $con = new mysqli('localhost', 'root', '', "countrylist");

    if ($con->connect_error) 
    {
        die("Connection failed: " . $con->connect_error);
    } 
?>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
        <title>Home Page</title>
    </head>
    <body>
        <script language="javascript" type="text/javascript">
            function showUser(str)
            {
                console.log(str);
                if (str == "") 
                {
                    return;
                } 
                else 
                { 
                    xmlhttp = new XMLHttpRequest();  
                    xmlhttp.onreadystatechange = function() {
                        if (this.readyState == 4 && this.status == 200) 
                        {
                            
                            var data = JSON.parse(this.responseText);
                            //console.log(data);
                            var html = "";
                            for(var a = 0; a < data.length; a++)
                            {
                                var name = data[a].name;
                                var id = data[a].location_id;
                                html += "<option  value = "+ id+">"+ name + "</option>";
                            }
                            //console.log(html);
                            document.getElementById("state").innerHTML = html;
                            var city = $("#state").val();
                            showCity(city);
                        }
                    };
                    xmlhttp.open("GET","update.php?q="+str+"&n="+1,true);
                    xmlhttp.send();
                }
                
            }

            function showCity(str)
            {
                if (str == "") 
                {
                    return;
                } 
                else 
                { 
                    xmlhttp = new XMLHttpRequest();  
                    xmlhttp.onreadystatechange = function() 
                    {
                        if (this.readyState == 4 && this.status == 200) 
                        {
                            var data = JSON.parse(this.responseText);
                            var html = "";
                            for(var a = 0; a < data.length; a++)
                            {
                                var name = data[a].name;
                                var id = data[a].location_id;
                                html += "<option>"+ name + "</option>";
                            }
                            document.getElementById("city").innerHTML = html;
                        }
                    };
                    xmlhttp.open("GET","update.php?q="+str+"&n="+2,true);
                    xmlhttp.send();
                }
            }
        </script>
        <style>
            .col-md-12
            {
                margin-left: 200px;
                margin-top: 100px;
            }
            .select
            {
                width: 500px;
            }
        </style>
        <div class="row"> 
            <div class="col-md-12 " style='center'> 
                <?php
                    $query = "SELECT name, location_id FROM location  where location_type = 0";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);                      
                ?> 
                <label> Country :</label>
                <select class="select" name="countrylist" id="country" onchange="showUser(this.value)"> 
                    <?php 
                        foreach($result as $row)
                        {
                            echo '<option value= '.$row['location_id'].' >' .$row['name'].'</option>';
                        }
                    ?>
                </select>
                <br>
                <?php
                    $query = "SELECT name, location_id FROM location  where location_type = 1 and parent_id = 1";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);                      
                ?> 
                <label> State : </label>
                <select class="select" id="state" onchange="showCity(this.value)">
                    <?php 
                        foreach($result as $row)
                        {
                            echo '<option value= '.$row['location_id'].' >' .$row['name'].'</option>';
                        }
                    ?>
                </select>
                <br>
                <?php
                    $query = "SELECT name, location_id FROM location  where location_type = 2 and parent_id = 240";
                    $result = mysqli_query($con, $query);
                    $row = mysqli_fetch_array($result,MYSQLI_ASSOC);                      
                ?> 
                <label> City : </label>
                <select class="select" id="city"> 
                <?php 
                        foreach($result as $row)
                        {
                            echo '<option value= '.$row['location_id'].' >' .$row['name'].'</option>';
                        }
                    ?>
                </select>
            </div>
        </div>
    </body>
</html>

