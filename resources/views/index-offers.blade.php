<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title></title>
<link type="text/css" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,500,700" rel="stylesheet">
<link type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
<link type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link type="text/css" href="https://cdn.secure.website/ws/1631048375/library/ripples.min.css" rel="stylesheet"> 
<script type="text/javascript" async="" src="https://ssl.google-analytics.com/ga.js"></script>
<script async="" src="//connect.facebook.net/en_US/fbds.js"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script type="text/javascript" src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/arrive/2.4.1/arrive.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/material.min.js"></script>
<script type="text/javascript" src="https://cdn.secure.website/ws/1631048375/library/ui-common.min.js"></script>

<link href="{{ asset('css/app.css') }}" rel="stylesheet">
<script type="text/javascript">
  $(window).scroll(function() {
    if ($(this).scrollTop()>200)
     {
        $('.plan-sub').slideUp(500);
        $("hr").slideUp(500);
     }
    else
     {
      $('.plan-sub').slideDown(500);
      $("hr").slideDown(500);
     }
 });
</script>
</head>
@include('offers-header')
@include('footer')