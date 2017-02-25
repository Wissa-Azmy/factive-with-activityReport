<h1 class="margin-bottom">Edit Administrator <?php if($user->id != $this->session->userdata('admin')->id){echo '  For  '.$user->first_name . ' ' . $user->last_name; }?></h1>
<ol class="breadcrumb">
    <li>
        <a href="<?=  base_url()?>admin"><i class="fa-home"></i>Home</a>
    </li>
    <li>
        <a href="<?=  base_url()?>admin/admins"><i class="fa-home"></i>Administrators</a>
    </li>
    <li class="active">
        <strong><?=$user->first_name . ' ' . $user->last_name; ?></strong>
    </li>
</ol>
<br>
<form role="form" method="post" class="form-horizontal form-groups-bordered validate" action="" novalidate="novalidate" enctype="multipart/form-data">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                            General Info
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <?php                                         echo $this->form_builder->build_form_horizontal(
                        array(
                            array(
                                 'id' => 'First Name',                                'placeholder' => 'First Name',
                                'value' => ($user->first_name),
                                'name'=>'first_name',
                                'required'=>''
                            ),
                            array(
                                 'id' => 'Last Name',                                'placeholder' => 'Last Name',                            		
                                'value' => ($user->last_name),
                                'name'=>'last_name',
                                'required'=>''
                            ),
                            array(
                               'id' => 'Address',                                'placeholder' => 'Address',
                                'value' => ($user->address),
                                'name'=>'address'
                            ),
                            array(
                               'id' => 'Phone',

								'placeholder' => 'Phone',
                                'value' => ($user->phone),
                                'name'=>'phone',
                                'data-mask'=>'phone'
                            ),
                            
                            array(
                               'id' => 'Email',

								'placeholder' => 'Email',
                                'value' => ($user->email),
                                'name'=>'email',
                                'disabled'=>'disabled',
                                'required'=>''
                            ),                            array(                                                            'id' => 'Username',                                                            'placeholder' => 'Username',                                                            'value' => ($user->username),                                                            'name'=>'username',                                                            'disabled'=>'disabled',                                                            'required'=>''                                                        ),
                        ), $user);
                    ?>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Creation Date</label>
                        <div class="col-sm-9">
                            <?=$user->created?>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-2 control-label">Last Update</label>
                        <div class="col-sm-9">
                            <?=$user->last_update?>
                        </div>
                    </div>
                
                     <div class="panel-body ">
                        <div class="form-group col-sm-12">
                            <label class="col-sm-2 control-label">Password</label>
                            <div class="col-sm-5">
                                <input type="password" value="" name="password" class="form-control"/>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php if($this->Scope->check_view_actions('2','admins', 'edit','0') == 1){?>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Login
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body row">
                    <div class="form-group col-sm-2">
                        <label class="col-sm-3 control-label">Active</label>
                        <div class="col-sm-9">
                            <div class="make-switch" data-on-label="<i class='entypo-check'></i>" data-off-label="<i class='entypo-cancel'></i>">
                                <input type="checkbox" <?php if($user->active == 1){echo 'checked';}?> name="active" />
                            </div>
                        </div>
                    </div>
                  
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-6">
          <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Permissions
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="form-group">
                        <div class="col-sm-12">
                            <select multiple="multiple" name="permissions[]" class="form-control select2">
                                <?php 
                                foreach($permissions as $permission){ 
                                    if(in_array($permission->table_name.'|'.$permission->action, $views)){
                                        
                                    }else{
                                        if(in_array($permission->table_name.'|'.$permission->action, $views_user)){
                                            echo ' <option selected value="'.$permission->table_name.'|'.$permission->action.'">'.$permission->table_name.' - ' . $permission->action.'</option>';
                                        }else{
                                            echo ' <option value="'.$permission->table_name.'|'.$permission->action.'">'.$permission->table_name.' - ' . $permission->action.'</option>';
                                        }
                                    }
                                }?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
    
    <div class="form-group default-padding">
            <button type="submit" class="btn btn-success">Edit</button>
    </div>

</form>