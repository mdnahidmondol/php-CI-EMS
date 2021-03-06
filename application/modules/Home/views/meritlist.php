<?php
$logo = $this->db->get_where('images',array('id'=>1))->row()->img_name;
$session = $this->db->get_where('settings', array('type' => 'admission_session'))->row()->description;
$this->db->select('*');
$this->db->from('admit_std');
$this->db->join('admission_result', 'admission_result.uniq_id = admit_std.uniq_id');
$this->db->where('admit_std.session',$session);
$this->db->where('admit_std.class',$class);
$this->db->where('admit_std.sex',$sex);
$this->db->where('admit_std.group', $group);
$this->db->order_by('admission_result.mark','desc');
$query = $this->db->get()->result_array();

	
$count = count($query)/29;
$first = ceil($count); 

$schoolInfo = $this->db->get_where('settings',['type'=>'school_information'])->row()->description;
list($schoolName,$schoolAddress,$eiin,$email,$phone) = explode('+', $schoolInfo);
?>

<head>
	<title><?php echo 'Class: '.$class.' Marksheet';?></title>
	<style>
		body{font-size: 12px;}
		.wrapper{width: 95%; margin: 0 auto;}
		.headerWrapper{width: 100%; height: 100px;}
		.leftDiv{float: left; width: 12%; text-align: center;}
		.centerDiv{width: 70%; float: left; line-height: 22px;}
		.centerDiv p,h2{margin: 2px; text-align: center}
		.rightDiv{ font-size: 10px; width: 13%; float: left; text-align: center; padding-top: 0px; border: 2px solid; color: #008000}
		.rightDiv h3 {padding: 2px 0px; margin: 0px;}
		table{
			width: 100%;
			border:1px solid #d6d6d6;
			border-collapse: collapse;
		}
		.table th{
			padding:10px !important;
			border:1px solid #d6d6d6;
			text-align:center;
			font-size: 11px;
		}
		.table td{
			border:1px solid #d6d6d6;
			text-align:center;
			padding:6px 0px!important;
		}
		.table td>img{
		}
	</style>
</head>
<body>
<?php $mList = 0; for($j=0;$j<$first;$j++){
		$start = $j*29;
?>
<div class="wrapper">
	<div class="headerWrapper">
		<div class="leftDiv"><img src="<?php echo base_url().'uploads/school_logo.png';?>" width="120px" height="120px"/></div>
		<div class="centerDiv">
		<h2 style="color: #008000;"><?php echo $schoolName; ?></h2>
		<p style="color: #008000;"><?php echo $schoolAddress; ?></p>
		<p>Season-<?php echo $session; ?></p>
		
		</div>
		<div class="rightDiv">
			<h3><?php echo ucfirst($sex);?></h3>
			<h3>
				<?php 
					echo "Class: ".$class;
					if(!empty($group)):
						echo "<br/>".$group;
					endif;
				?>
			</h3>
			<h3>Merit List</h3>
		</div>
	</div>
	
	<div class="tableWrapper" style="margin-top: 5px;">
		<div class="table-responsive">
			<table class="table">
				<tr>
					<th width="10%">Merit List</th>
					<th width="10%">Form Serial</th>
					<th>Student Name</th>
					<th>Father's Name</th>
					<th width="10%">Obtain Mark</th>
				</tr>
				<?php foreach(array_slice($query, $start, 29) as $k=>$list){?>
				<tr>
					<td ><?php 
						if($mList>28){
							$mList++;
							echo $mList;
						}else{
							$mList = $k+1;
							echo $mList;
						}
					?></td>
					<td><?php echo $list['std_id'];?></td>
					<td><?php echo $list['namebn'];?></td>
					<td><?php echo $list['fnamebn'];?></td>
					<td><?php echo $list['mark'];?></td>
				</tr>
				<?php }?>
			</table>
		</div>
	</div>
	<p style="position: absolute; bottom: 0; margin-left: 300px; width: 100%;">Page No: <?php echo $j+1;?></p>
</div>

<?php }?>
</body>