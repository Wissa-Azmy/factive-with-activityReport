<!-- BEGIN VALIDATION STATES-->
<div class="portlet box blue">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-reorder"></i>
			<?php
				if (count($editCategory) > 0) { echo 'edit Category';
				} else {echo 'Add Category';
				}
			?>

		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"></a>
			<a href="javascript:;" class="remove"></a>
		</div>
	</div>
	<div class="portlet-body form">
		<!-- BEGIN FORM-->
		<form action="<?php echo base_url()?>index.php/admin/category/insert" method="post" id="form" class="form-horizontal">
			<input type="hidden" name="id" value="<?php
			if (count($editCategory) > 0) {echo $editCategory[0] -> id;
			} else {echo '-1';
			}
		?>" />
			<div class="form-body">
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
				<div class="alert alert-danger display-hide">
					<button class="close" data-close="alert"></button>
					You have some form errors. Please check below.
				</div>
				<div class="alert alert-success display-hide">
					<button class="close" data-close="alert"></button>
					Your form validation is successful!
				</div>
				<div class="form-group">
					<label class="control-label col-md-3">Category Name<span class="required">*</span></label>
					<div class="col-md-4">
						<div class="input-icon right">
							<i class="fa"></i>
							<input type="text" class="form-control required" name="name" value="<?php
								if (count($editCategory) > 0) {echo $editCategory[0] -> name;
								}
							?>"/>
						</div>
					</div>
				</div>				
				
				<!--<div class="form-group">
					<label class="control-label col-md-3">Parent Category</label>
					<div class="col-md-4">
						<select id="form_2_select2" class="form-control" name="parent_id">
							<option value="">--NONE--</option>
							 <?php
							echo $selectCat; ?>
						</select>
					</div>
				</div>-->
				<input type="hidden" name="parent_id" value="<?php	if (count($editCategory) > 0) {echo $editCategory[0] -> parent_id;	} else {echo '';}?>" />
					<?php if(count($editCategory)>0){?>
				<div class="form-group">
					<label class="control-label col-md-3">Parent Category</label>
					<div class="col-md-4" style="width: 75%;">
					<?php //echo $path;?>
					<?php if (count($editCategory) > 0) {echo $catname;}?>
					
					
				     &nbsp;&nbsp;&nbsp;&nbsp;
					<a onclick="$('#categ').show();" style="color:blue;cursor:pointer">Change</a>
					<div id="categ" style="display:none;width:100%;overflow:auto">
					<select alreadySelected = "<?php echo $path; ?>"  id="mainCategory" class="mailform" style="width:160px;float:left" size="10">
						<?php
							$where = "parent_id = '0' OR parent_id is NULL";
							$parents = $this->category_model->get(null, $where);
							foreach($parents as $con){
							?>
								<option value="<?php echo $con->id?>"> <?php echo $con->name?></option>
						<?php	}		?>
					</select>
					<div id="subCat1" style="display:none;width:160px;float:left" >
					<select name="subCategory1" class="mailform" id="subCategory1" style="width:160px;float:left" size="10">
						
					</select>
				    </div>
				    <div id="subCat2" style="display:none;width:160px;float:left">
					<select name="subCategory2" class="mailform" id="subCategory2" style="width:160px;float:left" size="10">
						
					</select>
			    	</div>
			    	
					</div>
					</div>
				</div>
				<?php }else{?>
			<div class="form-group">
					<label class="control-label col-md-3">Parent Category</label>
					<div class="col-md-4" style="width: 75%;">	
					<select id="mainCategory" class="mailform" style="width:160px;float:left" size="10">
						<?php
                            $where = "parent_id = '0' OR parent_id is NULL";
                            $parents = $this->category_model->get(null, $where);
                            foreach($parents as $con){
                            ?><option value="<?php echo $con->id?>"> <?php echo $con->name?></option>
						<?php }	?>
					</select>
					<div id="subCat1" style="display:none;width:160px;float:left" >
					<select name="subCategory1" class="mailform" id="subCategory1" style="width:160px;float:left" size="10">
						
					</select>
				    </div>
				    <div id="subCat2" style="display:none;width:160px;float:left">
					<select name="subCategory2" class="mailform" id="subCategory2" style="width:160px;float:left" size="10">
						
					</select>
			    	</div>
			    	
				</div></div>
				<?php } ?>
				
				
				

			</div>
			<div class="form-actions fluid">
				<div class="col-md-offset-3 col-md-9">
					<input type="submit" class="btn blue" value="Submit"/>

					<button type="button" class="btn default">
						Cancel
					</button>
				</div>
			</div>
		</form>
		<!-- END FORM-->
	</div>
