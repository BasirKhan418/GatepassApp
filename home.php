<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | GMS APP</title>
    <link href=”https://unpkg.com/tailwindcss@^1.0/dist/tailwind.min.css” rel=”stylesheet”>

    <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://cdn.tailwindcss.com?plugins=forms,typography,aspect-ratio,line-clamp"></script>
  <script src="https://kit.fontawesome.com/dbad016fd6.js" crossorigin="anonymous"></script>
</head>
<body>
   <?php
     session_start();
     if(!isset($_SESSION['loggedin']) || $_SESSION['loggedin']!=true){
      header("location: /gatepassapp/admin/adminlogin.php");
  }
   require "components/admin.php";
   require "components/_dbconnection.php";
  $sql = "SELECT * FROM usersdata";
  $result = mysqli_query($conn,$sql);
  $user = mysqli_num_rows($result);
  $sql = "SELECT * FROM gatepassdata";
  $result = mysqli_query($conn,$sql);
  $application = mysqli_num_rows($result);
  $sql = "SELECT * FROM gatepassdata WHERE `status` = 'Approved'";
  $result = mysqli_query($conn,$sql);
  $approved = mysqli_num_rows($result);
  $sql = "SELECT * FROM gatepassdata WHERE `status` = 'Pending'";
  $result = mysqli_query($conn,$sql);
  $pending = mysqli_num_rows($result);
  $sql= "SELECT * FROM gatepassdata WHERE `status` = 'Rejected'";
  $result = mysqli_query($conn,$sql);
  $rejected = mysqli_num_rows($result);
   ?>
 <section class="absolute left-72 top-20">

    <div class="grid grid-cols-1 gap-4 px-4 mt-8 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 sm:px-8">
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-green-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                </path>
            </svg></div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Users</h3>
            <p class="text-3xl"><?php echo $user;?></p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-blue-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7v8a2 2 0 002 2h6M8 7V5a2 2 0 012-2h4.586a1 1 0 01.707.293l4.414 4.414a1 1 0 01.293.707V15a2 2 0 01-2 2h-2M8 7H6a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2v-2">
                </path>
            </svg></div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Application</h3>
            <p class="text-3xl"><?php echo $application;?></p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-indigo-400"><i class="fa-solid fa-table text-4xl text-white"></i></div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Total Approval Rate</h3>
            <p class="text-3xl"><?php echo floor(($approved/$application)*100);?>%</p>
        </div>
    </div>
    <div class="flex items-center bg-white border rounded-sm overflow-hidden shadow">
        <div class="p-4 bg-red-400"><svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-white" fill="none"
                viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4">
                </path>
            </svg></div>
        <div class="px-4 text-gray-700">
            <h3 class="text-sm tracking-wider">Not Viewed (Pending)</h3>
            <p class="text-3xl"><?php echo floor(($pending/$application)*100);?>% (<?php echo $pending;?>)</p>
        </div>
    </div>
</div>
<section class="flex justify-start my-4 flex-wrap items-center">
<div class="relative flex flex-col rounded-xl bg-white bg-clip-border text-gray-700 shadow-md">
  <div class="relative mx-4 mt-4 flex flex-col gap-4 overflow-hidden rounded-none bg-transparent bg-clip-border text-gray-700 shadow-none md:flex-row md:items-center">
    <div class="w-max rounded-lg bg-gray-900 p-5 text-white">
      <svg
        xmlns="http://www.w3.org/2000/svg"
        fill="none"
        viewBox="0 0 24 24"
        stroke-width="1.5"
        stroke="currentColor"
        aria-hidden="true"
        class="h-6 w-6"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          d="M6.429 9.75L2.25 12l4.179 2.25m0-4.5l5.571 3 5.571-3m-11.142 0L2.25 7.5 12 2.25l9.75 5.25-4.179 2.25m0 0L21.75 12l-4.179 2.25m0 0l4.179 2.25L12 21.75 2.25 16.5l4.179-2.25m11.142 0l-5.571 3-5.571-3"
        ></path>
      </svg>
    </div>
    <div>
      <h6 class="block font-sans text-base font-semibold leading-relaxed tracking-normal text-blue-gray-900 antialiased">
        GMS - Application Data
      </h6>
      <p class="block max-w-sm font-sans text-sm font-normal leading-normal text-gray-700 antialiased">
        Visualize the gatePass data in a bar chart.
      </p>
    </div>
  </div>
  <div class="pt-6 px-2 pb-0">
    <div id="bar-chart"></div>
  </div>
