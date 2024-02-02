<?php
session_start();

include('db_conn.php');

if (isset($_POST['registerUser'])) {
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $pass = $_POST['pass1'];
  $confirmPass = $_POST['pass2'];

  if ($pass == $confirmPass) {
      $hash = password_hash($pass, PASSWORD_DEFAULT);
      $addUser = $conn->prepare("INSERT INTO users (u_fname, u_lname, u_email, u_pass) VALUES(?, ?, ?, ?)");
      $addUser->execute([
          $fname,
          $lname,
          $email,
          $hash
      ]);

      $msg = "User registered succesfully!";
      header("Location: register.php?msg=$msg");
  } else {
      $msg = "Password do not match!";
      header("Location: register.php?msg=$msg");
  }
}

if (isset($_POST['login'])) {
  $u_email = $_POST['email'];
  $u_pass = $_POST['pass'];

  $getData = $conn->prepare("SELECT * FROM users WHERE u_email = ?");
  $getData->execute([$u_email]);

  foreach ($getData as $data) {
      if ($data['u_email'] == $u_email && password_verify($u_pass, $data['u_pass'])) {
          $_SESSION['logged_in'] = true;
          $_SESSION['u_id'] = $data['u_id'];

          $msg = "User logged-in successfully!";
          header("Location: index.php?msg=$msg");
      } else {
          $msg = "Email or Password do not match";
          header("Location: login.php?msg=$msg");
      }
  }
}

// for logout
if (isset($_GET['logout'])) {
  session_start();
  unset($_SESSION['logged_in']);
  unset($_SESSION['user_id']); 
  
  header("Location: login.php");
}

if(isset($_POST['delete_client']))
{
  $client_id = $_POST['delete_client'];

  try {

    $query = "DELETE FROM client WHERE id=:client_id";
    $statement = $conn->prepare($query);
    $data = [':client_id' => $client_id
    ];
    $query_execute = $statement->execute($data);

    if($query_execute)
    {
      $_SESSION['message'] = "Deleted Successfully";
      header('location: index.php');
      exit(0);
    }
    else 
    {
      $_SESSION['message'] = "Not Deleted";
      header('location: index.php');
      exit(0);
    }

  }catch(PDOException $e){
    echo $e->getMessage();
  }
}

if(isset($_POST['update_client_btn']))
{
  $client_id = $_POST['client_id'];
  $fname = $_POST['fname'];
  $lname = $_POST['lname'];
  $email = $_POST['email'];
  $address = $_POST['address'];
  $contact = $_POST['contact'];

  try{
        $query = "UPDATE client SET fname=:fname, lname=:lname, email=:email, address=:address, contact=:contact WHERE id=:client_id LIMIT 1";
        $statement = $conn->prepare($query);
        $data = [
        ':fname' =>   $fname,
        ':lname' =>   $lname,
        ':email' =>   $email,
        ':address' =>   $address,
        ':contact' =>   $contact,
        ':client_id' => $client_id,

      ]; 
      
      $query_execute = $statement->execute($data);

      if($query_execute)
      {
        $_SESSION['message'] = "Updated Successfully";
        header('location: index.php');
        exit(0);
      }
      else 
      {
        $_SESSION['message'] = "Not Updated";
        header('location: index.php');
        exit(0);
      }

  }catch (PDOException $e) {
    echo $e->getMessage();
  }
}

if(isset($_POST['save_client_btn']));
{
   $fname = $_POST['fname'];
   $lname = $_POST['lname'];
   $email = $_POST['email'];
   $address = $_POST['address'];
   $contact = $_POST['contact'];

    $query = "INSERT INTO client (fname, lname, email, address, contact ) VALUES (:fname, :lname, :email, :address, :contact)";
    $query_run = $conn->prepare($query);

    $data = [
               ':fname' =>   $fname,
               ':lname' =>   $lname,
               ':email' =>   $email,
               ':address' =>   $address,
               ':contact' =>   $contact,
      ];
      $query_execute = $query_run->execute($data);

      if($query_execute)
      {
        $_SESSION['message'] = "Added Successfully";
        header('location: index.php');
        exit(0);
      }
      else 
      {
        $_SESSION['message'] = "Not Added";
        header('location: index.php');
        exit(0);
      }
}
?>
