<script type="text/javascript" src="<?php echo base_url(); ?>data/admin/js/reports/JSClass/FusionCharts.js"></script>	

<!-- BEGIN PAGE CONTENT-->


<h1><?php echo $questiontext;?></h1>


				<div class="table-toolbar">	
								
				<div class="table-scrollable">
				
					<div id="chartdiv" style="text-align: justify;">Questions report</div>
					
			        <script type="text/javascript">
					   var chart = new FusionCharts("<?php echo base_url(); ?>data/admin/js/reports/chart_user/Column3D.swf", "ChartId", "900", "470", "0", "0");
					   chart.setDataURL("<?php echo base_url(); ?>data/admin/js/reports/chart_user/Column3D.xml");		   
					   chart.render("chartdiv");
					</script> 
					</div>
				
				
				<form role="form" method="post" class="form-horizontal form-groups-bordered" action="<?php echo base_url();?>admin/users/printuserreport">
				
                    <div class="row">                   
                           <div class="form-group col-lg-12">
                               <div class="col-sm-6">
                                    <input type="hidden" name="question" value="<?php echo $question;?>">
                                    <input type="hidden" name="territory" value="<?php echo $territory;?>">
                                    <input type="hidden" name="specialty" value="<?php echo $specialty;?>">
                                    <input type="hidden" name="datefrom" value="<?php echo $datefrom;?>">
                                    <input type="hidden" name="dateto" value="<?php echo $dateto;?>">
                                    <button type="submit" class="btn btn-success col-lg-6">Export report</button>
                               </div>
                           </div>
                     </div>
                </form>
				<table class="table table-striped table-bordered table-hover" id="example2">
					<thead>
                        <tr>						
							<th >Answer</th>
							<th>Percentage of users</th>							
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($tableArray as $answer => $res){?>
						<tr class="odd gradeX">
							<td><?php echo $answer;?></td>
							<td><?php echo round($res);?></td>
                           						
						</tr>
						<?php } ?>
						
					</tbody>

</table>
</div>
