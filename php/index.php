<?php
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
include 'base.php';

if(session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div
  class="bg-image p-5 text-center shadow-1-strong rounded mb-5 text-muted"
  style="
    background-image: url('https://media.nomadicmatt.com/nycguide.jpg');
    height: 400px;
  "

  >
    
    <h1 class="mb-3 h2">Vaccination Central</h1>

  <p>
    Connect Patients and Providers.
  </p>
</div>
<section class="pt-4 pb-6">
    <section class="container">
        <div class="pb-lg-4">
            <p class="subtitle text-secondary">Covid Vaccination Guidelines</p>
            <h2 class="mb-5">What can we do for you?</h2>
        </div>
        <div class="row">
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="px-0 pr-lg-3">
                    <div class="icon-rounded mb-3 bg-secondary-light">
                        <svg class="svg-icon" width="54px" height="54px" fill = "#4691f6" viewBox="0 0 20 20">
                        <path d="M15.573,11.624c0.568-0.478,0.947-1.219,0.947-2.019c0-1.37-1.108-2.569-2.371-2.569s-2.371,1.2-2.371,2.569c0,0.8,0.379,1.542,0.946,2.019c-0.253,0.089-0.496,0.2-0.728,0.332c-0.743-0.898-1.745-1.573-2.891-1.911c0.877-0.61,1.486-1.666,1.486-2.812c0-1.79-1.479-3.359-3.162-3.359S4.269,5.443,4.269,7.233c0,1.146,0.608,2.202,1.486,2.812c-2.454,0.725-4.252,2.998-4.252,5.685c0,0.218,0.178,0.396,0.395,0.396h16.203c0.218,0,0.396-0.178,0.396-0.396C18.497,13.831,17.273,12.216,15.573,11.624 M12.568,9.605c0-0.822,0.689-1.779,1.581-1.779s1.58,0.957,1.58,1.779s-0.688,1.779-1.58,1.779S12.568,10.427,12.568,9.605 M5.06,7.233c0-1.213,1.014-2.569,2.371-2.569c1.358,0,2.371,1.355,2.371,2.569S8.789,9.802,7.431,9.802C6.073,9.802,5.06,8.447,5.06,7.233 M2.309,15.335c0.202-2.649,2.423-4.742,5.122-4.742s4.921,2.093,5.122,4.742H2.309z M13.346,15.335c-0.067-0.997-0.382-1.928-0.882-2.732c0.502-0.271,1.075-0.429,1.686-0.429c1.828,0,3.338,1.385,3.535,3.161H13.346z"></path>
                      </svg>
                    </div>
                    <h3 class="h6 text-uppercase">Individual</h3>
                    <p class="text-muted text-sm">You can register in our system and get matched with Provider based on your availble time and location. You can decide to accept or decline the matched appointments as you want.
                    </p>
                </div>
            </div>
            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="px-0 pr-lg-3">
                    <div class="icon-rounded mb-3 bg-primary-light">
                      <svg class="svg-icon" width="54px" height="54px" fill = "#4691f6" viewBox="0 0 20 20">
                        <path d="M15.971,7.708l-4.763-4.712c-0.644-0.644-1.769-0.642-2.41-0.002L3.99,7.755C3.98,7.764,3.972,7.773,3.962,7.783C3.511,8.179,3.253,8.74,3.253,9.338v6.07c0,1.146,0.932,2.078,2.078,2.078h9.338c1.146,0,2.078-0.932,2.078-2.078v-6.07c0-0.529-0.205-1.037-0.57-1.421C16.129,7.83,16.058,7.758,15.971,7.708z M15.68,15.408c0,0.559-0.453,1.012-1.011,1.012h-4.318c0.04-0.076,0.096-0.143,0.096-0.232v-3.311c0-0.295-0.239-0.533-0.533-0.533c-0.295,0-0.534,0.238-0.534,0.533v3.311c0,0.09,0.057,0.156,0.096,0.232H5.331c-0.557,0-1.01-0.453-1.01-1.012v-6.07c0-0.305,0.141-0.591,0.386-0.787c0.039-0.03,0.073-0.066,0.1-0.104L9.55,3.75c0.242-0.239,0.665-0.24,0.906,0.002l4.786,4.735c0.024,0.033,0.053,0.063,0.084,0.09c0.228,0.196,0.354,0.466,0.354,0.76V15.408z"></path>
                  </svg>
                    </div>
                    <h3 class="h6 text-uppercase">Provider</h3>
                    <p class="text-muted text-sm">You can register in our system and provide us your location and available time slots. We will help to match your avaible time with Patients to get vaccinated.
                    </p>
                </div>
            </div>

            <div class="col-sm-6 col-lg-3 mb-3 mb-lg-0">
                <div class="px-0 pr-lg-3">
                    <div class="icon-rounded mb-3 bg-primary-light">
                        <svg class="svg-icon" width="54px" height="54px" fill = "#4691f6" viewBox="0 0 20 20">
                            <path d="M17.125,1.375H2.875c-0.828,0-1.5,0.672-1.5,1.5v11.25c0,0.828,0.672,1.5,1.5,1.5H7.75v2.25H6.625c-0.207,0-0.375,0.168-0.375,0.375s0.168,0.375,0.375,0.375h6.75c0.207,0,0.375-0.168,0.375-0.375s-0.168-0.375-0.375-0.375H12.25v-2.25h4.875c0.828,0,1.5-0.672,1.5-1.5V2.875C18.625,2.047,17.953,1.375,17.125,1.375z M11.5,17.875h-3v-2.25h3V17.875zM17.875,14.125c0,0.414-0.336,0.75-0.75,0.75H2.875c-0.414,0-0.75-0.336-0.75-0.75v-1.5h15.75V14.125z M17.875,11.875H2.125v-9c0-0.414,0.336-0.75,0.75-0.75h14.25c0.414,0,0.75,0.336,0.75,0.75V11.875z M10,14.125c0.207,0,0.375-0.168,0.375-0.375S10.207,13.375,10,13.375s-0.375,0.168-0.375,0.375S9.793,14.125,10,14.125z"></path>
                        </svg>
                    </div>
                    <h3 class="h6 text-uppercase">About Us</h3>
                    <p class="text-muted text-sm">We are here to create a covid-19 vaccination database. The system will allow for patients and providers to register with necessary information to create their private account. we determines which patients to offer appointments to based on their availability criteria and priority group. 
                    </p>
                </div>
            </div>
        </div>
    </section>
<!-- <?php
  if (isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true) {
    echo '<script type="text/javascript">
      document.getElementById("login").style.display = "none";
      document.getElementById("register").style.display = "none";
      document.getElementById("appointments").style.display = "block";
      document.getElementById("available_time").style.display = "block";
      document.getElementById("logout").style.display = "block";
    </script>';
  } else {
      echo '<script type="text/javascript">
      document.getElementById("login").style.display = "block";
      document.getElementById("register").style.display = "block";
      document.getElementById("appointments").style.display = "none";
      document.getElementById("available_time").style.display = "none";
      document.getElementById("logout").style.display = "none";
    </script>';
  }
?> -->


<footer class="position-relative z-index-10 d-print-none" >
  <!-- Copyright section of the footer-->
  <div class="py-4 font-weight-light bg-gray-800 text-gray-300">
      <div class="container text-md-center text-center">
          <p class="text-sm mb-md-0">&copy; 2021, Powered By Intelli-Trev</p>
      </div>
  </div>
</footer>