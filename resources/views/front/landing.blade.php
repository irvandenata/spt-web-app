<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Landing Pange</title>
  <style>
    @font-face {
      font-family: poppins;
      src: url({{ asset('assets/fonts/Poppins-Thin.otf') }});

    }

    @font-face {
      font-family: poppins-semi-bold;
      src: url({{ asset('assets/fonts/Poppins-SemiBold.otf') }});
    }

    @font-face {
      font-family: poppins-light;
      src: url({{ asset('assets/fonts/Poppins-Light.otf') }});
    }

    @font-face {
      font-family: poppins-regular;
      src: url({{ asset('assets/fonts/Poppins-Regular.otf') }});
    }

    body {
      font-family: poppins-light;
    }

    h1 {
      font-family: poppins-semi-bold;
    }

    p {
      font-family: poppins-light;
    }


    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }


    section {
      scroll-snap-align: start;
      width: 100%;
      height: 100vh;
      scroll-snap-stop: always;
    }

    .container {
      scroll-snap-type: y mandatory;
      overflow-y: scroll;

      height: 100vh;
    }

    .container::-webkit-scrollbar {
      display: none;
    }

    .header {
      padding: 0 30px;
      height: 125vh;
      position: relative;
      color: white;
      background-color: rgb(32, 32, 32);
    }




    .two {
      background-color: red;
      height: 125vh;

    }

    .three {
      background-color: green;
      height: 125vh;

    }

    .four {
      background-color: blue;
      height: 125vh;

    }

    .item {
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;

      height: 100vh;
    }

    .logo {
      position: absolute;
      top: 3%;
      transform: translateY(-3%);
      width: 150px;
      height: 55px;
      display: flex;
      justify-content: center;
      align-items: center;
      border-radius: 5px;
    }

    .web-name {
      margin-left: 10px;
      font-weight: 900;
      font-size: 20px;
      font-family: poppins-semi-bold;
    }
    nav{
        padding: 0 30px;
        position: absolute;
        top: 3%;
        height: 100px;
        width: 100%;
        z-index: 999;
        color: white;
    }

    .nav-bar {
      position: absolute;
      top: 3%;
      right: 3%;
      width:50px;
      height:50px;
      transform: translateY(-3%);
      display: flex;
      justify-content: center;
      align-items: center;
      background-color: rgb(54, 54, 54);
      padding: 15px;
      border-radius: 25px;
      transition: width 0.5s ease-in-out;
    }

    .nav-bar:hover {
        width: 400px;
    }






    .nav-item {
        display: none;
      margin: 0 20px;
      font-size: 18px;
      font-weight: 900;
      cursor: pointer;
      letter-spacing: 3px;
      color:white;
      transition: display 3s ease-in-out 5s;
    }

    .text-center {
      text-align: center;
    }

    .w-80 {
      width: 80%;
    }

    /* Header style */
    .header-text {
      font-size: 60px;
    }

    .subtitle {
      font-size: 16px;
    }

    .hide{
        display: none;
    }
  </style>
</head>

<body>
  <div class="container">
    <nav>
        <div class="logo">

            <span style="width: 35px"><img src="{{ App\Helpers\View::logo() }}" style="width: 100%" alt=""></span>
            <span class="web-name">{{ App\Helpers\View::websiteName() }}</span>
          </div>
          <div class="nav-bar" onmouseenter="showNavbar()" onmouseleave="hideNavbar()">
            <span class="nav-item">Home</span>
            <span class="nav-item">About</span>
            <span class="nav-item">Contact</span>
          </div>
    </nav>
    <section class="header">
      <div class="item">
        <h1 class="text-center header-text flex-1">WE GIVE SOLUTION<br>WE GIVE QUALITY FOR HUAMAN</h1>
        <p class="flex-1 text-center w-80 subtitle">Lorem ipsum, dolor sit amet consectetur adipisicing elit. Nulla
          exercitationem veniam unde est! Quidem numquam consectetur deserunt. Sint dolore voluptatem, accusantium,
          necessitatibus, laborum doloremque repellendus veritatis laudantium nam explicabo quae.</p>
      </div>
    </section>
    <section class="two">
      <div class="item">first</div>
    </section>
    <section class="three">
      <div class="item">first</div>
    </section>
    <section class="four">
      <div class="item">first</div>
    </section>
  </div>
  <script>
  </script>
</body>

</html>
