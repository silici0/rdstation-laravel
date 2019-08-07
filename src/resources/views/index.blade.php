<!DOCTYPE html>
<html lang="en">
<head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
      <title>Integração RDStation</title>
</head>
    <body>
      Integração RDStation
      <a href="<?php 
      $str = URL::to('/').'/rdstation';
      print 'https://api.rd.services/auth/dialog?client_id='.$client_id.'&redirect_url='.$str;?>">INTEGRAR
      </a>
    </body>
</html>