<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>Forgot Your Password - GatePassApp</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous"> 
</head>
<?php
session_start();
require '../components/_dbconnection.php';
use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

// Include PHPMailer autoloader
    require '../vendor/autoload.php';

if($_SERVER["REQUEST_METHOD"]=="POST"){
  $email = $_POST['email'];
  echo $email;
  $sql = "select * from usersdata where email = '$email'";
  $result = mysqli_query($conn,$sql);
  $rows =mysqli_num_rows($result);
  if($rows==1){
    $sql = "delete from forgetdata where email = '$email'";
    $result = mysqli_query($conn,$sql);
    $otp = rand(100000,999999);
    $sql = "insert into forgetdata (email,otp) values ('$email','$otp')";
    $result = mysqli_query($conn,$sql);

    if($result){
      $_SESSION['email'] = $email;
      $mail = new PHPMailer(true);
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
        $mail->addAddress("$email", "USER"); // Recipient's email and name
        // Content
        $mail->isHTML(true); // Set email format to HTML
        $mail->Subject = 'Password Reset: Your Requested Code Inside .Gms App';
        $mail->Body ='<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
            <tr>
                <td align="center" bgcolor="#0056b3" style="padding: 10px 0; color: #ffffff; font-size: 24px; font-weight: bold;">
                    Password Reset Request
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 20px; text-align: left; color: #333333; font-size: 16px; line-height: 24px;">
                    <p>Hello,</p>
                    <p>You recently requested to reset your password for your account. Use the code below to reset it. This password reset code is only valid for the next 30 minutes.</p>
                    <p style="font-size: 20px; font-weight: bold; color: #0056b3;">'.$otp.'</p>
                    <p>If you did not request a password reset, please ignore this email or contact support if you have any questions.</p>
                    <!-- Button should be wrapped in a table for better email client compatibility -->
                    <table cellspacing="0" cellpadding="0" border="0" style="margin: auto;">
                        <tr>
                            <td align="center" style="border-radius: 5px;" bgcolor="#007bff">
                                <a href="https://localhost/gatepassapp/reset.php" target="_blank" style="padding: 10px 20px; display: block; color: #ffffff; text-decoration: none; border-radius: 5px;">Reset Password</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor="#eeeeee" style="padding: 10px; text-align: center; font-size: 12px; line-height: 18px; color: #777777;">
                    If you are having trouble clicking the "Reset Password" button, copy and paste the URL below into your web browser:<br>
                    <a href="https://example.com/reset-password" target="_blank" style="color: #0056b3; text-decoration: none;">Reset Now</a>
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
     header("location: /gatepassapp/admin/adminreset.php");
      echo '
      <div class="alert alert-success alert-dismissible fade show" role="alert">
        <strong>Success!</strong> OTP has been sent to your email address.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
    }
    else{
      echo '
      <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Error!</strong> OTP could not be sent.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
      ';
    }
  }
  else{
    echo '
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
      <strong>Error!</strong> No user found with this email address.
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    ';
  }
}
?>
<body class="flex justify-center items-center flex-col">
<div class="mt-7 bg-white border border-gray-200 rounded-xl shadow-sm dark:bg-neutral-900 dark:border-neutral-700 w-[50vw]">
  <div class="p-4 sm:p-7">
    <div class="text-center">
      <h1 class="block text-2xl font-bold text-gray-800 dark:text-white">Forgot password - Admin </h1>
      <p class="mt-2 text-sm text-gray-600 dark:text-neutral-400">
        Remember your password?
        <a class="text-blue-600 decoration-2 hover:underline font-medium dark:text-blue-500" href="/gatepassapp/admin/adminlogin.php">
          Sign in here
        </a>
      </p>
    </div>

    <div class="mt-5">
      <!-- Form -->
      <form action="/gatepassapp/admin/adminforget.php" method ="post">
        <div class="grid gap-y-4">
          <!-- Form Group -->
          <div>
            <label for="email" class="block text-sm mb-2 dark:text-white">Email address</label>
            <div class="relative">
              <input type="email" id="email" name="email" class="py-3 px-4 block w-full border-gray-200 rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 disabled:opacity-50 disabled:pointer-events-none dark:bg-neutral-900 dark:border-neutral-700 dark:text-neutral-400 dark:placeholder-neutral-500 dark:focus:ring-neutral-600 border-2" required aria-describedby="email-error">
              <div class="hidden absolute inset-y-0 end-0 pointer-events-none pe-3">
                <svg class="size-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                  <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z"/>
                </svg>
              </div>
            </div>
            <p class="hidden text-xs text-red-600 mt-2" id="email-error">Please include a valid email address so we can get back to you</p>
          </div>
          <!-- End Form Group -->

          <button type="submit" class="w-full py-3 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent bg-blue-600 text-white hover:bg-blue-700 disabled:opacity-50 disabled:pointer-events-none">Reset password</button>
        </div>
      </form>
      <!-- End Form -->
    </div>
  </div>
</div>
</body>
</html>