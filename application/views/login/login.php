<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<!-- BEGIN HEAD -->

<head>
    <meta charset="utf-8" />
    <title>GOHOLO | Login </title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <!-- BEGIN GLOBAL MANDATORY STYLES -->
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400,300,600,700&subset=all" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/simple-line-icons/simple-line-icons.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/css/bootstrap-switch.min.css" rel="stylesheet" type="text/css" />
    <!-- END GLOBAL MANDATORY STYLES -->
    <!-- BEGIN PAGE LEVEL PLUGINS -->
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/plugins/select2/css/select2-bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL PLUGINS -->
    <!-- BEGIN THEME GLOBAL STYLES -->
    <link href="<?php echo base_url(); ?>assets/global/css/components.min.css" rel="stylesheet" id="style_components" type="text/css" />
    <link href="<?php echo base_url(); ?>assets/global/css/plugins.min.css" rel="stylesheet" type="text/css" />
    <!-- END THEME GLOBAL STYLES -->
    <!-- BEGIN PAGE LEVEL STYLES -->
    <link href="<?php echo base_url(); ?>assets/pages/css/login-5.min.css" rel="stylesheet" type="text/css" />
    <!-- END PAGE LEVEL STYLES -->
    <!-- BEGIN THEME LAYOUT STYLES -->
    <!-- END THEME LAYOUT STYLES -->
    <link rel="shortcut icon" href="favicon.ico" /> </head>
    <!-- END HEAD -->

    <script type="text/javascript">

        let base_url = "<?php echo base_url() ?>";

    </script>

    <body class=" login">
        <!-- BEGIN : LOGIN PAGE 5-1 -->
        <div class="user-login-5">
            <div class="row bs-reset">
                <div class="col-md-6 bs-reset mt-login-5-bsfix">
                    <div class="login-bg" >
                         <img class="login-logo" src="<?php echo base_url(); ?>assets/pages/img/login/logo.png" /> 
                            
                        </div>
                    </div>
                    <div class="col-md-6 login-container bs-reset mt-login-5-bsfix">
                        <div class="login-content">
                            <h1>GOHOLO User Login</h1>
                            <form action="<?php echo base_url() ?>login/login_auth" class="login-form" method="post">

                              <?php
                              if ($this->session->flashdata("error")) {
                              ?>

                              <div class="alert alert-danger">
                                <button class="close" data-close="alert"></button>
                                <span><?php  echo $this->session->flashdata("error"); ?> </span>
                            </div>

                            <?php

                        }
                        ?>

                        <div class="row">
                            <div class="col-xs-6">
                                <input class="form-control form-control-solid placeholder-no-fix form-group" type="email" autocomplete="off" placeholder="Email" name="email" required/> </div>
                                <div class="col-xs-6">
                                    <input class="form-control form-control-solid placeholder-no-fix form-group" type="password" autocomplete="off" placeholder="Password" name="password" required/> </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-offset-4 col-sm-8 text-right">
                                        <button class="btn green" type="submit">Sign In</button>
                                    </div>
                                </div>
                            </form>

                        </div>
                        <div class="login-footer">
                            <div class="row bs-reset">
                                <div class="col-md-3"></div>

                                <div class="col-md-9 bs-reset">
                                    <div class="login-copyright text-right">
                                     <p>Copyright © GOHOLO Ads 2018  &nbsp;|&nbsp; Developed By 
                                        <a href="https://bitsclan.com" title="Bitsclan" target="_blank">Bitsclan Solution</a> </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END : LOGIN PAGE 5-1 -->
        <!--[if lt IE 9]>
<script src="../assets/global/plugins/respond.min.js"></script>
<script src="../assets/global/plugins/excanvas.min.js"></script> 
<![endif]-->
<!-- BEGIN CORE PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/js.cookie.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-slimscroll/jquery.slimscroll.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery.blockui.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/bootstrap-switch/js/bootstrap-switch.min.js" type="text/javascript"></script>
<!-- END CORE PLUGINS -->
<!-- BEGIN PAGE LEVEL PLUGINS -->
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/jquery.validate.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/jquery-validation/js/additional-methods.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/select2/js/select2.full.min.js" type="text/javascript"></script>
<script src="<?php echo base_url(); ?>assets/global/plugins/backstretch/jquery.backstretch.min.js" type="text/javascript"></script>
<!-- END PAGE LEVEL PLUGINS -->
<!-- BEGIN THEME GLOBAL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/global/scripts/app.min.js" type="text/javascript"></script>
<!-- END THEME GLOBAL SCRIPTS -->
<!-- BEGIN PAGE LEVEL SCRIPTS -->
<script src="<?php echo base_url(); ?>assets/pages/scripts/login-5.js" type="text/javascript"></script>
<!-- END PAGE LEVEL SCRIPTS -->
<!-- BEGIN THEME LAYOUT SCRIPTS -->
<!-- END THEME LAYOUT SCRIPTS -->
</body>

</html>
