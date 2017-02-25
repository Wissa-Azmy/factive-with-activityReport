<style>    .form-groups-bordered > .form-group{        border-bottom:none;    }    .form-groups-bordered > .form-group:first-child{        padding-top: 15px;    }    .fileinput-new {        max-height: 100px;        overflow: hidden;    }
</style>

<h1>Doctors</h1>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered responsive">
            <thead>
                <tr>
                    <th>ID</th>
                    <th width="30%">Name</th>
                    <th>territory</th>
                    <th>specialty </th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($doctors as $doctor){ ?>
                    <tr>
                        <td><?=$doctor->id?></td>
                        <td><?=$doctor->first_name . ' '. $doctor->last_name?></td>
                        <td><?=$doctor->territory?></td>
                        <td><?=$doctor->specialty?></td>               
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div><div class="pagination">					<?php echo $this->pagination->create_links(); ?>				</div>

