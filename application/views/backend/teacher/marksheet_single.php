<?php //print_r($students); 
$running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;

$schoolInfo = $this->db->get_where('settings',['type'=>'school_information'])->row()->description;
list($schoolName,$schoolAddress,$eiin,$schoolEmail,$phone) = explode('+', $schoolInfo);

$grades = $this->db->get('grade')->result_array();
function accSum($grades='')
{	
	echo 'hello';
}
?>


<link rel="stylesheet" media="all" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0/css/bootstrap.min.css" />
<style media="all">
	
	@import url('https://fonts.googleapis.com/css?family=Noto+Sans');
	* {
		font-family: 'Noto Sans', sans-serif;
		font-size: 13px;
	}
	.marksheet-border {
		border: 2px dashed #8c8b8b;
	}
	.header-title {
		text-align: center;
	}
	.std-info {
		font-weight: bold;
	}
	.each-row {
		height: 25px;
		width: 360px;
	}
	.each-row p {
		display: inline;
		margin: 0px;
		padding: 0px;
	}

	p.std-title {
		float: left;
		width: 140px;
	}

	p.std-info {
		width: 200px;
		float: right;
	}
	th {
		vertical-align: middle !important;
		text-align: center;
	}
	.joinSubGrad {
		vertical-align: middle !important;
	}
	hr.bottom-border {
		background-color: #fff;
		border-top: 2px dashed #8c8b8b;
	}
	table.table.table-bordered.mark-range-table td {
		padding: 0;
		text-align: center;
	}
	.background-img {
		background: -moz-linear-gradient(top, rgba(0, 0, 0, 0.7) 0%, rgba(0, 0, 0, 0.7) 100%), url(bg.png) repeat 0 0 !important, url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: -moz-linear-gradient(top, rgba(255,255,255,0.7) 0%, rgba(255,255,255,0.7) 100%), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: -webkit-gradient(linear, left top, left bottom, color-stop(0%,rgba(255,255,255,0.7)), color-stop(100%,rgba(255,255,255,0.7))), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: -webkit-linear-gradient(top, rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.7) 100%), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: -o-linear-gradient(top, rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.7) 100%), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: -ms-linear-gradient(top, rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.7) 100%), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;

		background: linear-gradient(to bottom, rgba(255,255,255,0.7) 0%,rgba(255,255,255,0.7) 100%), url('<?php echo base_url();?>uploads/school_logo.png') repeat 0 0 !important;


		background-repeat: no-repeat !important;
		background-position: center 200px !important;
		background-size: 300px 300px !important;
		position: relative;
		z-index: 1111111 !important;
    }
</style>

<?php if(!empty($students)): 
	foreach($students as $rootIndex=>$each):	
		foreach($each as $studentID=>$each2):
			// GET STUDENT ALL INFORMATION
			$this->db->select('*');
			$this->db->from('student');
			$this->db->where('student.student_id',$studentID);
			$this->db->join('enroll', 'enroll.student_id = student.student_id');
			$std_info = $this->db->get()->result_array();
			extract($std_info[0]);
			// GET CLASS & GROUP NAME
			$className = $this->db->get_where('class',['class_id'=>$class_id])->row()->name;
			$groupName = $this->db->get_where('group',['class_id'=>$class_id])->row()->name;
			// EXAM ID FROM CONTROLLER
			$examName   = $this->db->get_where('exam',['exam_id'=>$exam_id])->row()->name;
			// STORE MARK,POINT AND GRADE
			$eachMarks  = $each2['mark'];
			$eachPoints = $each2['point'];
			$eachGrades = $each2['grade'];
			$eachObtainMarks = $each2['obtain_mark'];