</div>

<script>
	jQuery(document).ready(function() {
		// initiate layout and plugins
		//App.init();
		//FormValidation.init();

		// for more info visit the official plugin documentation:
		// http://docs.jquery.com/Plugins/Validation

		var form2 = $('#form');
		var error2 = $('.alert-danger', form2);
		var success2 = $('.alert-success', form2);

		form2.validate({
			errorElement : 'span', //default input error message container
			errorClass : 'help-block', // default input error message class
			focusInvalid : false, // do not focus the last invalid input
			ignore : "",

			invalidHandler : function(event, validator) {//display error alert on form submit
				success2.hide();
				error2.show();
				App.scrollTo(error2, -200);
			},

			errorPlacement : function(error, element) {// render error placement for each input type
				var icon = $(element).parent('.input-icon').children('i');
				icon.removeClass('fa-check').addClass("fa-warning");
				icon.attr("data-original-title", error.text()).tooltip({
					'container' : 'body'
				});
			},

			highlight : function(element) {// hightlight error inputs
				$(element).closest('.form-group').addClass('has-error');
				// set error class to the control group
			},

			unhighlight : function(element) {// revert the change done by hightlight

			},

			success : function(label, element) {
				var icon = $(element).parent('.input-icon').children('i');
				$(element).closest('.form-group').removeClass('has-error').addClass('has-success');
				// set success class to the control group
				icon.removeClass("fa-warning").addClass("fa-check");
			},

			submitHandler : function(form) {
				success2.show();
				error2.hide();
				form.submit();
				//$('#form').submit();
			}
		});
	}); 
</script>


