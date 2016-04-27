<!-- <!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head profile="http://gmpg.org/xfn/11"> -->

<!DOCTYPE html>
<html lang="en">
  <head>
    <head>
        <meta http-equiv="Content-Type" content="text/html" charset="UTF-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Domo-Cloud</title>

        <link rel="icon" href="../../favicon.ico">
        <link href="/css/style.css" rel="stylesheet" type="text/css" />
        <link href="/css/fullcalendar.css" rel="stylesheet" type="text/css" />
        <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
        <link href="/css/ie10-viewport-bug-workaround.css" rel="stylesheet">
        <link href="/css/dashboard.css" rel="stylesheet">
        <link href="/css/signin.css" rel="stylesheet">
        <!-- Bootstrap core CSS -->
        <link href="/css/bootstrap.min.css" rel="stylesheet">

        <script type='text/javascript' src='../js/jquery.min.js'></script>
        <script type='text/javascript' src='../js/moment.min.js'></script>
        <script type='text/javascript' src='../js/fullcalendar.js'></script>
        <script type='text/javascript' src='../js/fullcalendar-lang.js'></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/ie10-viewport-bug-workaround.js"></script>
    </head>
<body>

<div id="wrapper" class="dashboard">

<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Domo-Cloud</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a href="/">Dashboard</a></li>
                <li><a href="/?page=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">
    <div class="row">
        <div class="col-sm-3 col-md-2 sidebar">
            <ul class="nav nav-sidebar">
                    <?php
                    $stmt = $db->prepare("SELECT * FROM rooms WHERE client_id=:client_id");
                    $stmt->bindValue(':client_id', $user['id'], PDO::PARAM_INT);
                    $stmt->execute();
                    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
                    foreach($rooms as $room) {
                        if(IsSet($_GET['room_id']) && $_GET['room_id'] == $room['id']) {
                            $active = 'class="active"';
                        } else {
                            $active = '';
                        }
                        echo '<li '.$active.'><a href="/?page=room&room_id='.$room['id'].'">'.$room['name'].'</a></li>';
                    }
                    ?>
            </ul>
        </div>
        <div class="col-sm-9 col-md-10 main">