<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=\, initial-scale=1.0">
    <title>User Panel</title>
    <script src="https://kit.fontawesome.com/dbad016fd6.js" crossorigin="anonymous"></script>
</head>
<body>
    <?php
    session_start();
    if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
        header("location: /gatepassapp/login.php");
    }
   require "components/user.php";
   require "components/_dbconnection.php";
   $sql = "SELECT * FROM `gatepassdata` WHERE email = '$_SESSION[email]'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_num_rows($result);
    $sql = "SELECT * FROM `gatepassdata` WHERE email = '$_SESSION[email]' and status = 'Approved'";
    $result = mysqli_query($conn, $sql);
    $approved = mysqli_num_rows($result);
    $sql = "SELECT * FROM `gatepassdata` WHERE email = '$_SESSION[email]' and status = 'Pending'";
    $result = mysqli_query($conn, $sql);
    $pending = mysqli_num_rows($result);
    $sql = "SELECT * FROM `gatepassdata` WHERE email = '$_SESSION[email]' and status = 'Rejected'";
    $result = mysqli_query($conn, $sql);
    $rejected = mysqli_num_rows($result);
    ?>
<section class="absolute left-72 top-0">
<div class="container items-center px-4 py-8 m-auto mt-5 sm:mt-10 md:mt-20">
  <div class="flex flex-wrap pb-3 bg-white divide-y rounded-sm shadow-lg xl:divide-x xl:divide-y-0">
    <div class="w-full p-2 xl:w-1/4 sm:w-1/2">
      <div class="flex flex-col">
        <div class="flex flex-row items-center justify-between px-4 py-4">
          <div class="flex mr-4">
            <span class="items-center px-4 py-4 m-auto bg-blue-200 rounded-full hover:bg-blue-300">
            <i class="fa-solid fa-ticket text-2xl text-blue-800"></i>
            </span>
          </div>
          <div class="flex-1 pl-1">
            <div class="text-xl font-medium text-gray-600"><?php echo $row;?></div>
            <div class="text-sm text-gray-400 sm:text-base">
              All GatePasses
            </div>
          </div>
        </div>
        <div class="px-4 pt-px">
          <div class="w-full h-2 bg-gray-200 rounded-md hover:bg-gray-300">
            <div class="h-2 bg-blue-500 rounded-md hover:bg-blue-600" style="width: 83%"></div>
          </div>
          <div class="flex flex-row items-center justify-between w-full py-px text-base text-gray-400">
            <p class="flex">change</p>
            <div class="flex items-center justify-between space-x-2">
              <p>83%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full p-2 xl:w-1/4 sm:w-1/2">
      <div class="flex flex-col">
        <div class="flex flex-row items-center justify-between px-4 py-4">
          <div class="flex mr-4">
            <span class="items-center px-4 py-4 m-auto bg-red-200 rounded-full hover:bg-red-300">
            <i class="fa-solid fa-percent  text-2xl text-red-800"></i>
            </span>
          </div>
          <div class="flex-1 pl-1">
            <div class="text-xl font-medium text-gray-600"><?php echo ($approved/$row)*100;?>%</div>
            <div class="text-sm text-gray-400 sm:text-base">
              Approved Rate
            </div>
          </div>
        </div>
        <div class="px-4 pt-px">
          <div class="w-full h-2 bg-gray-200 rounded-md hover:bg-gray-300">
            <div class="h-2 bg-red-500 rounded-md hover:bg-red-600" style="width: 78%"></div>
          </div>
          <div class="flex flex-row items-center justify-between w-full py-px text-base text-gray-400">
            <p class="flex">change</p>
            <div class="flex items-center justify-between space-x-2">
              <p><?php echo ($approved/$row)*100;?>%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full p-2 xl:w-1/4 sm:w-1/2">
      <div class="flex flex-col">
        <div class="flex flex-row items-center justify-between px-4 py-4">
          <div class="flex mr-4">
            <span class="items-center px-4 py-4 m-auto bg-yellow-200 rounded-full hover:bg-yellow-300">
              <svg xmlns="http://www.w3.org/2000/svg" class="items-center w-8 h-8 m-auto text-yellow-500 hover:text-yellow-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
              </svg>
            </span>
          </div>
          <div class="flex-1 pl-1">
            <div class="text-xl font-medium text-gray-600"><?php echo $pending;?></div>
            <div class="text-sm text-gray-400 sm:text-base">
              Pending GatePasses
            </div>
          </div>
        </div>
        <div class="px-4 pt-px">
          <div class="w-full h-2 bg-gray-200 rounded-md hover:bg-gray-300">
            <div class="h-2 bg-yellow-500 rounded-md hover:bg-yellow-600" style="width: 86%"></div>
          </div>
          <div class="flex flex-row items-center justify-between w-full py-px text-base text-gray-400">
            <p class="flex">change</p>
            <div class="flex items-center justify-between space-x-2">
              <p><?php echo ($pending/$row)/100?>%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="w-full p-2 xl:w-1/4 sm:w-1/2">
      <div class="flex flex-col">
        <div class="flex flex-row items-center justify-between px-4 py-4">
          <div class="flex mr-4">
            <span class="items-center px-4 py-4 m-auto bg-green-200 rounded-full hover:bg-green-300">
             
