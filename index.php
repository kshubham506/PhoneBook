<html>
<head>
    <title>Phone Directory</title>
    
    <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel= "stylesheet" type= "text/css" href= "static/fonts/indie.css">
        <link href="static/fonts/material.css" rel="stylesheet">
        <link type="text/css" rel="stylesheet" href="static/materialize/css/materialize.min.css"  media="screen,projection"/>
        <script type = "text/javascript" src = "static/js/jquery.js" ></script>
</head>
    <style>
        .bg { 
              background-image: url("static/3132.jpg");
              height: 100%; 
              background-position: center;
              background-repeat: no-repeat;
              background-size: cover;
            }
        ::placeholder { 
          color: black;
          opacity: 1;
        }

        :-ms-input-placeholder {
          color: black;
        }

        ::-ms-input-placeholder { 
          color: black;
        }
    </style>
<body class="bg">
   <!-- <h4 >Phone Book</h4>-->
   <br><br>
    <div class="buttons" >
        <center>
         <a class="waves-effect waves-light btn-small" id="add_button" style="margin-right: 10px; display: inline-block;" onclick="show_menu()">ADD NEW CONTACT</a>
         <a class="waves-effect waves-light btn-small" id="hide_button" style="margin-right: 10px; display: none;" onclick="hide_menu()">HIDE</a>
            </center>
    </div>
    
    <div class="save_contact" id="save" style="display:none">
        <center>
            <input type="text" placeholder="Name" id="contact_name" onkeyUp="document.getElementById('contact_disp1').innerHTML = this.value" style="width:50%;"> <br>
            
            <input type="text"  placeholder="Phone Number" id="contact_num" onkeyUp="document.getElementById('contact_disp2').innerHTML = this.value"  style="width:50%"> <br><br>
           
            <div class='contact_disp' id='contact_disp'>
                <center>
                 <!--   <h6><u>Contact To Be Added</u></h6>-->
                    Name : <span id="contact_disp1"></span>
                    |
                    Phone : <span id="contact_disp2"></span>
                </center>
            </div>
            <br>
            <a class="waves-effect waves-light btn-small" style="margin-right: 10px; display: inline-block;" onclick="add()">SAVE CONTACT</a>
            <a class="waves-effect waves-light btn-small" style="margin-right: 10px; display: inline-block;" onclick="clear_data()">CLEAR</a>
        </center>
    </div>
    
    <center>
     <h4 id="info"></h4>
    </center>
    
    
</body>
<script>
    
        function show_menu()
        {
             $("#save").slideDown("slow");
            document.getElementById("add_button").style.display="none";
            document.getElementById("hide_button").style.display="inline-block";
        }
    
        function hide_menu()
        {
            $("#save").slideUp("slow");
            document.getElementById("add_button").style.display="inline-block";
            document.getElementById("hide_button").style.display="none";
        }
    
        function clear_data()
        {
            document.getElementById("contact_name").value="";
            document.getElementById("contact_num").value="";
            document.getElementById("contact_disp1").innerHTML="";
            document.getElementById("contact_disp2").innerHTML="";
        }

    
        function add()
        {
            var cname=document.getElementById('contact_name').value;
            var cnum=document.getElementById('contact_num').value;
            if(cname.length==0 || cnum.length==0)
                {
                    alert("Name or Number cannot be empty");
                }
            else{
                 $.post("save_data.php",{name: cname,num:cnum,meth:1},
                function(data,status){
                        if(status=='success')
                            {
                                var resp=JSON.parse(data);
                                if(resp.status==200)
                                    {
                                        document.getElementById('info').innerHTML=resp.msg;
                                    }
                                else if(resp.status!=200)
                                    {
                                        alert("Error While Saving : Number Already Present");
                                    }
                                
                                show();
                            }
                        else{
                            alert("Error while getting details. Try Again");
                        }
                            
             });
            }
            
        }
    
        function del(clicked_id)
        {
            var name=document.getElementById('name_'+clicked_id).innerHTML;
            var num1=document.getElementById('num_'+clicked_id).innerHTML;
            //alert(num1);
            var con=confirm("Are you sure you want to delete "+name+"?\nThis is irrevrsible.")
            if(con==true)
                {
                     $.post("save_data.php",{num:num1,meth:3},
                    function(data,status){
                        if(status=='success')
                            {
                                 var resp=JSON.parse(data);
                                if(resp.status==200)
                                    document.getElementById('info').innerHTML=resp.msg;
                                else if(resp.status==203)//no data condition
                                    document.getElementById('info').innerHTML=resp.msg;
                                
                                show();
                            }
                        else{
                            alert("Error while getting details. Try Again");
                        }
            });
                }
           
        }
       
    
       function show()
        {
            $.post("save_data.php",{meth:2},
                    function(data,status){
                        if(status=='success')
                            {
                                 var resp=JSON.parse(data);
                                if(resp.status==200)
                                    document.getElementById('info').innerHTML=resp.msg;
                                else if(resp.status==203)//no data condition
                                    document.getElementById('info').innerHTML=resp.msg;
                            }
                        else{
                            alert("Error while getting details. Try Again");
                        }
            });
        }
    
    $(document).ready(function(){
                    show();
                });
    
   
    
</script>


</html>