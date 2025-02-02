<?php

if(!function_exists("checkIfEmailAlreadyExists")) {

  function checkIfEmailAlreadyExists($email,$type,$link) {
    $query = "SELECT `email` from `".$type."` WHERE `email` = '".$email."'";
    $result = mysqli_query($link,$query);
    $row = mysqli_fetch_array($result);
    if($row) {
      return true;
    } return false;
  }

}

if(!function_exists("signUpUser")) {

  function signUpUser($link,$type,$assignedBy) {

    include('../php-utils/user_variables.php');
    //print_r($userCred);
    $success = false; 
    $error = false;
    if(checkIfEmailAlreadyExists($userCred['email'],$type,$link)) {
      $error = 'Email Id already exists!';
    } else {
      
      $id = "";
      if($type == "hod") {
        $id = "hod_id";
      } else if($type == "employee") {
        $id = "employee_id";
      } else {
        $id = "id";
      }

      $query = "INSERT INTO `".$type."`( `".$id."`,`email`, `password`,`first_name`,`last_name`,`phone_no`".
      (
        (strcmp($type,'admin')==0 || strcmp($type,'security')==0) ? "" : 
        (
          (strcmp($type,'hod')==0) ? ",`admin_id`" : ",`hod_id`"
        )
      )
  
      .") VALUES ('".$userCred['employee_Id']."','".$userCred['email']."','".$userCred['password']."','".$userCred['firstName']."','".$userCred['lastName']."','".$userCred['phone_no']."'".
  
      ( 
      (strcmp($type,'admin')==0 || strcmp($type,'security')==0) 
      ? "" : ",'".$assignedBy."'" 
      )
      
      .")";
      //echo '<br>'.$query;
  
      if(mysqli_query($link, $query)) {
        $success = true;
      } else {
        //$error =  mysqli_error($link);
        $error = 'Employee Id already exists!';
        //return array(false,'Something went wrong!');
      }
    }

    if($success) {
      echo '<div class="alert alert-success">
              <strong>User SignUp Successful!</strong> 
            </div>';
    } else if($error) {
        echo '<div class="alert alert-danger">
                <strong>'.$error.'</strong> 
              </div>';
    }
  }
}

if(!function_exists("getUserData")) {
  function getUserData($link,$type,$assignedBy) {

    $query = "SELECT * FROM `".$type."`;";
    //echo $query;
    $result = mysqli_query($link,$query);
    if(!$result) {
      echo mysqli_error($link);
      return ;
    } 
    return $result;
    // while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){
    //   echo '<br>';
    //   print_r($row);
    //   echo '<br>';
    // }

  }
}

?>