?>
<div class="container-fluid marksheet-border">
	<br><br>
	<div class="row">
		<!-- HEADER TITLE -->
		<div class="col-sm-12 header-title">
			<h2 class="text-uppercase"><?php echo $schoolName; ?></h2>
			<h4 class="text-uppercase"><?php echo $schoolAddress; ?></h4>
		</div>
		<!-- HEADER TITLE -->
		<div class="offset-sm-4 col-sm-4 text-center">
			<img src="<?php echo base_url();?>uploads/school_logo.png" alt="" width="100px" height="100px">
			<br><br>
			<h4>PROGRESS REPORT</h4>
		</div>
		<!-- HEADER GREADING LIST -->
		<div class="offset-sm-1 col-sm-3">
			<table class="table table-bordered mark-range-table">
				<thead>
					<tr>
						<th>Range</th>
						<th>Grade</th>
						<th>GPA</th>
					</tr>
				</thead>
				<tbody>
				<?php $grades = $this->db->get('grade')->result_array();
					foreach($grades as $k=>$each):
				?>
					<tr>
						<td><?php echo $each['mark_from']?>-<?php echo $each['mark_upto']?></td>
						<td><?php echo $each['name']?></td>
						<td><?php echo $each['grade_point']?></td>
					</tr>
				<?php endforeach; ?>
				</tbody>
			</table>
		</div>
	</div>
	<br>
	<!-- STUDENT INFORMATION -->
	<div class="row">		
		<!-- STUDENT INFORMATION LEFT -->
		<div class="offset-sm-1 col-sm-4">			
			<div class="each-row">
				<p class="std-title">Student's Name</p>
				<p>:</p>
				<p class="std-info"><?php echo $name; ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Father's Name</p>
				<p>:</p>
				<p class="std-info"><?php echo $fname; ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Mother's Name</p>
				<p>:</p>
				<p class="std-info"><?php echo $mname; ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Student's ID</p>
				<p>:</p>
				<p class="std-info"><?php echo $student_code; ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Class</p>
				<p>:</p>
				<p class="std-info"><?php echo $className; ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Roll</p>
				<p>:</p>
				<p class="std-info"><?php echo $roll; ?></p>
			</div>
			
		</div>
		<!-- STUDENT INFORMATION RIGHT -->
		<div class="offset-sm-2 col-sm-4">
			<div class="each-row">
				<p class="std-title">Exam</p>
				<p>:</p>
				<p class="std-info"><?php echo ucwords($examName); ?></p>
			</div>
			<div class="each-row">
				<p class="std-title">Year/Session</p>
				<p>:</p>
				<p class="std-info"><?php echo substr($running_year, 0, -5); ?></p>
			</div>
			<?php if(!empty($groupName)): ?>
				<div class="each-row">
					<p class="std-title">Group</p>
					<p>:</p>
					<p class="std-info"><?php echo ucwords($groupName); ?></p>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<br>
	<div class="row">
		<!-- STUDENT MARK TABLE -->
		<div class="col-sm-12">
		<table class="table table-bordered">
			<tr>
				<th rowspan="2">Subject</th>
				<th rowspan="2">Full Marks</th>
				<th rowspan="2">Highest Marks</th>
				<th colspan="4">Marks Distribution</th>
				<th rowspan="2">Total Marks</th>
				<th rowspan="2">Letter Grade</th>
				<th rowspan="2">GPA</th>
			</tr>
			<tr class="text-center">
				<td>MT</td>
				<td>CQ</td>
				<td>MCQ</td>
				<td>PR</td>
			</tr>
			<?php foreach($eachMarks as $subjectID=>$eachMark):
					// If Join Subject
					if(is_array($eachMark)):
						foreach($eachMark as $subjectID2=>$eachMark2):
				?>
				<tr>
					<td><?php echo $this->db->get_where('subject',['subject_id'=>$subjectID2])->row()->name; ?></td>
					<td class="text-center"><?php echo $this->db->get_where('subject',['subject_id'=>$subjectID2])->row()->total_mark; ?></td>
					<td></td>
					<?php $obtainMark = explode('|',$eachObtainMarks[$subjectID2]); 
							foreach($obtainMark as $markIndex=>$eachmark3):  ?>
						<td class="text-center"><?php echo $eachmark3==false?'-':$eachmark3; ?></td>
					<?php endforeach; ?>
					<td class="text-center"><?php echo $eachMarks[$subjectID][$subjectID2]; ?></td>					
					<?php 
						if(!empty($unqJoinSubjectGrad)):
							if(!in_array($subjectID,$unqJoinSubjectGrad)):
					 ?>					 
						<td class="text-center joinSubGrad" rowspan="2"><?php echo $eachGrades[$subjectID]; ?></td>
					<?php endif; else: ?>
						<td class="text-center joinSubGrad" rowspan="2"><?php echo $eachGrades[$subjectID]; ?></td>
					<?php endif; $unqJoinSubjectGrad[] = $subjectID; ?>

					<?php 
						if(!empty($unqJoinSubjectPoint)):
							if(!in_array($subjectID,$unqJoinSubjectPoint)):
					 ?>					 
						<td class="text-center joinSubGrad" rowspan="2"><?php echo $eachPoints[$subjectID]; ?></td>
					<?php endif; else: ?>
						<td class="text-center joinSubGrad" rowspan="2"><?php echo $eachPoints[$subjectID]; ?></td>
					<?php endif; $unqJoinSubjectPoint[] = $subjectID; ?>
				</tr>
			<?php endforeach; else: // If Single Subject 	?>
				<tr>
					<td><?php echo $this->db->get_where('subject',['subject_id'=>$subjectID])->row()->name; ?></td>
					<td class="text-center"><?php echo $this->db->get_where('subject',['subject_id'=>$subjectID])->row()->total_mark; ?></td>
					<td></td>
					<?php $obtainMark = explode('|',$eachObtainMarks[$subjectID]); 
							foreach($obtainMark as $markIndex=>$eachmark3):  ?>
						<td class="text-center"><?php echo $eachmark3==false?'-':$eachmark3; ?></td>
					<?php endforeach; ?>
					<td class="text-center"><?php echo $eachMarks[$subjectID]; ?></td>
					<td class="text-center"><?php echo $eachGrades[$subjectID]; ?></td>
					<td class="text-center"><?php echo $eachPoints[$subjectID]; ?></td>
				</tr>
			<?php endif; endforeach; ?>

			<tr>
				<td class="text-right">Total Exam Marks</td>
				<td class="text-center">1150</td>
				<td colspan="5" class="text-right">Obtained Marks & GPA</td>				
				<td class="text-center"><?php echo $each2['total_mark'] ?></td>
				<td class="text-center"><?php echo $each2['total_grade'] ?></td>
				<td class="text-center"><?php echo $each2['total_point_with_4th'] ?></td>
			</tr>
			</table>
		</div>
	</div>
	<!-- BOTTOM TABLES -->
	<div class="row">
		<!-- BOTTOM TABLE LEFT -->
		<div class="col-sm-4">
			<table class="table table-bordered">
				<tr>
					<td>Class Position</td>
					<td></td>
				</tr>
				<tr>
					<td>GPA (Without 4th)</td>
					<td><?php echo $each2['total_point_without_4th'] ?></td>
				</tr>
				<tr>
					<td>Failed Subject</td>
					<td><?php echo $each2['failCount']; ?></td>
				</tr>
				<tr>
					<td>Working Days</td>
					<td><?php accSum(); ?></td>
				</tr>
				<tr>
					<td>Total Present</td>
					<td></td>
				</tr>
			</table>
		</div>
		<!-- BOTTOM TABLE CENTER -->
		<div class="col-sm-4">
			<table class="table table-bordered">
				<tr>
					<td colspan="2" class="text-center font-weight-bold">Moral & Behavior Evaluation</td>
				</tr>
				<tr>
					<td></td>
					<td>Best</td>
				</tr>
				<tr>
					<td></td>
					<td>Better</td>
				</tr>
				<tr>
					<td></td>
					<td>Good</td>
				</tr>
				<tr>
					<td></td>
					<td>Need Improvement</td>
				</tr>
			</table>
		</div>
		<!-- BOTTOM TABLE RIGHT -->
		<div class="col-sm-4">
			<table class="table table-bordered">
				<tr>
					<td colspan="2" class="text-center font-weight-bold">Co-Curricular Activities</td>
				</tr>
				<tr>
					<td></td>
					<td>Sports</td>
				</tr>
				<tr>
					<td></td>
					<td>Cultural Function</td>
				</tr>
				<tr>
					<td></td>
					<td>Scout/BNCC</td>
				</tr>
				<tr>
					<td></td>
					<td>Math Olympiad</td>
				</tr>
			</table>
		</div>
	</div>
	<!-- BOTTOM COMMENT TABLE -->
	<div class="row">		
		<div class="col-sm-12">
			<table class="table table-bordered">
				<tr>
					<th height="130px">Comments</th>
				</tr>
			</table>
		</div>
	</div>
	<br><br>
	<!-- BOTTOM SIGNATURE -->
	<div class="row text-center">		
		<div class="col-sm-4">
			<hr class="bottom-border"/>
			<p>Guardian</p> 
		</div>
		<div class="col-sm-4">
			<hr class="bottom-border"/>
			<p>Class Teacher</p> 	
		</div>
		<div class="col-sm-4">
			<hr class="bottom-border"/>
			<p>Headmaster</p> 
		</div>
	</div>
</div>

<?php endforeach; endforeach; endif; ?>