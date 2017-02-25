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

<form role="form" method="post" class="form-horizontal form-groups-bordered" action="<?php echo base_url();?>admin/users/printactivityreport">
				
    <div class="row">                   
           <div class="form-group col-lg-12">
               <div class="col-sm-6">
                    <input type="hidden" name="territory" value="<?php echo $territory;?>">         
                    <input type="hidden" name="datefrom" value="<?php echo $datefrom;?>">
                    <input type="hidden" name="dateto" value="<?php echo $dateto;?>">
                    <button type="submit" class="btn btn-success col-lg-6">Export report</button>
               </div>
           </div>
    </div>
</form>

<h1><?php //echo $questiontext;?></h1>
<h1>Territories Activities:</h1>

<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered responsive">
            <thead>
                <tr>
                   <th>Territory</th>
                    
                    <th width="30%">Activity Time</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach($doctors as $doctor): ?>
                    <tr>
                        <td><?=$doctor->territory?></td>
                        <td><?=$doctor->creation_date?></td>                        
                       
                    </tr>

                <?php endforeach; ?>

            </tbody>

        </table>

    </div>

</div>
<div class="pagination">
					<?php //echo $this->pagination->create_links(); ?>
				</div>


