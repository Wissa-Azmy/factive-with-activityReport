<!-- BEGIN PAGE CONTENT-->
<div class="row">
	<div class="col-md-12">
           <div class="portlet box light-grey">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i>Search
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<div class="portlet-body" style="padding: 0px 10px;">
				<form action="<?php echo base_url(); ?>index.php/admin/category" id="ProductsForm" enctype="multipart/form-data" method="post" accept-charset="utf-8">
				<table class="table-striped table-hover" style="margin-bottom: 0px;background:#f9f9f9" >
					
						<tr style="height: 70px;">		
							<td style="padding: 0px 8px;"> 
                                English Name<br>
							<input placeholder="English Name" 
					value="<?php if(isset($name) && $name != ""){echo $name;}?>" name="name" type="text" id="name">
							</td>
							
							</tr>
							<tr>
							<td colspan="3" style="padding: 0px 8px;"> 
                                Parent Category<br>
                                <select name="p_id" id="p_id" class="mailform">
						 <option  <?php if($p_id == "-1"){echo 'selected';}?>  value="-1">All</option>
						<?php
							$parents = $this->category_model->get();
							foreach($parents as $con){ ?>
								<option <?php if($p_id == $con->id){echo 'selected';}?> value="<?php echo $con->id?>"> <?php echo $con->name?></option>
								<?php }?>
							
							</td>
							<td><br>
					<button class="btn blue" type="submit" style="display: inline;margin: 10px;padding: 5px;">Search</button>
					</td>
					</tr>

				</table>
				</form>
			</div>
		</div>
		<!-- BEGIN EXAMPLE TABLE PORTLET-->
		<div class="portlet box light-grey">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-globe"></i>Category
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"></a>
				</div>
			</div>
			<?php if(isset($error)){?>
				<div class="alert alert-danger">
					<strong>Error!</strong> <?php echo $error; ?>
				</div>

				<?php
				}
				?>
				<?php if(isset($warning)){?>
				<div class="alert alert-warning">
					<strong>Warning!</strong> <?php echo $warning; ?>
				</div>

				<?php
				}
				?>
				<?php if(isset($success)){?>
				<div class="alert alert-success">
					<strong>Success!</strong> <?php echo $success; ?>
				</div>
				<?php } ?>
			
			<div class="portlet-body">
				<div class="table-toolbar">
					<div class="btn-group">
						<a id="sample_editable_1_new" class="btn blue" href="<?php echo base_url()?>index.php/admin/category/add">
							Add New <i class="fa fa-plus"></i>
						</a>
					</div>
					
				</div>
                <div class="table-scrollable">
				<table class="table table-striped table-bordered table-hover" id="example2">
					<thead>
                        <tr><td colspan="7">
						<div class="result-count">
							Show result:
                            <a href="<?php echo base_url()?>index.php/admin/category/?perpage=5" <?php if ($per_page==5) {echo 'class="selectedper"'; }?>>5</a>
								
								<a href="<?php echo base_url()?>index.php/admin/category/?perpage=10" <?php if ($per_page==10) {echo 'class="selectedper"'; }?>>10</a>
								<a href="<?php echo base_url()?>index.php/admin/category/?perpage=20" <?php if ($per_page==20) {echo 'class="selectedper"'; }?>>20</a> 
								<a href="<?php echo base_url()?>index.php/admin/category/?perpage=50" <?php if ($per_page==50) {echo 'class="selectedper"'; }?>>50</a> 
								<a href="<?php echo base_url()?>index.php/admin/category/?perpage=100" <?php if ($per_page==100) {echo 'class="selectedper"'; }?>>100</a>
							</div>		
						
						</td></tr>
						<tr>
							
							<th data-field="name" data-align="right" data-sortable="true">Name</th>
							
							<th data-field="cat" data-align="right" data-sortable="true">Parent Category</th>
							<th></th>
							<th></th>
						</tr>
					</thead>
					<tbody>
						<?php
						foreach($tableArray as $res){?>
						<tr class="odd gradeX">
							<td><?php echo $res -> name; ?></td>
							
							<td><?php echo $res -> parent?></td>
								<td>
								<a href="<?php echo base_url()?>index.php/admin/category/add/<?php echo $res->id?>" >
											 edit</a>

							</td>
							<td style="text-align: center"> 
								<a href="<?php echo base_url()?>index.php/admin/category/delete/<?php echo $res->id?>" 
									id="remove" onclick="return confirm('Are u sure to delete');">
											 delete</a>
							</td>
							
						</tr>
						<?php } ?>
						
					</tbody>
				</table></div>
				<div class="pagination" style="display: block;">
					<?php echo $this->pagination->create_links(); ?>
				</div>
			</div>
		</div>
		<!-- END EXAMPLE TABLE PORTLET-->
	</div>
</div>