<script>
	
	
	var alreadySelected = $("#mainCategory").attr("alreadySelected");
        var strArr = alreadySelected.split(",");
        var counter = 0;
        strArr.forEach(function(entry){
            console.log(entry);
            if(counter == 0){
                $("#mainCategory option[value = '" + entry + "' ]").attr("selected", "selected");
                
                inputstring = $("#mainCategory").val();
                
                $.ajax({url: "<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
            		   data:{"CatVal": ""+inputstring+"","controlID":"subCategory1"},//Send post data here
            		   async:false,
            		   type:"post",
            		   success:function(data){
            		   			$("#subCat1").html(data);
            		   			$('#subCat1').on('change', '#subCategory1', function() {
            		   				$('#subCat1').show();
	            		   			$("#subCat2").hide();
						   			$("#subCat3").hide();
	            		   			inputstring = $("#subCategory1").val();
                
					                $.ajax({url: "<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
					            		   data:{"CatVal": ""+inputstring+"","controlID":"subCategory2"},//Send post data here
					            		   async:false,
					            		   type:"post",
					            		   success:function(data){
					            		        $("#subCat2").html(data);
					            		        $("#subCategory2").show();
					            		        $("#subCat2").show();
					            		        $("#subCat3").hide();
					            		    }
					            	});

            		   			});
            		   			
					   		   }
            		   });
                console.log( $("#mainCategory option[value = '" + entry + "' ]").text());
                
            }
            
            if(counter == 1){
                $("#subCategory1 option[value = '" + strArr[counter] + "' ]").prop("selected", true);
                $("#subCategory1").trigger("change");
                inputstring = $("#subCategory1").val();
                
                $.ajax({url: "<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
            		   data:{"CatVal": ""+inputstring+"","controlID":"subCategory2"},//Send post data here
            		   async:false,
            		   type:"post",
            		   success:function(data){
            		        $("#subCat2").html(data);
            		        $("#subCategory1 option[value = '" + entry + "' ]").prop("selected", true);
            		        $("#subCategory1").show();
            		        $("#subCat2").show();
            		        
            		        $('#subCat2').on('change', '#subCategory2', function() {
						   			$("#subCat3").hide();
	            		   			inputstring = $("#subCategory2").val();
                
					                $.ajax({url: "<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
					            		   data:{"CatVal": ""+inputstring+"","controlID":"subCategory3"},//Send post data here
					            		   async:false,
					            		   type:"post",
					            		   success:function(data){
					            		        $("#subCat3").html(data);
					            		        $("#subCategory3").show();
					            		        $("#subCat3").show();
					            		    }
					            	});

            		   			});

            		        
            		        
            		    }
            		   });
                
                
                console.log( $("#subCategory1 option[value = '" + strArr[counter] + "' ]").text());
             
            }
            
            if(counter == 2){
                $("#subCategory2 option[value = '" + entry + "' ]").prop("selected", true);
                $("#subCategory2").trigger("change");
               inputstring = $("#subCategory2").val();
                
                $.ajax({url: "<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
            		   data:{"CatVal": ""+inputstring+"","controlID":"subCategory3"},//Send post data here
            		   async:false,
            		   type:"post",
            		   success:function(data){$("#subCat3").html(data); $("#subCategory2 option[value = '" + entry + "' ]").attr("selected", "selected");
	            		   $("#subCategory2").show();
	            		   $("#subCat3").show();
            		   }
            		   });
            		   
                console.log( $("#subCategory2 option[value = '" + entry + "' ]").text());
                
            }
            
            if(counter == 3){
                $("#subCategory3 option[value = '" + entry + "' ]").prop("selected", true);
               // $("#mainCategory option[value = '" + entry + "' ]").prop("selected", true);
               $("#subCategory3").show();
                console.log( $("#subCategory3 option[value = '" + entry + "' ]").text());
                
            }
            
            
            counter++;
        });



	$("#mainCategory").change(function(){

		//alert($("#mainCategory").val());
		if($("#mainCategory").val() == "")
		{
		   $("#subCat1").fadeOut();
		   $("#subCat2").fadeOut();
		   //$("#subCat3").fadeOut();
		}else{

		var inputstring=$("#mainCategory").val();
		$.post("<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", //Specify Action Url
			{"CatVal": ""+inputstring+"","controlID":"subCategory1"}, //Send post data here
			function(data){     
			   if(data.length >0) {
			      $("#subCat1").fadeIn();
			   	  $('#subCat1').html(data);
			      $("#subCat2").fadeOut();
			      //$("#subCat3").fadeOut();
			      $("#subCategory1").change(function(){
			          if($("#subCategory1").val() == "")
		              {
			             $("#subCat2").fadeOut();
			            // $("#subCat3").fadeOut();
			          } else {
			              //$("#subCat3").fadeOut();
			              var inputstring=$("#subCategory1").val();
			           	  $.post("<?php echo base_url() . 'admin/category/viewSubCategories'; ?>",
			              {"CatVal": ""+inputstring+"","controlID":"subCategory2"}, //Send post data here
			              function(data){     //Operation if data received
			              if(data.length >0) {
			                 $("#subCat2").fadeIn();
			                 $('#subCat2').html(data);
			                 /*$("#subCategory2").change(function(){

			                 if($("#subCategory2").val() == "")
			                 {
                                $("#subCat3").fadeOut();
			                 }
			                 else
			                 {
			                     $("#subCat3").fadeIn();
                                 var inputstring=$("#subCategory2").val();
                                 $.post("<?php echo base_url() . 'admin/category/viewSubCategories'; ?>", 
                                 {"CatVal": ""+inputstring+"","controlID":"subCategory3"}, //Send post data here
                                 function(data){     //Operation if data received
                                 if(data.length >0) {
                                       $("#subCat3").fadeIn();
                                       $('#subCat3').html(data);

		       	                 }
                                 });
			                 }
			               });*/
			              }
			              });
			          }
			});
			}
			});
			}
			});
</script>