<i class="fa-solid fa-xmark text-2xl text-red-800"></i>
            </span>
          </div>
          <div class="flex-1 pl-1">
            <div class="text-xl font-medium text-gray-600"><?php echo ($rejected/$row)*100;?>%</div>
            <div class="text-sm text-gray-400 sm:text-base">
              Rejection Rate
            </div>
          </div>
        </div>
        <div class="px-4 pt-px">
          <div class="w-full h-2 bg-gray-200 rounded-md hover:bg-gray-300">
            <div class="h-2 bg-green-500 rounded-md hover:bg-green-600" style="width: 79%"></div>
          </div>
          <div class="flex flex-row items-center justify-between w-full py-px text-base text-gray-400">
            <p class="flex">change</p>
            <div class="flex items-center justify-between space-x-2">
              <p><?php echo ($rejected/$row)*100;?>%</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<section class="flex flex-row  sm:flex-warp">
    
<!-- https://gist.github.com/goodreds/5b8a4a2bf11ff67557d38c5e727ea86c -->

<div
    class="max-w-2xl mx-4 sm:max-w-sm md:max-w-sm lg:max-w-sm xl:max-w-sm  bg-white shadow-xl rounded-lg text-gray-900">
    <div class="rounded-t-lg h-32 overflow-hidden">
        <img class="object-cover object-top w-full" src='https://images.unsplash.com/photo-1549880338-65ddcdfd017b?ixlib=rb-1.2.1&q=80&fm=jpg&crop=entropy&cs=tinysrgb&w=400&fit=max&ixid=eyJhcHBfaWQiOjE0NTg5fQ' alt='Mountain'>
    </div>
    <div class="mx-auto w-32 h-32 relative -mt-16 border-4 border-white rounded-full overflow-hidden">
        <img class="object-cover object-center h-32" src='https://cutm.ac.in/wp-content/uploads/Centurion_University_of_Technology_and_Management_Logo.webp' alt='Woman looking front'>
    </div>
    <div class="text-center mt-2">
        <h2 class="font-semibold"><?php echo $_SESSION['name'];?></h2>
        <p class="text-gray-500"><?php echo $_SESSION['email'];?></p>
    </div>
    <ul class="py-4 mt-2 text-gray-700 flex items-center justify-around">
        <li class="flex flex-col items-center justify-around">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M10 15l-5.878 3.09 1.123-6.545L.489 6.91l6.572-.955L10 0l2.939 5.955 6.572.955-4.756 4.635 1.123 6.545z" />
            </svg>
            <div>2k</div>
        </li>
        <li class="flex flex-col items-center justify-between">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M7 8a4 4 0 1 1 0-8 4 4 0 0 1 0 8zm0 1c2.15 0 4.2.4 6.1 1.09L12 16h-1.25L10 20H4l-.75-4H2L.9 10.09A17.93 17.93 0 0 1 7 9zm8.31.17c1.32.18 2.59.48 3.8.92L18 16h-1.25L16 20h-3.96l.37-2h1.25l1.65-8.83zM13 0a4 4 0 1 1-1.33 7.76 5.96 5.96 0 0 0 0-7.52C12.1.1 12.53 0 13 0z" />
            </svg>
            <div>10k</div>
        </li>
        <li class="flex flex-col items-center justify-around">
            <svg class="w-4 fill-current text-blue-900" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                <path
                    d="M9 12H1v6a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-6h-8v2H9v-2zm0-1H0V5c0-1.1.9-2 2-2h4V2a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v1h4a2 2 0 0 1 2 2v6h-9V9H9v2zm3-8V2H8v1h4z" />
            </svg>
            <div>15</div>
        </li>
    </ul>
    <div class="p-4 border-t mx-8 mt-2">
        <button class="w-1/2 block mx-auto rounded-full bg-gray-900 hover:shadow-lg font-semibold text-white px-6 py-2">Follow</button>
    </div>
