
<style>
    .fileinput-new {
<ol class="breadcrumb bc-3">

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
<div class="row">
                    <th>Gender</th>
                    <th>Country</th>
                        <td><?=$user->gender?></td>
                        <td><?=$user->desc_en?></td>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
