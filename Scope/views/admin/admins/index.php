
<style>
    
    .form-groups-bordered > .form-group{
        border-bottom:none;
    }
    .form-groups-bordered > .form-group:first-child{
        padding-top: 15px;
    }
    .fileinput-new {
        max-height: 100px;
        overflow: hidden;
    }
</style>
<ol class="breadcrumb bc-3">
    <li>
        <a href="<?=base_url()?>admin"><i class="fa-home"></i>Home</a>
    </li>
    <li class="active">
        <strong>Administrators</strong>
    </li>
</ol>

<h1>Administrators</h1>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="30%">Name</th>
                    <th>Permissions</th>
                    <th>Creation Date </th>
                    <th>Last update</th>
                    <th style="width: 253px;" ></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($admins as $admin){ ?>
                    <tr>
                        <td><?=$admin->id?></td>
                        <td><?=$admin->first_name . ' '. $admin->last_name?></td>
                        <td></td>
                        <td><?=$admin->created;?></td>
                        <td><?php if($admin->last_update != '0000-00-00 00:00:00'){echo $admin->last_update;}else{echo 'No updates';}?> </td>
                        
                        
                        <td> 
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
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div><div class="pagination">					<?php echo $this->pagination->create_links(); ?>				</div>

<script>
$(document).ready(function(){
    $("#loadmore").click(function(){
        var info = "id="+$("#last_id").html()+"&category_id=17"; 
        var loading = "<img class='loading-img' src='http://babal.net/img/ajax-loader.gif' />";
        $( "#last_id" ).remove();
        $.ajax({
            type: "POST",
            url: "http://babal.net/news/load_more_sec",
            data: info,
            cache: false,
            async: true,
            beforeSend : function(){
                    $("#show_ajax_loading").show();
                    $("#show_ajax_loading").html(loading); //show image loading
                },
            success: function(data_success){
                if(data_success == ""){
                    $('#loadmore').hide();
                    $('#data-load-con').hide();
                    $("#show_ajax_loading").remove();
                }else{
                    setTimeout(function() {
                         if(data_success != ""){
                            $("#show_ajax_loading").html("");
                         }
                        $("#blog-landing").append(data_success);
                        onloadmore();
                    }, 1000);
                    if(data_success == ""){
                        $('#loadmore').hide();
                        $('#data-load-con').hide();
                    }
                }
            }
        });
    });
});
</script>