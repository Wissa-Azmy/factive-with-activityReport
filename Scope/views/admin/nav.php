<?php 
$data_uls = array(
	
		array(
				'main'=>array(
						'name'=>'Admin Users',
						'icon'=>'entypo-user'
				),
				'subs'=>array(
						array(
								'name'=>'View',
								'link'=>base_url().'admin/admins',
				                'icon'=>'',
				                'table'=>'admins',
				                'action'=>'view',
						),
						array(
								'name'=>'Add',
								'link'=>base_url().'admin/admins/add',
				                'icon'=>'',
				                'table'=>'admins',
				                'action'=>'add',
						),
				)
		),
		array(
				'main'=>array(
						'name'=>'Reports',
						'icon'=>'entypo-air'
				),
				'subs'=>array(						
				    array(
				        'name'=>'Questions Report',
				        'link'=>base_url().'admin/users/userreportform',
				        'icon'=>'',
				        'table'=>'reports',
				        'action'=>'view',
				    ),
				    array(
				        'name'=>'Doctors Report',
				        'link'=>base_url().'admin/users/docreportform',
				        'icon'=>'',
				        'table'=>'reports',
				        'action'=>'view',
				    ),
				    array(
				        'name'=>'Activity Report',
				        'link'=>base_url().'admin/users/activityreportform',
				        'icon'=>'',
				        'table'=>'reports',
				        'action'=>'view',
				    ),

				)
		),
 )
    
    ?>








    <li>
        <a href="<?=base_url()?>admin">
                <i class="entypo-gauge"></i>
                <span class="title">Home</span>
        </a>
    </li>
    
    
    
<?php   
foreach($data_uls as $x => $sec){
	$main =  '<li data-id="m'.$x.'" class="" >';//opened
	$main .=  '<a href="#">
                <i class="'.$sec['main']['icon'].'"></i>
                <span class="title">'.$sec['main']['name'].'</span>
        </a>';
	$sub_li = '';
	foreach($sec['subs'] as $x2 => $sub){
		$daa = $this->Scope->check_view_actions_na('2',$sub['table'], $sub['action'],'');
		if($daa == 1){
			$hh = 'id2=s'.$x.$x2.'&id1=m'.$x.'';
			if (strpos($hh, "?") !== FALSE) {$hh = '&'.$hh;}else{$hh = '?'.$hh;}
			$sub_li .= '<li data-id="s'.$x.$x2.'" >
                                <a href="'.$sub['link'].$hh.'">
                                <i class="i i-dot"></i>

                                <span class="title">'.$sub['name'].'</span>
                              </a>
                            </li>';
		}
	}
	if(!empty($sub_li)){
		$main .= '<ul class="nav dk">'.$sub_li.'</ul>';
		echo $main.'</li>';
	}


}
if(isset($_GET['id1'])){
	$id1 = $_GET['id1'];
}else{
	$id1 = '';
}
if(isset($_GET['id2'])){
	$id2 = $_GET['id2'];
}else{
	$id2 = '';
}
?>
<script>
    $(document).ready(function(){
        $('li[data-id=<?=$id1?>]').addClass("opened active");
        $('li[data-id=<?=$id2?>]').addClass("active");
    })
</script>
