<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Applications | Admin Panel</title>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: /gatepassapp/admin/adminlogin.php");
    }
    require "../components/admin.php";
    require "../components/_dbconnection.php";
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    
    // Include PHPMailer autoloader
    require '../vendor/autoload.php';
    
    // Create a new PHPMailer instance
    $mail = new PHPMailer(true);
    $sql = "SELECT * FROM `gatepassdata` WHERE `status` = 'pending'";
    $result = mysqli_query($conn, $sql);
    $count = mysqli_num_rows($result);
    ?>
    <section class="absolute left-72 top-6 ">
    <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try{
                $gatepassno = $_POST['gatepassno'];
                $status = $_POST['status'];
                if($status == "Approved"){
                    $sql = "UPDATE `gatepassdata` SET `status` = 'Approved' WHERE `gatepassno` = '$gatepassno'";
                    $result = mysqli_query($conn, $sql);
                    $sql = "SELECT * FROM `gatepassdata` WHERE `gatepassno` = '$gatepassno'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $email = $row['email'];
                    $name = $row['name'];
                    if($result){
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
                            $mail->Subject = 'Your Gate Pass Request has been Approved!';
                            $mail->Body ='<!DOCTYPE html>
                            <html lang="en">
                            <head>
                              <meta charset="UTF-8">
                              <meta name="viewport" content="width=device-width, initial-scale=1.0">
                              <title>Gate Pass Approved</title>
                            </head>
                            <body style="font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
                              <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                                <tr>
                                  <td align="center" style="padding: 20px;">
                                    <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; max-width: 600px; background-color: #ffffff; border-radius: 10px; box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);">
                                      <tr>
                                        <td style="padding: 40px;">
                                          <h1 style="color: #4CAF50; text-align: center; margin-bottom: 30px;">Gate Pass Approved</h1>
                                          <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Dear '.$row['name'].',</p>
                                          <p style="font-size: 16px; color: #666; margin-bottom: 20px;">We are pleased to inform you that your gate pass request has been approved. You are now permitted to proceed with your request.</p>
                                          <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                                            <tr>
                                              <td width="30%" style="font-size: 16px; color: #666;"><strong>Name:</strong></td>
                                              <td width="70%" style="font-size: 16px; color: #333;">'.$row['name'].'</td>
                                            </tr>
                                            <tr>
                                              <td width="30%" style="font-size: 16px; color: #666;"><strong>Reason:</strong></td>
                                              <td width="70%" style="font-size: 16px; color: #333;">'.$row['reason'].'</td>
                                            </tr>
                                            <tr>
                                              <td width="30%" style="font-size: 16px; color: #666;"><strong>Date:</strong></td>
                                              <td width="70%" style="font-size: 16px; color: #333;">'.$row['fromdate'].' to '.$row['enddate'].'</td>
                                            </tr>
                                            <tr>
                                              <td width="30%" style="font-size: 16px; color: #666;"><strong>GatePass Id:</strong></td>
                                              <td width="70%" style="font-size: 16px; color: #333;">'.$row['gatepassno'].'</td>
                                            </tr>
                                            <tr>
                                              <td width="30%" style="font-size: 16px; color: #666;"><strong>Status:</strong></td>
                                              <td width="70%" style="font-size: 16px; color: #333;">'.$row['status'].'</td>
                                            </tr>
                                          </table>
                                          <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Please donot hesitate to reach out if you have any questions or need further assistance.</p>
                                          <p style="font-size: 16px; color: #666; margin-bottom: 0;">Best regards,<br>GMS Powered By CUTM</p>
                                        </td>
                                      </tr>
                                    </table>
                                  </td>
                                </tr>
                              </table>
                            </body>
                            </html>
                            '; // Load HTML template
                            $mail->AltBody = 'Your Gate Pass Request has been Approved!'; // Optional: plain text alternative
                        
                            // Send email
                            $mail->send();
                            echo 'Email sent successfully';
                        } catch (Exception $e) {
                            echo "Email sending failed: {$mail->ErrorInfo}";
                        }
                    }
                }
                else if($status == "Rejected"){
                    $sql = "UPDATE `gatepassdata` SET `status` = 'Rejected' WHERE `gatepassno` = '$gatepassno'";
                    $result = mysqli_query($conn, $sql);
                    $sql = "SELECT * FROM `gatepassdata` WHERE `gatepassno` = '$gatepassno'";
                    $result = mysqli_query($conn, $sql);
                    $row = mysqli_fetch_assoc($result);
                    $email = $row['email'];
                    $name = $row['name'];
                    if($result){
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
                            $mail->Subject = 'Notification: Gate Pass Request Rejected';
                            $mail->Body ='
                            <body style="font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif; background-color: #f9f9f9; margin: 0; padding: 0;">
  <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
    <tr>
      <td align="center" style="padding: 20px;">
        <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; max-width: 600px; background-color: #ffffff; border-radius: 10px; box-shadow: 0px 0px 20px 0px rgba(0,0,0,0.1);">
          <tr>
            <td style="padding: 40px;">
              <h1 style="color: #FF5722; text-align: center; margin-bottom: 30px;">Gate Pass Rejected</h1>
              <p style="font-size: 16px; color: #666; margin-bottom: 20px;">Dear '.$name.',</p>
              <p style="font-size: 16px; color: #666; margin-bottom: 20px;">We regret to inform you that your gate pass request has been rejected. If you have any questions or need further clarification, please feel free to reach out to us. Or email at help@gms.com</p>
              <table role="presentation" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 20px;">
                <tr>
                  <td width="30%" style="font-size: 16px; color: #666;"><strong>Name:</strong></td>
                  <td width="70%" style="font-size: 16px; color: #333;">'.$row['name'].'</td>
                </tr>
                <tr>
                  <td width="30%" style="font-size: 16px; color: #666;"><strong>Reason:</strong></td>
                  <td width="70%" style="font-size: 16px; color: #333;">'.$row['reason'].'</td>
                </tr>
                <tr>
                  <td width="30%" style="font-size: 16px; color: #666;"><strong>Date:</strong></td>
                  <td width="70%" style="font-size: 16px; color: #333;">'.$row['fromdate'].' to '.$row['endadate'].'</td>
                </tr>
                <tr>
                  <td width="30%" style="font-size: 16px; color: #666;"><strong>GatePassId:</strong></td>
                  <td width="70%" style="font-size: 16px; color: #333;">'.$row['gatepassno'].'</td>
                </tr>
                <tr>
                  <td width="30%" style="font-size: 16px; color: #666;"><strong>Status:</strong></td>
                  <td width="70%" style="font-size: 16px; color: #333;">'.$row['status'].'</td>
                </tr>
              </table>
              <p style="font-size: 16px; color: #666; margin-bottom: 20px;">We apologize for any inconvenience this may cause and appreciate your understanding.</p>
              <p style="font-size: 16px; color: #666; margin-bottom: 0;">Best regards,<br>GMS Powered By CUTM</p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
                            '; // Load HTML template
                            $mail->AltBody = 'Notification: Gate Pass Request Rejected'; // Optional: plain text alternative
                        
                            // Send email
                            $mail->send();
                            echo 'Email sent successfully';
                        } catch (Exception $e) {
                            echo "Email sending failed: {$mail->ErrorInfo}";
                        }
                }
            }

            }
            catch(err){
            echo "Error: $err";
            }
        }
        ?>
    <section class="container px-4 mx-auto">
    <div class="flex items-center gap-x-3">
        <h2 class="text-lg font-medium text-gray-800 dark:text-white">Pending Applications</h2>

        <span class="px-3 py-1 text-xs text-blue-600 bg-blue-100 rounded-full dark:bg-gray-800 dark:text-blue-400"><?php echo $count;?> Applications</span>
    </div>

    <div class="flex flex-col mt-6">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-x-3">
                                        <input type="checkbox" class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">
                                        <span>Name</span>
                                    </div>
                                </th>

                                <th scope="col" class="px-12 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-2">
                                        <span>Status</span>

                                        <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                            <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                        </svg>
                                    </button>
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <button class="flex items-center gap-x-2">
                                        <span>Reason </span>

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-4 h-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9 5.25h.008v.008H12v-.008z" />
                                        </svg>
                                    </button>
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Guardian Phone</th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Date & Phone</th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">Action</th>

                                <th scope="col" class="relative py-3.5 px-4">
                                    <span class="sr-only">Edit</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <?php
                             while($row = mysqli_fetch_assoc($result)){
                            echo '<tr>
                            <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                <div class="inline-flex items-center gap-x-3">
                                    <input type="checkbox" class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">

                                    <div class="flex items-center gap-x-2">
                                        <img class="object-cover w-10 h-10 rounded-full" src="https://images.unsplash.com/photo-1535713875002-d1d0cf377fde?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=880&q=80" alt="">
                                        <div>
                                            <h2 class="font-medium text-gray-800 dark:text-white ">'.$row['name'].'</h2>
                                            <p class="text-sm font-normal text-gray-600 dark:text-gray-400">'.$row['email'].'</p>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-12 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                <div class="inline-flex items-center px-3 py-1 rounded-full gap-x-2 bg-emerald-100/60 dark:bg-gray-800">
                                    <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                    <h2 class="text-sm font-normal text-emerald-500">'.$row['status'].'</h2>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">'.$row['reason'].'</td>
                            <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">'.$row['gnumber'].'</td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-x-2">
                                    <p class="px-3 py-1 text-xs text-indigo-500 rounded-full dark:bg-gray-800 bg-indigo-100/60">'.$row['fromdate'].'</p>
                                    <p class="px-3 py-1 text-xs text-blue-500 rounded-full dark:bg-gray-800 bg-blue-100/60">'.$row['enddate'].'</p>
                                    <p class="px-3 py-1 text-xs text-pink-500 rounded-full dark:bg-gray-800 bg-pink-100/60">'.$row['phone'].'</p>
                                </div>
                            </td>
                            <td class="px-4 py-4 text-sm whitespace-nowrap">
                                <div class="flex items-center gap-x-6">
                                    <button class="text-gray-500 transition-colors duration-200 dark:hover:text-red-500 dark:text-gray-300 hover:text-red-500 focus:outline-none"  onclick="handleReject(\''. $row["gatepassno"] .'\')">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                        </svg>
                                    </button>

                                    <button class="transition-colors duration-200 dark:hover:text-gray-400 dark:text-gray-300 hover:text-yellow-500 focus:outline-none bg-green-600 rounded p-2 text-white"  onclick="handleApproved(\''. $row["gatepassno"] .'\')">
                                        Accept
                                    </button>
                                </div>
                            </td>
                        </tr>';
                             }
                            ?>
                            

                        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="flex items-center justify-between mt-6">
        <a href="#" class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 15.75L3 12m0 0l3.75-3.75M3 12h18" />
            </svg>

            <span>
                previous
            </span>
        </a>

        <a href="#" class="flex items-center px-5 py-2 text-sm text-gray-700 capitalize transition-colors duration-200 bg-white border rounded-md gap-x-2 hover:bg-gray-100 dark:bg-gray-900 dark:text-gray-200 dark:border-gray-700 dark:hover:bg-gray-800">
            <span>
                Next
            </span>

            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 rtl:-scale-x-100">
                <path stroke-linecap="round" stroke-linejoin="round" d="M17.25 8.25L21 12m0 0l-3.75 3.75M21 12H3" />
            </svg>
        </a>
    </div>
</section>
    </section>
    <script>
function handleApproved(gatepassno) {
   console.log(gatepassno);
   const status = "Approved";
   var xhr = new XMLHttpRequest();
    xhr.open("POST", "/gatepassapp/admin/pendingapplication.php", true); // Assuming the PHP script is in the same directory
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle response from PHP script if needed
                alert("Application Accepted Successfully");
                window.location.reload();
            } else {
                // Handle error
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.send("gatepassno=" + encodeURIComponent(gatepassno) + "&status=" + encodeURIComponent(status));

}
function handleReject(gatepassno) {
   console.log(gatepassno);
   const status = "Rejected";
   var xhr = new XMLHttpRequest();
    xhr.open("POST", "/gatepassapp/admin/pendingapplication.php", true); // Assuming the PHP script is in the same directory
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle response from PHP script if needed
                alert("Application Rejected Successfully");
                window.location.reload();
            } else {
                // Handle error
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.send("gatepassno=" + encodeURIComponent(gatepassno) + "&status=" + encodeURIComponent(status));

}
</script>
</body>
</html>