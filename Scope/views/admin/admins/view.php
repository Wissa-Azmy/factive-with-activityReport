<h1 class="margin-bottom"><?php echo @$admins[0]->first_name . ' ' . $admins[0]->last_name; ?></h1>

<ol class="breadcrumb">
    <li>
        <a href="<?=  base_url()?>admin"><i class="fa-home"></i>Home</a>
    </li>
    <li>
        <a href="<?=  base_url()?>admin/admins"><i class="fa-home"></i>Administrators</a>
    </li>
    <li class="active">
        <strong><?php echo @$admins[0]->first_name . ' ' . $admins[0]->last_name; ?></strong>
    </li>
</ol>
<div id="blog-landing">
    <?php foreach($admins as $admin){ ?>
    <div class="member-entry">
        <a href="<?=base_url()?>admin/admins/<?=$admin->id?>" class="member-img">
            <img src="<?=base_url()?><?=$admin->img_url?>" class="img-rounded">
                <i class="entypo-forward"></i>
        </a>
        <div class="member-details">
            <h4>
               
            </h4>
            <!-- Details with Icons -->
            <div class="row info-list">
                <div class="col-sm-4">
                    <i class="entypo-briefcase"></i>
                    
                </div>
                <div class="col-sm-4">
                    <i class="entypo-user"></i>
                    <a href="#">@<?=$admin->username?></a>
                </div>
                <div class="col-sm-4">
                    <i class="entypo-facebook"></i>
                    <a href="#"><?=$admin->facebook?></a>
                </div>
                <div class="clear"></div>
                <div class="col-sm-4">
                    <i class="entypo-location"></i>
                    <a href="#"><?=$admin->address?></a>
                </div>
                <div class="col-sm-4">
                    <i class="entypo-mail"></i>
                    <a href="#"><?=$admin->email?></a>
                </div>
                <div class="col-sm-4">
                    <i class="entypo-phone"></i>
                    <a href="#"><?=$admin->phone?></a>
                </div>
            </div>
            <div class="tools-user-admin">
                <?php
                if($this->Scope->check_view_actions('2','admins', 'edit','') == 1){?>
                    <a href="<?=base_url()?>admin/admins/edit/<?=$admin->id?>" class="btn btn-default btn-sm btn-icon icon-left">
                        <i class="entypo-pencil"></i>
                        Edit
                    </a>
                <?php }?>
                <?php if($this->Scope->check_view_actions('2','admins', 'delete','') == 1){?>
                    <a type="button"onclick="return confirm(del_massage);" href="<?=  base_url().'admin/admins/delete/'.$admin->id?>" class="btn btn-red btn-icon">
                                    <i class="entypo-cancel"></i>
                        Delete
                    </a>
                <?php }?>
                <?php if($this->Scope->check_view_actions('2','admins', 'view','') == 1){?>
                    <a href="<?=base_url()?>admin/admins/<?=$admin->id?>" class="btn btn-info btn-sm btn-icon icon-left">
                        <i class="entypo-info"></i>
                        Profile
                    </a>
                <?php }?>
               
            </div>
        </div>
    </div>
    <?php } ?> 
    
</div>