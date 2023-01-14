<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tooth Fairy</title>

  <!-- 
    - favicon
  -->
  <link rel="shortcut icon" href="{{asset('favicon.svg')}}" type="image/svg+xml">

  <!-- 
    - custom css link
  -->
  <link rel="stylesheet" href="{{asset('custom/css/homepage.css')}}">

  <!-- 
    - google font link
  -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:wght@600;700;800&family=Roboto:wght@400;500;600&display=swap"
    rel="stylesheet">
</head>
<body>

{{-----Header Start----------}}
@include('home.header')
{{----- End------------}}


{{-----hero section-----------}}
@include('home.hero')
{{-----End-------------------}}



{{-----services----------}}
@include('home.services')
{{-----End-------------------}}



{{-----about---------}}
@include('home.about')
{{-----End-------------------}}



{{-----doctor---------}}
@include('home.doctor')
{{-----End-------------------}}



{{-----footer--------------}}
@include('home.footer')
{{-----end----------------}}  
</body>











