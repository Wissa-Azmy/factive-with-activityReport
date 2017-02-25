<?php 
$this->Scope->check_session();
if(!isset($page_title)){$page_title='';}else{$page_title = $page_title . ' | ';}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<meta name="description" content="Sanofi Admin Panel" />
	<meta name="author" content="" />
	<title><?=$page_title?>factive survey</title>
	<link rel="stylesheet" href="<?=base_url()?>data/admin/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?=base_url()?>data/admin/css/font-icons/entypo/css/entypo.css">
    <link href='http://fonts.googleapis.com/css?family=Amiri:400,700,400&subset=arabic,latin' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="<?=base_url()?>data/admin/css/bootstrap.css">
	<link rel="stylesheet" href="<?=base_url()?>data/admin/css/art-forms.css">
	<link rel="stylesheet" href="<?=base_url()?>data/admin/css/art-core.css">
	<link rel="stylesheet" href="<?=base_url()?>data/admin/css/art-theme.css">
	<script src="<?=base_url()?>data/admin/js/jquery-1.11.0.min.js"></script>
        <script>
            jQuery(document).ready(function(){
                jQuery("img").error(
                    function () {
                        jQuery(this).unbind("error").attr("src", "<?=  base_url()?>data/logo.png");
                    }
                );
            })  
            var del_massage = 'Are you sure you want to delete the item?';
            var undel_massage = 'Are you sure you want to cancel the deletion?';
            </script>
	<!--[if lt IE 9]><script src="<?=base_url()?>data/admin/js/ie8-responsive-file-warning.js"></script><![endif]-->
	<!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
		<script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
	<![endif]-->
	<style>
	    .pagination {
    text-align: center;
    width: 100%;
	}
    .pagination a {  
    border-radius: 5px;
    font-size: 12px;
    padding: 4px 5px;
	}
	</style>
    </head>
    <body class="page-body" >

    <div class="page-container horizontal-menu with-sidebar fit-logo-with-sidebar">
	<header class="navbar navbar-fixed-top">
            <div class="navbar-inner">
                <!-- logo -->
                <div class="navbar-brand">
                    <a href="<?=base_url()?>/admin">
                            <img src="<?=base_url()?>data/logo.png" height="60" alt="" />
                    </a>
                </div>
                <div class="visible-xs">
                    <div class="clearfix"></div>
                    <ul class="navbar-nav ">
                        <?=$this->load->view('admin/nav','', true)?>
                    </ul>
                </div>
                <!-- notifications and other links -->
                <ul class="nav navbar-right pull-right">
                    <!-- raw links -->
                    <li class="sep"></li>
                    <li>
                        <a href="<?=base_url()?>admin/logout">
                                Logout <i class="entypo-logout right"></i>
                        </a>
                    </li>
                    <!-- mobile only -->
                    <li class="visible-xs">
                        
                        <div class="horizontal-mobile-menu visible-xs">
                            <a href="#main-menu" class="with-animation">
                                <i class="entypo-menu"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </div>
	</header>
	<div class="sidebar-menu">
            <div class="sidebar-menu-inner">
                <ul id="main-menu" class="main-menu multiple-expanded auto-inherit-active-class ">
                    <?=$this->load->view('admin/nav','', true)?>
                </ul>  
                <div class="hidden-xs">
                    <div class="sidebar-collapse">
                        <a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
                            <i class="entypo-menu"></i>
                        </a>
                    </div>
                </div>
            </div>
	</div>	
	<div class="main-content">


            <?php $dd = $this->session->flashdata('error');if(!empty($dd)){ ?>
                <div class="alert alert-danger"><strong>Error !</strong> <p><?=$dd?></p></div>
            <?php } ?>



            <?php $dd = $this->session->flashdata('good');if(!empty($dd)){ ?>
                <div class="alert alert-success"><strong>Done !</strong> <p><?=$dd?></p></div>
            <?php } ?>

            <?php 	echo $this->load->view($page,'', true);        ?>
            <div class="clearfix"></div>
            <!-- Footer -->
            <footer class="main">
             
                    &copy; 2017 <strong>Scope </strong> 
            </footer>	
        </div>
    </div>
        


	<!-- Bottom scripts (common) -->
	<script src="<?=base_url()?>data/admin/js/gsap/main-gsap.js"></script>
	<script src="<?=base_url()?>data/admin/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?=base_url()?>data/admin/js/bootstrap.js"></script>
	<script src="<?=base_url()?>data/admin/js/joinable.js"></script>
	<script src="<?=base_url()?>data/admin/js/resizeable.js"></script>
	<script src="<?=base_url()?>data/admin/js/art-api.js"></script>
	<script src="<?=base_url()?>data/admin/js/wysihtml5/wysihtml5-0.4.0pre.min.js"></script>
	<script src="<?=base_url()?>data/admin/js/toastr.js"></script>

        

        <?php if(isset($send_to_footer)){echo $send_to_footer;} ?>        
      
	<!-- JavaScripts initializations and stuff -->
	<script src="<?=base_url()?>data/admin/js/art-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?=base_url()?>data/admin/js/art-demo.js"></script>

        <?php $just_log = $this->session->flashdata('just_login');if(!empty($just_log)){?>
        <script>
            
        </script>
        <?php } ?>

</body>
</html>