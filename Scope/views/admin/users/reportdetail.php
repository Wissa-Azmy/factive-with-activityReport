
<style>   .form-groups-bordered > .form-group{        border-bottom:none;    }    .form-groups-bordered > .form-group:first-child{        padding-top: 15px;    }
    .fileinput-new {        max-height: 100px;        overflow: hidden;    }</style>
<ol class="breadcrumb bc-3">    <li>        <a href="<?=base_url()?>admin"><i class="fa-home"></i>Home</a>    </li>    <li class="active">        <strong>Users report detail</strong>    </li></ol>

<h1>Users report detail</h1>
<form role="form" method="post" class="form-horizontal form-groups-bordered" action="<?php echo base_url();?>admin/users/printuserreportdetail">
    <div class="row">                   
           <div class="form-group col-lg-12">
               <div class="col-sm-6">
                    <input type="hidden" name="daterange" value="<?php echo $daterange;?>">
                        <button type="submit" class="btn btn-success col-lg-6">Print report</button>
               </div>
           </div>
     </div>
</form>
<div class="row">    <div class="col-md-12">        <table class="table table-bordered responsive">            <thead>                <tr>                    <th>ID</th>                    <th>Name</th>                    <th>Email</th>
                    <th>Gender</th>
                    <th>Country</th>                    <th>Create date </th>                </tr>            </thead>            <tbody>                <?php foreach($users as $user){ ?>                    <tr>                        <td><?=$user->id?></td>                        <td><?=$user->fname . ' '. $user->lname?></td>                        <td><?=$user->email?></td>
                        <td><?=$user->gender?></td>
                        <td><?=$user->desc_en?></td>                        <td><?=$user->register_date;?></td>                                            </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
