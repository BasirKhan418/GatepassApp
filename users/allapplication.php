<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Application Data | GMS APP</title>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: /gatepassapp/admin/adminlogin.php");
    }
    require '../components/user.php';
    require '../components/_dbconnection.php';
    
    ?>
    <section class="absolute left-72 top-8" >
        <?php
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            try{
                $gatepassno = $_POST['gatepassno'];
                $sql = "DELETE FROM `gatepassdata` WHERE `gatepassno` = '$gatepassno'";
                $result = mysqli_query($conn,$sql);
            }
            catch(err){
            echo "Error: $err";
            }
        }
        ?>
        <h1 class="font-bold text-4xl my-6 mx-4 p-4 rounded bg-blue-500 text-white">Your All Application | <?php
        echo $_SESSION['name'];
        ?></h1>
    <section class="container px-4 mx-auto">
    <div class="flex flex-col">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                <div class="overflow-hidden border border-gray-200 dark:border-gray-700 md:rounded-lg">
                    <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                        <thead class="bg-gray-50 dark:bg-gray-800">
                            <tr>
                                <th scope="col" class="py-3.5 px-4 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-x-3">
                                        <input type="checkbox" class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">
                                        <button class="flex items-center gap-x-2">
                                            <span>Gatepass No.</span>

                                            <svg class="h-3" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.13347 0.0999756H2.98516L5.01902 4.79058H3.86226L3.45549 3.79907H1.63772L1.24366 4.79058H0.0996094L2.13347 0.0999756ZM2.54025 1.46012L1.96822 2.92196H3.11227L2.54025 1.46012Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M0.722656 9.60832L3.09974 6.78633H0.811638V5.87109H4.35819V6.78633L2.01925 9.60832H4.43446V10.5617H0.722656V9.60832Z" fill="currentColor" stroke="currentColor" stroke-width="0.1" />
                                                <path d="M8.45558 7.25664V7.40664H8.60558H9.66065C9.72481 7.40664 9.74667 7.42274 9.75141 7.42691C9.75148 7.42808 9.75146 7.42993 9.75116 7.43262C9.75001 7.44265 9.74458 7.46304 9.72525 7.49314C9.72522 7.4932 9.72518 7.49326 9.72514 7.49332L7.86959 10.3529L7.86924 10.3534C7.83227 10.4109 7.79863 10.418 7.78568 10.418C7.77272 10.418 7.73908 10.4109 7.70211 10.3534L7.70177 10.3529L5.84621 7.49332C5.84617 7.49325 5.84612 7.49318 5.84608 7.49311C5.82677 7.46302 5.82135 7.44264 5.8202 7.43262C5.81989 7.42993 5.81987 7.42808 5.81994 7.42691C5.82469 7.42274 5.84655 7.40664 5.91071 7.40664H6.96578H7.11578V7.25664V0.633865C7.11578 0.42434 7.29014 0.249976 7.49967 0.249976H8.07169C8.28121 0.249976 8.45558 0.42434 8.45558 0.633865V7.25664Z" fill="currentColor" stroke="currentColor" stroke-width="0.3" />
                                            </svg>
                                        </button>
                                    </div>
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Date
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Status
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Profile
                                </th>

                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Phone
                                </th>
                                <th scope="col" class="px-4 py-3.5 text-sm font-normal text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                    Guardian Phone
                                </th>
                               
                            </tr>
                        </thead>
                       <tbody class="bg-white divide-y divide-gray-200 dark:divide-gray-700 dark:bg-gray-900">
                            <?php 
                            $sql = "SELECT * FROM `gatepassdata` WHERE `email` = '$_SESSION[email]'";
                            $result = mysqli_query($conn,$sql);
                            $rows = mysqli_num_rows($result);
                            if($result){
                            if($rows>=1){
                                while($rows = mysqli_fetch_assoc($result)){
                                 echo '<tr>
                                 <td class="px-4 py-4 text-sm font-medium text-gray-700 dark:text-gray-200 whitespace-nowrap">
                                     <div class="inline-flex items-center gap-x-3">
                                         <input type="checkbox" class="text-blue-500 border-gray-300 rounded dark:bg-gray-900 dark:ring-offset-gray-900 dark:border-gray-700">
 
                                         <span>'. $rows["gatepassno"] .'</span>
                                     </div>
                                 </td>
                                 <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">Jan 5, 2022</td>
                                 <td class="px-4 py-4 text-sm font-medium text-gray-700 whitespace-nowrap">
                                     <div class="inline-flex items-center px-3 py-1 text-green-500 rounded-full gap-x-2 bg-red-100/60 dark:bg-gray-800">
                                       
                                         <h2 class="text-sm font-normal">'. $rows["status"] .'</h2>
                                     </div>
                                 </td>
                                 <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">
                                     <div class="flex items-center gap-x-2">
                                         <img class="object-cover w-8 h-8 rounded-full" src="https://images.unsplash.com/photo-1531590878845-12627191e687?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=764&q=80" alt="">
                                         <div>
                                             <h2 class="text-sm font-medium text-gray-800 dark:text-white ">'. $rows["name"] .'</h2>
                                             <p class="text-xs font-normal text-gray-600 dark:text-gray-400">'. $rows["email"] .'</p>
                                         </div>
                                     </div>
                                 </td>
                                 <td class="px-4 py-4 text-sm text-gray-500 dark:text-gray-300 whitespace-nowrap">'. $rows["phone"] .'</td>
                                 <td class="px-4 py-4 text-sm whitespace-nowrap">
                                     <div class="flex items-center gap-x-6">
                                         <button class="text-gray-500 transition-colors duration-200 dark:hover:text-indigo-500 dark:text-gray-300 hover:text-indigo-500 focus:outline-none">
                                         '. $rows["gnumber"] .'
                                         </button>
 
                                         <button class="text-blue-500 transition-colors duration-200 hover:text-indigo-500 focus:outline-none"
                                         onclick="handleClick(\''. $rows["gatepassno"] .'\')">
                                    
                                     Delete
                                 </button>
                                     </div>
                                 </td>
                             </tr>';
                                }
                            }
                            else{
                                echo '<div class="flex items-center justify-center h-96">
                                <h1 class="text-2xl text-gray-500">No Application Found</h1>
                            </div>';
                            }
                        }
                        else{
                            echo '<div class="flex items-center justify-center h-96">
                            <h1 class="text-2xl text-gray-500">We are facing some technical issue please try again after some time</h1>
                        </div>';
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
function handleClick(gatepassno) {
   console.log(gatepassno);
   var xhr = new XMLHttpRequest();
    xhr.open("POST", "allapplication.php", true); // Assuming the PHP script is in the same directory
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onreadystatechange = function() {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // Handle response from PHP script if needed
                alert("Application Deleted Successfully");
                window.location.reload();
            } else {
                // Handle error
                console.error('Error:', xhr.status);
            }
        }
    };
    xhr.send("gatepassno=" + encodeURIComponent(gatepassno));
}
</script>

</body>
</html>