</div>
<section>
<!-- Icon Blocks -->
<div class="max-w-[85rem] px-4 py-10 sm:px-6 lg:px-8 ">
  <div class="grid sm:grid-cols-2 lg:grid-cols-3 items-center  gap-6">
    <!-- Card -->
    <a class="group flex gap-y-6 size-full hover:bg-gray-100 rounded-lg p-5 transition-all dark:hover:bg-neutral-800 dark:focus:outline-none dark:focus:outline-none dark:focus:bg-neutral-800" href="#">
      <svg class="flex-shrink-0 size-8 text-gray-800 mt-0.5 me-6 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="13.5" cy="6.5" r=".5"/><circle cx="17.5" cy="10.5" r=".5"/><circle cx="8.5" cy="7.5" r=".5"/><circle cx="6.5" cy="12.5" r=".5"/><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/></svg>

      <div>
        <div>
          <h3 class="block font-bold text-gray-800 dark:text-white">Create Your Account</h3>
          <p class="text-gray-600 dark:text-neutral-400">The simplest way to keep your portfolio always up-to-date.</p>
        </div>

        <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200">
          Learn more
          <svg class="flex-shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </p>
      </div>
    </a>
    <!-- End Card -->

    <!-- Card -->
    <a class="group flex gap-y-6 size-full hover:bg-gray-100 rounded-lg p-5 transition-all dark:hover:bg-neutral-800 dark:focus:outline-none dark:focus:outline-none dark:focus:bg-neutral-800" href="#">
      <svg class="flex-shrink-0 size-8 text-gray-800 mt-0.5 me-6 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h20"/><path d="M21 3v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V3"/><path d="m7 21 5-5 5 5"/></svg>

      <div>
        <div>
          <h3 class="block font-bold text-gray-800 dark:text-white">Get applied for gatepass</h3>
          <p class="text-gray-600 dark:text-neutral-400">Apply for gatepass with in 1min .It is that much easy</p>
        </div>

        <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200">
          Learn more
          <svg class="flex-shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </p>
      </div>
    </a>
    <!-- End Card -->

    <!-- Card -->
    <a class="group flex gap-y-6 size-full hover:bg-gray-100 rounded-lg p-5 transition-all dark:hover:bg-neutral-800 dark:focus:outline-none dark:focus:outline-none dark:focus:bg-neutral-800" href="#">
      <svg class="flex-shrink-0 size-8 text-gray-800 mt-0.5 me-6 dark:text-neutral-200" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/><path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/><path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2v0a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12v0a2 2 0 0 1-2-2V7"/></svg>

      <div>
        <div>
          <h3 class="block font-bold text-gray-800 dark:text-white">Approved/Rejected </h3>
          <p class="text-gray-600 dark:text-neutral-400">Approved or rejection based on your reason anf guardian permission</p>
        </div>

        <p class="mt-3 inline-flex items-center gap-x-1 text-sm font-semibold text-gray-800 dark:text-neutral-200">
          Learn more
          <svg class="flex-shrink-0 size-4 transition ease-in-out group-hover:translate-x-1 group-focus:translate-x-1" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="m9 18 6-6-6-6"/></svg>
        </p>
      </div>
    </a>
    <!-- End Card -->
  </div>
</div>
<!-- End Icon Blocks -->

</section>
</section>

</section>
</body>
</html>