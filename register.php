<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
     <script src="https://cdn.tailwindcss.com"></script>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
<?php
    require "components/_dbconnection.php";
    use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
require 'vendor/autoload.php';

// Create a new PHPMailer instance
$mail = new PHPMailer(true);
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $name = $_POST['name'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $cpassword = $_POST['cpassword'];
        if($name == "" || $email == "" || $password == "" || $cpassword == "") {
         echo '
         <div class="alert alert-danger alert-dismissible fade show" role="alert">
  <strong>Error!</strong> Please fill all the deatils for create an account !.
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
         ';
        }
        else{
        if($password == $cpassword){
           $sql = "select * from usersdata where email = '$email'";
              $result = mysqli_query($conn,$sql);
              $num = mysqli_num_rows($result);
              if($num==0){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            $sql = "INSERT INTO `usersdata` (`name`, `email`, `password`) VALUES ('$name', '$email', '$hash')";
            $result = mysqli_query($conn,$sql);
            if($result){
                echo '
         <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>Success!</strong> Your account was created successfully .
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
         ';
         try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp-relay.brevo.com';  // Specify your SMTP server
            $mail->SMTPAuth = true;
            $mail->Username = 'specareenterprises@gmail.com'; // SMTP username
            $mail->Password = 'XdIG2sMJZjyc6SWY'; // SMTP password
            $mail->SMTPSecure = 'tls'; // Enable TLS encryption, `ssl` also accepted
            $mail->Port = 587; // TCP port to connect to
        
            // Recipients
            $mail->setFrom('account@gmsapp.com', 'Gatepass app'); // Sender's email and name
            $mail->addAddress("$email", "$name"); // Recipient's email and name
            // Content
            $mail->isHTML(true); // Set email format to HTML
            $mail->Subject = 'Welcome to GatePassApp Your Account is Ready to go';
            $mail->Body ='<body style="font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0;">
            <table width="100%" bgcolor="#f4f4f4" border="0" cellpadding="0" cellspacing="0">
                <tr>
                    <td>
                        <table align="center" bgcolor="#ffffff" style="max-width: 600px; margin: auto; padding: 20px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                            <tr>
                                <td style="background-color: #007BFF; color: #ffffff; padding: 10px; text-align: center;">
                                    <h1>Welcome to Our GMS</h1>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding: 20px; text-align: center;">
                                    <p>Hi <strong>User Welcome to GatePassApp </strong>,</p>
                                    <p>Thank you for creating an account with us. Your account has been successfully set up.</p>
                                    <p>You can now access all the features available. We hope you enjoy your experience with us!</p>
                                    <p>If you have any questions, feel free to <a href="mailto:khanbasir5555@gmail.com">contact us</a>.</p>
                                    <p>Best Regards,<br>GMS powered by cutm</p>
                                </td>
                            </tr>
                            <tr>
                                <td style="padding-top: 20px; font-size: 12px; text-align: center; color: #888;">
                                    © 2024 gms.cutm.ac.in. All rights reserved.
                                </td>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
            </body>'; // Load HTML template
            $mail->AltBody = 'This is the text-only body in case HTML email is not supported'; // Optional: plain text alternative
        
            // Send email
            $mail->send();
            echo 'Email sent successfully';
        } catch (Exception $e) {
            echo "Email sending failed: {$mail->ErrorInfo}";
        }
         header("location: /gatepassapp/login.php");
              }
              else{
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>Error!</strong> We are facing some technical issues please try again later.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
                ';
              }
            }
              else{
                echo '
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
         <strong>Error!</strong> Your account already exits please login instead of creating account.
         <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
       </div>
                ';
              }
           
        }
        else{
            echo '
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
     <strong>Error!</strong> Password and confirm doesnot match!.
     <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
            ';
        }
    }
}
    ?>

    <div class="flex w-full max-w-sm mx-auto overflow-hidden bg-white rounded-lg shadow-lg dark:bg-gray-800 lg:max-w-4xl my-16">
        <div class="hidden bg-cover lg:block lg:w-1/2" style="background-image: url('/gatepassapp/images/register.jpg');"></div>
    
        <div class="w-full px-6 py-8 md:px-8 lg:w-1/2">
            <div class="flex justify-center mx-auto">
                <img class="w-auto h-7 sm:h-8" src="https://cutm.ac.in/wp-content/uploads/Centurion_University_of_Technology_and_Management_Logo.webp" alt="">
            </div>
    
            <p class="mt-3 text-xl text-center text-gray-600 dark:text-gray-200">
                Welcome back!
            </p>
    
            <a href="#" class="flex items-center justify-center mt-4 text-gray-600 transition-colors duration-300 transform border rounded-lg dark:border-gray-700 dark:text-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                <div class="px-4 py-2">
                    <svg class="w-6 h-6" viewBox="0 0 40 40">
                        <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.045 27.2142 24.3525 30 20 30C14.4775 30 10 25.5225 10 20C10 14.4775 14.4775 9.99999 20 9.99999C22.5492 9.99999 24.8683 10.9617 26.6342 12.5325L31.3483 7.81833C28.3717 5.04416 24.39 3.33333 20 3.33333C10.7958 3.33333 3.33335 10.7958 3.33335 20C3.33335 29.2042 10.7958 36.6667 20 36.6667C29.2042 36.6667 36.6667 29.2042 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#FFC107" />
                        <path d="M5.25497 12.2425L10.7308 16.2583C12.2125 12.59 15.8008 9.99999 20 9.99999C22.5491 9.99999 24.8683 10.9617 26.6341 12.5325L31.3483 7.81833C28.3716 5.04416 24.39 3.33333 20 3.33333C13.5983 3.33333 8.04663 6.94749 5.25497 12.2425Z" fill="#FF3D00" />
                        <path d="M20 36.6667C24.305 36.6667 28.2167 35.0192 31.1742 32.34L26.0159 27.975C24.3425 29.2425 22.2625 30 20 30C15.665 30 11.9842 27.2359 10.5975 23.3784L5.16254 27.5659C7.92087 32.9634 13.5225 36.6667 20 36.6667Z" fill="#4CAF50" />
                        <path d="M36.3425 16.7358H35V16.6667H20V23.3333H29.4192C28.7592 25.1975 27.56 26.805 26.0133 27.9758C26.0142 27.975 26.015 27.975 26.0158 27.9742L31.1742 32.3392C30.8092 32.6708 36.6667 28.3333 36.6667 20C36.6667 18.8825 36.5517 17.7917 36.3425 16.7358Z" fill="#1976D2" />
                    </svg>
                </div>
    
                <span class="w-5/6 px-4 py-3 font-bold text-center">Sign in with Google</span>
            </a>
    
            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b dark:border-gray-600 lg:w-1/4"></span>
    
                <a href="#" class="text-xs text-center text-gray-500 uppercase dark:text-gray-400 hover:underline">or login
                    with email</a>
    
                <span class="w-1/5 border-b dark:border-gray-400 lg:w-1/4"></span>
            </div>
            <form action="/gatepassapp/register.php" method = "post">
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="name">Name</label>
                <input id="name" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" name="name" type="text" />
            </div>
            <div class="mt-4">
                <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="email">Email Address</label>
                <input id="email" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" name = "email" type="email" />
            </div>
    
            <div class="mt-4">
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="loggingPassword">Password</label>
                  
                </div>
    
                <input id="password" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" name= "password" type="password" />
            </div>
            <div class="mt-4">
                <div class="flex justify-between">
                    <label class="block mb-2 text-sm font-medium text-gray-600 dark:text-gray-200" for="loggingPassword">Confirm Password</label>
                  
                </div>
    
                <input id="loggingPassword" class="block w-full px-4 py-2 text-gray-700 bg-white border rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 focus:border-blue-400 focus:ring-opacity-40 dark:focus:border-blue-300 focus:outline-none focus:ring focus:ring-blue-300" name="cpassword" type="password" />
            </div>
    
    
            <div class="mt-6">
                <button class="w-full px-6 py-3 text-sm font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-gray-800 rounded-lg hover:bg-gray-700 focus:outline-none focus:ring focus:ring-gray-300 focus:ring-opacity-50" type="submit">
                    Sign up
                </button>
            </div>
            </form>
    
            <div class="flex items-center justify-between mt-4">
                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
    
                <a href="/gatepassapp/login.php" class="text-xs text-gray-500 uppercase dark:text-gray-400 hover:underline">or sign in</a>
    
                <span class="w-1/5 border-b dark:border-gray-600 md:w-1/4"></span>
            </div>
        </div>
    </div>
</body>
</html>