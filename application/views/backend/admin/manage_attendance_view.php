<hr />
<?php 
$data = [
    'class_id' => $class_id,
    'group_id' => $group_id,
    'section_id' => $section_id,
    'year' => $running_year,
    'timestamp' => $timestamp
];


// echo pd($data);


$group_id==''?$group_id=NULL:$group_id=$group_id;
?>
<?php echo form_open(base_url() . 'index.php?admin/attendance_selector/'); ?>
<div class="row">

    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('class'); ?></label>
            <select name="class_id" class="form-control selectboxit" onchange="select_section(this.value)">
                <option value=""><?php echo get_phrase('select_class'); ?></option>
                <?php
                $classes = $this->db->get('class')->result_array();
                foreach ($classes as $row):
                    ?>

                    <option value="<?php echo $row['class_id']; ?>"
                            <?php if ($class_id == $row['class_id']) echo 'selected'; ?>><?php echo $row['name']; ?></option>
                        <?php endforeach; ?>
            </select>
        </div>
    </div>

    <div id="group_holder">
    <?php if($group_id!==NULL):?>
        <div class="col-md-2">

        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section'); ?></label>
            <select name="group_id" id="group_id" class="form-control selectboxit">
                <?php
                $groups = $this->db->get_where('group', array(
                            'class_id' => $class_id
                        ))->result_array();
                foreach ($groups as $row):
                    ?>
                    <option value="<?php echo $row['group_id']; ?>" 
                            <?php if ($group_id == $row['group_id']) echo 'selected'; ?>>
                            <?php echo ucwords($row['name']); ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>
    <?php endif;?>
    </div>


<div id="section_holder">
    <div class="col-md-2">

        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('section'); ?></label>
            <select name="section_id" id="section_id" class="form-control selectboxit">
                <?php
                $sections = $this->db->get_where('section', array(
                            'class_id' => $class_id
                        ))->result_array();
                foreach ($sections as $row):
                    ?>
                    <option value="<?php echo $row['section_id']; ?>" 
                            <?php if ($section_id == $row['section_id']) echo 'selected'; ?>>
                            <?php echo $row['name']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
        </div>

    </div>
</div>


<div id="shift_holder">
    <div class="col-md-2">
        <div class="form-group">
        <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('shift');?></label>
            <select class="form-control selectboxit" name="shift_id">
                            <option value=""><?php echo get_phrase('select_shift_first') ?></option>
                            <?php $shifts = $this->db->get('shift')->result_array();
                                foreach($shifts as $shift):
                            ?>
                            <option value="<?php echo $shift['shift_id'];?>"
                            <?php if ($shift_id == $shift['shift_id']) echo 'selected'; ?>><?php echo $shift['name'] ;?></option>                     
                            <?php endforeach;?>
                
            </select>
        </div>
    </div>
    </div>


    <div class="col-md-2">
        <div class="form-group">
            <label class="control-label" style="margin-bottom: 5px;"><?php echo get_phrase('date'); ?></label>
            <input type="text" class="form-control datepicker" name="timestamp" data-format="dd-mm-yyyy"
                   value="<?php echo date("d-m-Y", $timestamp); ?>"/>
        </div>
    </div>

    <input type="hidden" name="year" value="<?php echo $running_year; ?>">

    <div class="col-md-1" style="margin-top: 20px;">
        <button type="submit" class="btn btn-info"><?php echo get_phrase('manage_attendance'); ?></button>
    </div>

</div>
<?php echo form_close(); ?>






<hr />
<div class="row" style="text-align: center;">
    <div class="col-sm-4"></div>
    <div class="col-sm-4">
        <div class="tile-stats tile-gray">
            <div class="icon"><i class="entypo-chart-area"></i></div>

            <h3 style="color: #696969;"><?php echo get_phrase('attendance_for').'<b> Class</b>'; ?> <?php echo $this->db->get_where('class', array('class_id' => $class_id))->row()->name; ?></h3>
            <h4 style="color: #696969;">
                <?php echo '<b>'.get_phrase('section: ').'</b>'; ?> <?php echo $this->db->get_where('section', array('section_id' => $section_id))->row()->name; ?> 
            </h4>
            <?php if(!empty($group_id)):?>
            <h4 style="color: #696969;">
                <?php echo '<b>'.get_phrase('group: ').'</b>'; ?> <?php echo ucwords($this->db->get_where('group', array('group_id' => $group_id))->row()->name); ?> 
            </h4>
            <?php endif;?>
            <h4 style="color: #696969;">
                <?php echo date("d M Y", $timestamp); ?>
            </h4>
        </div>
    </div>
    <div class="col-sm-4"></div>
