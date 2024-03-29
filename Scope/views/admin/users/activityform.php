
<form role="form" method="post" class="form-horizontal form-groups-bordered" action="<?php echo base_url();?>admin/users/activityreport">


    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        Search
                    </div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                        <a href="#" data-rel="close"><i class="entypo-cancel"></i></a>
                    </div>
                </div>
                <div class="panel-body">

        <div class="row">
                <!-- <div class="form-group col-lg-12">
                <label for="field-1" class="col-sm-3 control-label">Question</label>
                 <div class="col-sm-6">
                     <select name="question" class="form-control select2">
                        <option value="" selected="">All Questions</option>
    					 <option value="1">Why do you prefer FACTIVE in Acute Exacerbation of Chronic Bronchitis?</option> 
    					 <option value="2">Why do you prefer FACTIVE in Community Acquired Pneumonia?</option>
    					  <option value="3">Why do you prefer FACTIVE in Acute Bacterial Sinusitis?</option>     					                  
                       </select>  
                 </div>
                </div>  -->
                
                <div class="form-group col-lg-12">
                <label for="field-1" class="col-sm-3 control-label">Territory</label>
                 <div class="col-sm-6">
                       <select name="territory" class="form-control select2">
                        <option value="" selected="">All Territory</option>
    					  <option value="1">J1</option> 
    					 <option value="2">J2</option>
    					  <option value="3">J3</option> 
    					  <option value="4">J4</option> 
    					  <option value="5">MAKKAH</option> 
    					  <option value="6">MADINAH</option> 
    					  <option value="7">ABHA</option> 
    					  <option value="8">JIZAN</option> 
    					  <option value="9">OLAYA</option> 
    					  <option value="10">NASEEM</option> 
    					  <option value="11">CENTRAL RIYADH</option> 
    					  <option value="12">SOUTH RIYADH</option> 
    					  <option value="13">QASSIM</option> 
    					  <option value="14">DAMMAM</option> 
    					  <option value="15">KHOBAR</option> 
    					  <option value="16">HOFUF</option>                    
                       </select>                 
                 </div>
                </div>  
      <!--       <div class="form-group col-lg-12">
                <label for="field-1" class="col-sm-3 control-label">Specialty</label>
                 <div class="col-sm-6">
                <select id="specialty" name="specialty" class="form-control select2">
					 <option value="" selected="">All Specialty</option>
					 <option value="1">Chest</option> 
					 <option value="2">Emergency Medicine</option> 
					 <option value="3">ENT</option> 
					 <option value="4">General Practice</option> 
					<option value="5">Internal Medicine</option>
				</select>               
                 </div>
            </div>      --> 
            <div class="form-group col-lg-12"> 
                <label for="field-1" class="col-sm-3 control-label">From</label>
                 <div class="col-sm-6">
                    <input type="text" name="datefrom" id="datefrom" class="form-control">        
                 </div>
            </div>  
            <div class="form-group col-lg-12">
                <label for="field-1" class="col-sm-3 control-label">TO</label>
                 <div class="col-sm-6">
                     <input type="text" name="dateto" id="dateto" class="form-control">   
                 </div>
            </div>                  
        </div><!-- ROW -->

            <div class="form-group col-lg-12">
                <div class="col-sm-6">
                    <button type="submit" class="btn btn-success col-lg-12">Search</button>
                </div>
            </div>
                </div><!-- PANEL BODY -->

            </div><!-- PANEL PANEL-PRIMARY -->

        </div><!-- COL-MD-12 -->
    </div><!-- ROW -->
</form>


<script>
  
	jQuery(document).ready(function($) {			
		
	    $('input[name="datefrom"]').daterangepicker({
	        singleDatePicker: true,
	        showDropdowns: true,
	        locale: {
	            format: 'YYYY-MM-DD'
	        }	       
	    }).change(function () {
	    	var fromDate = $("#datefrom").val();
	    	var toDate = $("#dateto").val();
	    	if (Date.parse(fromDate) > Date.parse(toDate)) {
	    	    alert("Invalid Date Range!\nStart Date cannot be after End Date!")
	    	    $("#datefrom").val('');
	    	    return false;
	    	} 
	    	
        });  

	    $('input[name="dateto"]').daterangepicker({
	        singleDatePicker: true,  
	        showDropdowns: true,
	        locale: {
	            format: 'YYYY-MM-DD'
	        }	        
	    }).change(function () {
	    	var fromDate = $("#datefrom").val();
	    	var toDate = $("#dateto").val();
	    	if (Date.parse(fromDate) > Date.parse(toDate)) {
	    	    alert("Invalid Date Range!\nStart Date cannot be after End Date!")
	    	    $("#dateto").val('');
	    	    return false;
	    	} 
	    	
        }); 

	    $("#datefrom").val('');
	    $("#dateto").val('');
		});
	
		 
    </script>