</div>
 
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
const chartConfig = {
  series: [
    {
      name: "Applications",
      data: [50, 40, 300, 320, 500, 350, 200, 230, 500],
    },
  ],
  chart: {
    type: "bar",
    height: 240,
    toolbar: {
      show: false,
    },
  },
  title: {
    show: "",
  },
  dataLabels: {
    enabled: false,
  },
  colors: ["#020617"],
  plotOptions: {
    bar: {
      columnWidth: "40%",
      borderRadius: 2,
    },
  },
  xaxis: {
    axisTicks: {
      show: false,
    },
    axisBorder: {
      show: false,
    },
    labels: {
      style: {
        colors: "#616161",
        fontSize: "12px",
        fontFamily: "inherit",
        fontWeight: 400,
      },
    },
    categories: [
      "Apr",
      "May",
      "Jun",
      "Jul",
      "Aug",
      "Sep",
      "Oct",
      "Nov",
      "Dec",
    ],
  },
  yaxis: {
    labels: {
      style: {
        colors: "#616161",
        fontSize: "12px",
        fontFamily: "inherit",
        fontWeight: 400,
      },
    },
  },
  grid: {
    show: true,
    borderColor: "#dddddd",
    strokeDashArray: 5,
    xaxis: {
      lines: {
        show: true,
      },
    },
    padding: {
      top: 5,
      right: 20,
    },
  },
  fill: {
    opacity: 0.8,
  },
  tooltip: {
    theme: "dark",
  },
};
 
const chart = new ApexCharts(document.querySelector("#bar-chart"), chartConfig);
 
chart.render();
</script>
<div>
<div class="relative flex flex-col text-gray-700 bg-white shadow-md bg-clip-border rounded-xl w-96">
  <div class="relative mx-4 mt-4 overflow-hidden text-gray-700 bg-white shadow-lg bg-clip-border rounded-xl h-80">
    <img src="/gatepassapp/images/login.jpg" alt="profile-picture" />
  </div>
  <div class="p-6 text-center">
    <h4 class="block mb-2 font-sans text-2xl antialiased font-semibold leading-snug tracking-normal text-blue-gray-900">
      <?php
      echo $_SESSION['email'];
      ?>
    </h4>
    <p
      class="font-bold text-blue-600">
      Hii, Welcome Back Admin !
    </p>
  </div>
  <div class="flex justify-center p-6 pt-2 gap-7">
    <a href="#facebook"
      class="block font-sans text-xl antialiased font-normal leading-relaxed text-transparent bg-clip-text bg-gradient-to-tr from-blue-600 to-blue-400">
      <i class="fab fa-facebook" aria-hidden="true"></i>
    </a>
    <a href="#twitter"
      class="block font-sans text-xl antialiased font-normal leading-relaxed text-transparent bg-clip-text bg-gradient-to-tr from-light-blue-600 to-light-blue-400">
      <i
        class="fab fa-twitter" aria-hidden="true">
      </i>
    </a>
    <a href="#instagram"
      class="block font-sans text-xl antialiased font-normal leading-relaxed text-transparent bg-clip-text bg-gradient-to-tr from-purple-600 to-purple-400"><i
        class="fab fa-instagram" aria-hidden="true">
      </i>
    </a>
  </div>
</div>
</div>
<section class="w-[20vw] h-[60vh]">
  <!-- Card -->
  <div class="flex flex-col gap-y-3 lg:gap-y-5 p-4 md:p-5 bg-white border shadow-sm rounded-xl dark:bg-neutral-900 dark:border-neutral-800">
      <div class="inline-flex justify-center items-center">
        <span class="size-2 inline-block bg-red-500 rounded-full me-2"></span>
        <span class="text-xs font-semibold uppercase text-gray-600 dark:text-neutral-400">Rejected Applications</span>
      </div>

      <div class="text-center">
        <h3 class="text-3xl sm:text-4xl lg:text-5xl font-semibold text-gray-800 dark:text-neutral-200">
          <?php echo $rejected;?>
        </h3>
      </div>

      <dl class="flex justify-center items-center divide-x divide-gray-200 dark:divide-neutral-800">
        <dt class="pe-3">
          <span class="text-red-600">
            <svg class="inline-block size-4 self-center" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
              <path fill-rule="evenodd" d="M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z"/>
            </svg>
            <span class="inline-block text-sm">
              <?php echo floor(($rejected/$application)*100)?>%
            </span>
          </span>
          <span class="block text-sm text-gray-500 dark:text-neutral-500">In Percentage</span>
        </dt>
       
      </dl>
    </div>
</section>
</section>

 </section>
</body>
</html>