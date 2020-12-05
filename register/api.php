<?php
$co=mysqli_connect("localhost","root","","registration");
$response=array();
if ($co){
    echo "DB connected";
    $sql= "select * from data";
    $result= mysqli_query($co,$sql);
    if($result){
        header("Content-Type: JSON");
        $i=0;
        while($row=mysqli_fetch_assoc($result)){

            $response[$i]['id']= $row["id"];
            $response[$i]['name']= $row["name"];
            $response[$i]['age']= $row["age"];
            $response[$i]['email']= $row["email"];
            $i++;

        }
        echo json_encode($response,JSON_PRETTY_PRINT);
    }
}
else{
    echo "Databse connection failed";
}
?>