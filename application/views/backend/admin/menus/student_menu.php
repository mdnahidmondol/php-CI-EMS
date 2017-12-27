<style>
.panel-stat3 h2,h4{
    color: #fff;
}
.extra-menu {
    padding: 2px 10px !important;
    min-height: 60px;
}
.extra-menu h4 {
    font-size: 10px !important;
}
</style>

<?php 
$links = ['student_add','student_bulk_add','total_student_page','student_promotion','download_excel'];
$title = ['Admit New Student','Admit Bulk Student','Total Student','Student Promotion','Download Excel'];
$color = ['bg-info','bg-primary','bg-sms','bg-today-app','bg-confirm-app','bg-padding-app','input-group-addon'];
 ?>

<div class="row"  id="studentNavManu">
<div class="col-md-2"></div>
<?php foreach($links as $k=>$each):?>
    <div class="col-sm-3 col-md-1" style="margin-bottom: 10px;">
        <a href="#" onclick="changePage('<?php echo $each?>')">
            <div class="panel-stat3 bg-info extra-menu" id="<?php echo $each;?>">
                <h4><?php echo ($k+1).'. '.$title[$k];?></h4>

                <div class="stat-icon">
                    <i class="fa fa-bars"></i>
                </div>
            </div>
        </a>
    </div>
    <!-- /.col -->
<?php endforeach;?>

<div class="col-sm-3 col-md-2" style="margin-bottom: 10px;">
    <div class="panel-stat3 bg-info extra-menu<?php //echo $color[rand(1,7)];?>">
        <h4>6. Student Information</h4>
        <select name="" id="navMenuSelect" onchange="changePage()" style="color: #000;">
        <option value="">Please Select</option>
        <?php
            $classes = $this->db->get('class')->result_array();
            foreach ($classes as $row):
                $groupName = $this->db->get_where('group', array('class_id' => $row['class_id']))->result_array();
                if(!empty($groupName)):
            ?>
            <optgroup label="<?php echo get_phrase('class').' '.$row['name']; ?>">
                <?php foreach($groupName as $each): ?>
                    <option value="<?php echo $row['class_id'].'/'.$each['group_id'];?>"><?php echo get_phrase($each['name']); ?></option>
                <?php endforeach; ?>
            </optgroup>
            <?php else: ?>
                <option value="<?php echo $row['class_id']; ?>"><?php echo get_phrase('class').' '.$row['name']; ?></option>
            <?php endif; ?>
            <?php endforeach; ?>
        </select>

        <div class="stat-icon">
            <i class="fa fa-bars"></i>
        </div>
    </div>
</div>

</div>

<div id="ajaxPageContainer"></div>

<br>
<br>

<div class="row" id="studentMainManu">

<?php foreach($links as $k=>$each):?>
    <div class="col-sm-6 col-md-3" style="margin-bottom: 10px;">
        <a href="#" onclick="changePage('<?php echo $each?>')">
            <div class="panel-stat3 bg-info<?php //echo $color[rand(1,7)];?>">
                <h2 class="m-top-none" id="userCount"><?php echo $k+1;?></h2>
                <h4><?php echo $title[$k];?></h4>

                <div class="stat-icon">
                    <i class="fa fa-bars fa-3x"></i>
                </div>
            </div>
        </a>
    </div>
    <!-- /.col -->
<?php endforeach;?>

    <div class="col-sm-6 col-md-3" style="margin-bottom: 10px;">
        <div class="panel-stat3 bg-info<?php //echo $color[rand(1,7)];?>">
            <h2 class="m-top-none" id="userCount">6</h2>
            <h4>Student Information</h4>
            <select name="" onchange="changePage()" id="mainMenuSelect" style="color: #000;">
                <option value="">Please Select</option>
            <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $row):
                    $groupName = $this->db->get_where('group', array('class_id' => $row['class_id']))->result_array();
                    if(!empty($groupName)):
                ?>
                <optgroup label="<?php echo get_phrase('class').' '.$row['name']; ?>">
                    <?php foreach($groupName as $each): ?>
                        <option value="<?php echo $row['class_id'].'/'.$each['group_id'];?>"><?php echo get_phrase($each['name']); ?></option>
                    <?php endforeach; ?>
                </optgroup>
                <?php else: ?>
                    <option value="<?php echo $row['class_id']; ?>"><?php echo get_phrase('class').' '.$row['name']; ?></option>
                <?php endif; ?>
                <?php endforeach; ?>
            </select>

            <div class="stat-icon">
                <i class="fa fa-bars fa-3x"></i>
            </div>
        </div>
    </div>

</div>

<script>
$('#studentNavManu').hide();
// studentNavManu
function changePage(page)
{
    var selectValueOne = $('#mainMenuSelect').val();
    var selectValueTwo = $('#navMenuSelect').val();
    var selectValue;
    if(page) {
        selectValue = page;
    } else if(selectValueTwo) {
        selectValue = selectValueTwo;        
    } else if(selectValueOne) {
        selectValue = selectValueOne;
    }
    
    $.ajax({
            type: "POST",
            data: {
                pageName : selectValue                
            },
            beforeSend: function() {                
                    $('#loading2').show();
                    $('#overlayDiv').show();
            },  
            url: '<?php echo base_url(); ?>index.php?admin/ajax_page_load',
            success: function (response)
            {   
                var newurl = window.location.protocol + "//" + window.location.host + window.location.pathname + '?admin/' + selectValue;
                window.history.pushState({path:newurl},'',newurl);                
                // var cName = $('#'+selectValue).hasClass('bg-info'); 
                // if(cName){
                //     $("#"+selectValue).removeClass("bg-info");
                //     $("#"+selectValue).addClass("bg-primary");
                // } else {
                //     $("#"+selectValue).addClass("bg-info");
                //     $("#"+selectValue).removeClass("bg-primary");
                // }
                // if(cName.contains("bg-info")){
                //     console.log("String Found");
                // }
                //$("#"+selectValue).removeClass("bg-info");
                //$("#"+selectValue).toggleClass("bg-primary");
                $('#studentNavManu').show();
                $('#studentMainManu').hide();
                $('#ajaxPageContainer').html(response);
                $('#loading2').fadeOut('slow');
                $('#overlayDiv').fadeOut('slow');                
            }
        });
}

</script>