</div>

<center>
    <a class="btn btn-default" onclick="mark_all_present()">
        <i class="entypo-check"></i> <?php echo get_phrase('mark_all_present'); ?>
    </a>
    <a class="btn btn-default"  onclick="mark_all_absent()">
        <i class="entypo-cancel"></i> <?php echo get_phrase('mark_all_absent'); ?>
    </a>
</center>
<br>

<div class="row">

    <div class="col-md-2"></div>

    <div class="col-md-8">

        <?php echo form_open(base_url() . 'index.php?admin/attendance_update/' . $class_id . '/' . $shift_id . '/' . $section_id . '/' . $timestamp. '/' . $group_id ); ?>
        <div id="attendance_update">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th><?php echo get_phrase('roll'); ?></th>
                        <th><?php echo get_phrase('name'); ?></th>
                        <th><?php echo get_phrase('status'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php

                    $count = 1;
                    $select_id = 0;
                    if(!empty($group_id)):
                        $group_id = $group_id;
                    else:
                        $group_id = '';
                    endif;
                    $attendance_of_students = $this->db->get_where('attendance', array(
                                'class_id' => $class_id,
                                'shift_id' => $shift_id,
                                'group_id' => $group_id,
                                'section_id' => $section_id,
                                'year' => $running_year,
                                'timestamp' => $timestamp
                            ))->result_array();

                   
                    foreach ($attendance_of_students as $row):
                        ?>
                        <tr>
                            <td><?php echo $count++; ?></td>
                            <td>
                                <?php echo $this->db->get_where('enroll', array('student_id' => $row['student_id']))->row()->roll; ?>
                            </td>
                            <td>
                                <?php echo $this->db->get_where('student', array('student_id' => $row['student_id']))->row()->name; ?>
                            </td>
                            <td>
                                <select class="form-control" name="status_<?php echo $row['attendance_id']; ?>" id="status_<?php echo $select_id; ?>">
                                    <option value="0" <?php if ($row['status'] == 0) echo 'selected'; ?>><?php echo get_phrase('undefined'); ?></option>
                                    <option value="1" <?php if ($row['status'] == 1) echo 'selected'; ?>><?php echo get_phrase('present'); ?></option>
                                    <option value="2" <?php if ($row['status'] == 2) echo 'selected'; ?>><?php echo get_phrase('absent'); ?></option>
                                    <option value="3" <?php if ($row['status'] == 3) echo 'selected'; ?>><?php echo get_phrase('escaped'); ?></option>
                                </select>	
                            </td>
                        </tr>
                    <?php 
                    $select_id++;
                    endforeach; ?>
                </tbody>
            </table>
        </div>

        <center>
            <button type="submit" class="btn btn-success" id="submit_button">
                <i class="entypo-thumbs-up"></i> <?php echo get_phrase('save_changes'); ?>
            </button>
        </center>
        <?php echo form_close(); ?>

    </div>



</div>


<script type="text/javascript">
<?php if($group_id!==NULL):?>
    $('#group_holder').show();
<?php else:?>
    $('#group_holder').hide();
<?php endif;?>
    function select_section(class_id) {

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_group/' + class_id,
            success:function (response)
            {
                if(response){
                    $('#group_holder').show();
                    jQuery('#group_holder').html(response); 
                }else{
                    $('#group_holder').hide();
                }                
            }
        });

        $.ajax({
            url: '<?php echo base_url(); ?>index.php?admin/get_section/' + class_id,
            success:function (response)
            {

                jQuery('#section_holder').html(response);
            }
        });
    }

    function mark_all_present() {
        var count = <?php echo count($attendance_of_students); ?>;

        for(var i = 0; i < count; i++)
            $('#status_' + i).val("1");
    }

    function mark_all_absent() {
        var count = <?php echo count($attendance_of_students); ?>;

        for(var i = 0; i < count; i++)
            $('#status_' + i).val("2");
    }
    
</script>




















