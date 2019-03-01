<?php

 $re=[
            "status"=>204,
            "msg"=>"",
        ];
   
    $meth=$_POST['meth'];//1:for inserting data, 2: for getting data, 3 for deleting

/*
change below lines accordingly
*/
    $servername = "localhost";
    $username="root";
    $password="";
    $dbname = "contact_list";
/*change required upto here*/

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) 
    {
        $re['status']="204";
        $re['msg']="DataBase Connection Error";
    } 
    else
    {
        
         //for inserring data into table
            if($meth==1)
            {
                 $name=$_POST['name'];
                 $num=$_POST['num'];

                    global $conn;

                    $sql="insert into contacts(`name`,`number`) values('$name','$num');";
                    if($conn->query($sql)==TRUE)
                    {
                         $re['status']="200";
                        $re['msg']="Data Inserted Succesfully";
                    }
                    else
                    {
                        $re['status']="204";
                        $re['msg']="Error while inserting data : ".$conn->error;
                    }

            }

            //for getting the list
            else if($meth==2)
            { 
                global $conn;
                $sql="select * from contacts;";
                $res=$conn->query($sql);
                $re['msg']="<table><tr style='background-color: #25c18f;' ><th style='text-align:center'>NAME</th><th style='text-align:center' colspan='2'>NUMBER</th>";
                if($res->num_rows!=0 && !$conn->error)
                {
                    $re['status']="200";
                    while($row=$res->fetch_assoc())
                    {
                         $re['msg']=$re['msg'].
                         "<tr >
                         <td id='name_".$row['number']."' style='text-align:center'>".$row["name"]."</td>
                         <td id='num_".$row['number']."' style='text-align:center'>".$row['number']."</td>
                         <td style='text-align:center'>"."<img  id='".$row['number']."' onclick='del(this.id)' src='static/error.png' height='24px' width='24px'>"."</td>
                         </tr>";
                    }
                }
                else if($conn->error)
                {
                   $re['status']="204";
                    $re['msg']="Error while getting data : ".$conn->error;
                }
                else
                {
                    $re['status']="203";
                    $re['msg']="PhoneBook Is Empty.";
                } 

            }
        
          else if($meth==3)
            {
                 $num=$_POST['num'];

                    global $conn;
                        
                    $sql="delete from contacts where number='$num';";
                    if($conn->query($sql)==TRUE)
                    {
                         $re['status']="200";
                        $re['msg']="Contact Deleted Succesfully";
                    }
                    else
                    {
                        $re['status']="204";
                        $re['msg']="Error while deleting contact : ".$conn->error;
                    }

            }

    }

   echo json_encode($re);
   

?>