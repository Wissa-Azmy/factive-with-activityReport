<style>
table {
  background-color: transparent;
	border: 1px solid #ebebeb;

}

th {

  text-align: left;

  font-weight: 400;

  color: #303641;

}
.table > thead > tr > th,

	.table > tbody > tr > th,

	.table > tfoot > tr > th,

	.table > thead > tr > td,

	.table > tbody > tr > td,

	.table > tfoot > tr > td {

	  padding: 8px;

	  line-height: 1.42857143;

	  vertical-align: top;
	border: 1px solid #ebebeb;
		    font-family: "Helvetica Neue", Helvetica, "Amiri", sans-serif, Arial, sans-serif;
    font-size: 12px;
		    color: #949494;
      

	}
	.table > thead > tr > th {

	  vertical-align: bottom;

	  border-bottom: 2px solid #ebebeb;
		background-color: #f5f5f6;

  border-bottom-width: 1px;

  color: #a6a7aa;

	}


	
h1 {
		  font-family: inherit;

  font-weight: 500;

  line-height: 1.1;

  color: #373e4a;
	text-align:center;
	}
	
</style>
<div style="padding-bottom: 10px;font-size:16px;width:100%;">
				<img src="<?php echo base_url(); ?>data/logo.png" alt="Logo" height="100px">
				<hr/>
				<h1>Users report </h1>
				</div>


        <table class="table" width='100%'  cellspacing='0'>            <thead>                <tr>                    <th>ID</th>                    <th>Name</th>                    <th>Email</th>
                    <th>Gender</th>
                    <th>Country</th>                    <th>Create date </th>                </tr>            </thead>            <tbody>                <?php foreach($users as $user){ ?>                    <tr>                        <td><?=$user->id?></td>                        <td><?=$user->fname . ' '. $user->lname?></td>                        <td><?=$user->email?></td>
                        <td><?=$user->gender?></td>
                        <td><?=$user->desc_en?></td>                        <td><?=$user->register_date;?></td>                                            </tr>
                <?php } ?>
            </tbody>
        </table>
