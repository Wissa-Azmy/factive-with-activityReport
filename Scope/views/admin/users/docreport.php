<style>
</style>

<h1>Doctors:</h1>
<div class="row">
    <div class="col-md-12">
        <table class="table table-bordered responsive">
            <thead>
                <tr>
                   <th>Territory</th>
                    <th width="30%">Name</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php foreach($doctors as $doctor){ ?>
                    <tr>
                        <td><?=$doctor->first_name . ' '. $doctor->last_name?></td>
                         
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
