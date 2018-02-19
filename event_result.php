<?php header("Content-Type:text/html;charset=utf-8"); 
    include("./backend/get_event_result.php") 
?>
<!DOCTYPE html>
<html>
<head>
    <!-- <meta charset="utf-8"> -->
    
    <title>BLOCKS - Bootstrap Dashboard Theme</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Carlos Alvarez - Alvarez.is">

    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.min.css" />
    <link href="css/main.css" rel="stylesheet">
    <link href="css/font-style.css" rel="stylesheet">
    <link href="css/flexslider.css" rel="stylesheet">
    <!-- DATA TABLE CSS -->
    <link href="css/table.css" rel="stylesheet">


    <!-- JQUERY -->
    <script
    src="http://code.jquery.com/jquery-2.2.4.js"
    integrity="sha256-iT6Q9iMJYuQiMWNd9lDyBUStIq/8PuOW33aOqmvFpqI="
    crossorigin="anonymous"></script>

    <!-- <script type="text/javascript" src="js/jquery.js"></script> -->
    <script type="text/javascript" src="bootstrap/js/bootstrap.min.js"></script>
    <!-- <script type="text/javascript" src="js/lineandbars.js"></script> -->

    <!-- <script type="text/javascript" src="js/dash-charts.js"></script>
    <script type="text/javascript" src="js/gauge.js"></script> -->

    <!-- NOTY JAVASCRIPT -->
    <script type="text/javascript" src="js/noty/jquery.noty.js"></script>
    <script type="text/javascript" src="js/noty/layouts/top.js"></script>
    <script type="text/javascript" src="js/noty/layouts/topLeft.js"></script>
    <script type="text/javascript" src="js/noty/layouts/topRight.js"></script>
    <script type="text/javascript" src="js/noty/layouts/topCenter.js"></script>

    <!-- You can add more layouts if you want -->
    <script type="text/javascript" src="js/noty/themes/default.js"></script>
    <!-- <script type="text/javascript" src="assets/js/dash-noty.js"></script> This is a Noty bubble when you init the theme-->
    <!-- <script type="text/javascript" src="http://code.highcharts.com/highcharts.js"></script> -->
    <script src="js/jquery.flexslider.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/admin.js"></script>

    <style type="text/css">
        body {
            padding-top: 60px;
        }
    </style>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
    <!-- Google Fonts call. Font Used Open Sans & Raleway -->
    <link href="http://fonts.googleapis.com/css?family=Raleway:400,300" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet" type="text/css">
    <script type="text/javascript">
    $(document).ready(function () {

        $("#btn-blog-next").click(function () {
            $('#blogCarousel').carousel('next')
        });
        $("#btn-blog-prev").click(function () {
            $('#blogCarousel').carousel('prev')
        });

        $("#btn-client-next").click(function () {
            $('#clientCarousel').carousel('next')
        });
        $("#btn-client-prev").click(function () {
            $('#clientCarousel').carousel('prev')
        });

        $('#click').click(function(){
            console.log('click');
            $.ajax({
                type: 'get',
                dataType: 'html',
                url: './backend/get_event_result.php',
                data: {m:'event', tid:'1', eid:'2'},
                success: function (data) {
                    console.log(data);
                    $("#event_result_tbody").html("");
                    $("#event_result_tbody").html(data);
                },
                error: function (request, status, error) {
                    console.log('code: '+request.status+"\n"+'message: '+request.responseText+"\n"+'error: '+error);
                }
            });
        });
        

    });

    $(window).load(function () {

        $('.flexslider').flexslider({
            animation: "slide",
            slideshow: true,
            start: function (slider) {
                $('body').removeClass('loading');
            }
        });
    });

    </script>
</head>
<body>

    <!-- NAVIGATION MENU -->
    <div class="navbar-nav navbar-inverse navbar-fixed-top">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">EVENT RESULT</a>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="main.html"><i class="icon-home icon-white"></i> Dashboard</a></li>
                    <li><a href="index.html"><i class="icon-home icon-white"></i> Final Score</a></li>
                </ul>
            </div><!--/.nav-collapse -->
        </div>
    </div>
    <div class="container">
        <!-- FIRST ROW OF BLOCKS -->
        <div class="row">
            <!-- DEFAULT BLOCK -->
            <div class="col-sm-6 col-lg-6 event-center">
                <button class="btn btn-primary" id="click">새로고침2222</button>
                <table class="display table-striped">                    
                    <thead>                        
                        <tr>
                            <th colspan="4" class="event-head">EVENT A</th>
                        </tr>
                        <tr>
                            <th>Rank</th>
                            <th>TeamName</th>
                            <th>BaseScore(ExtraScore)</th>
                            <th>Win</th>                            
                        </tr>
                    </thead>
                    <tbody id="event_result_tbody">
                        <?php 
                            echo getEventResultWithEventId(2);
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- End of First Row Line -->
        <!-- FIRST ROW OF BLOCKS -->
        <div class="row">
            

            <!-- DEFAULT BLOCK -->
            <div class="col-sm-3 col-lg-3">
                <div class="dash-unit">
                    <div class="dash-content">
                        <div id="hosting-table">
                            <div class="table_style4">
                                <div class="column">
                                    <ul>
                                        <li class="header_row">
                                            <h3>Free</h3>
                                        </li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><a class="btn btn-sm btn-primary" href="#">More...</a></li>

                                    </ul>
                                </div><!--/ column-->
                            </div><!--/ Table Style-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- DEFAULT BLOCK -->
            <div class="col-sm-3 col-lg-3">
                <div class="dash-unit">
                    <div class="dash-content">
                        <div id="hosting-table">
                            <div class="table_style4">
                                <div class="column">
                                    <ul>
                                        <li class="header_row">
                                            <h3>Free</h3>
                                        </li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><a class="btn btn-sm btn-primary" href="#">More...</a></li>

                                    </ul>
                                </div><!--/ column-->
                            </div><!--/ Table Style-->
                        </div>
                    </div>
                </div>
            </div>

            <!-- DEFAULT BLOCK -->
            <div class="col-sm-3 col-lg-3">
                <div class="dash-unit">
                    <div class="dash-content">
                        <div id="hosting-table">
                            <div class="table_style4">
                                <div class="column">
                                    <ul>
                                        <li class="header_row">
                                            <h3>Free</h3>
                                        </li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><p></p></li>
                                        <li><a class="btn btn-sm btn-primary" href="#">More...</a></li>

                                    </ul>
                                </div><!--/ column-->
                            </div><!--/ Table Style-->
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- End of First Row Line -->        


    </div> <!-- /container -->
    <div id="footerwrap">
        <footer class="clearfix"></footer>
        <div class="container">
            <div class="row">
                <div class="col-sm-12 col-lg-12">
                    <p><img src="images/logo.png" alt=""></p>
                    <p>Blocks Dashboard Theme - Crafted With Love - Copyright 2013</p>
                </div>
            </div><!-- /row -->
        </div><!-- /container -->
    </div><!-- /footerwrap -->

</body>
</html>