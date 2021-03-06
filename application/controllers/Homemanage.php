<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/*
 *	@author 	: Nihal-IT Team
 *	date		: 1 October, 2016
 *	Bidyapith School Management System
 *	https://www.nihalit.com
 *	info@nihalit.com
 */

class Homemanage extends CI_Controller
{

    private $running_year;
	function __construct()
	{
		parent::__construct();
		$this->load->database();
        $this->load->library('session');
        $this->running_year = $this->db->get_where('settings' , array('type' => 'running_year'))->row()->description;
		
       /*cache control*/
		$this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, post-check=0, pre-check=0');
		$this->output->set_header('Pragma: no-cache');
                $this->load->model('dashboard_model');
		
    }
    
    

    function admission_menu()
    {
        $page_data['page_name']  = 'menus/admission_menu';
        $page_data['page_title'] = get_phrase('admission');
        $this->load->view('backend/index', $page_data);
    }

    function manageHomeMenu()
    {
        $page_data['page_name']  = 'menus/manage_home_menu';
        $page_data['page_title'] = get_phrase('manage_website');
        $this->load->view('backend/index', $page_data);
    }

    function ajax_admission_menu_pages()
    {
        $pageName = $_POST['pageName'];
        $page_data['running_year'] = $this->running_year;
        $page_data['page_name'] = $pageName;
        $this->load->view('backend/admin/home/'.$pageName, $page_data);
    }

    function ajax_home_menu_pages()
    {
        $niddle = explode('_',$_POST['pageName']);
        $upper = ucfirst($niddle[1]);
        $pageName = $niddle[0].$upper.'Page';
        $page_data['running_year'] = $this->running_year;
        $page_data['page_data'] = $this->db->get_where('linkinfo',array('track_name'=>'files'))->result_array();
        $page_data['page_name'] = $pageName;
        $this->load->view('backend/admin/home/'.$pageName, $page_data);
    }
    
    function change_logo()
    {        
        $page_data['page_name']  = 'home/logoPage';
        $page_data['page_title'] = get_phrase('change_logo');
        $this->load->view('backend/index', $page_data);
    }
    
    function school_name()
    {
        $page_data['page_name']  = 'home/schoolNamePage';
        $page_data['page_title'] = get_phrase('school_name');
        $this->load->view('backend/index', $page_data);
    }
    
    function social_link()
    {
        $page_data['page_name']  = 'home/socialLinkPage';
        $page_data['page_title'] = get_phrase('social_links');
        $this->load->view('backend/index', $page_data);
    }
    
    function slider()
    {   
        $page_data['page_name']  = 'home/sliderPage';
        $page_data['page_title'] = get_phrase('sliders');
        $this->load->view('backend/index', $page_data);
    }
    
    function important_notice()
	{
        $page_data['page_name']  = 'home/importantNoticePage';
        $page_data['page_title'] = get_phrase('important_notice');
        $this->load->view('backend/index', $page_data);
	}
    
    function notice()
    {
        $page_data['page_name']  = 'home/noticePage';
        $page_data['page_title'] = get_phrase('notice');
        $this->load->view('backend/index', $page_data);
    }

    function change_notice_status()
    {
        $this->db->update('linkinfo',array('status'=>$this->uri(4)),array('id'=>$this->uri(3)));
        if($this->uri(4)==1):
        $this->flashmsg('Notice Published');
        else:
        $this->flashmsg('Notice Drafted');
        endif;
        redirect(base('homemanage', 'notice'));
    }

    function ajax_status_notice()
    {
        $msg = '';
        $this->db->update('linkinfo',array('status'=>$this->uri(4)),array('id'=>$this->uri(3)));
        if($this->uri(4)==1):
            $msg = 'Notice Published';
        else:
            $msg = 'Notice Drafted';
        endif;
        $htmlData = $this->load->view('backend/admin/ajax_elements/notice_table_holder', '', true);
        $this->jsonMsgReturn(true,$msg,$htmlData);
    }

    function change_imnotice_status()
    {
        $this->db->update('linkinfo',array('status'=>$this->uri(4)),array('id'=>$this->uri(3)));
        if($this->uri(4)==1):
        $this->flashmsg('Important Notice Published');
        else:
        $this->flashmsg('Important Notice Drafted');
        endif;
        redirect(base('homemanage', 'important_notice'));
    }

    function ajax_status_important_notice()
    {
        $msg = '';
        $this->db->update('linkinfo',array('status'=>$this->uri(4)),array('id'=>$this->uri(3)));
        if($this->uri(4)==1):
            $msg = 'Important Notice Published';
        else:
            $msg = 'Important Notice Drafted';
        endif;
        $htmlData = $this->load->view('backend/admin/ajax_elements/important_notice_table_holder', '', true);
        $this->jsonMsgReturn(true,$msg,$htmlData);
    }
    
    function manage_home()
    {
        $page_data['page_data'] = $this->db->get_where('linkinfo',array('track_name'=>'files'))->result_array();
        $page_data['page_name']  = 'home/manageHomePage';
        $page_data['page_title'] = get_phrase('manage_home');
        $this->load->view('backend/index', $page_data);
    }
    
    function important_link()
    {
        $page_data['page_name']  = 'home/importantLinkPage';
        $page_data['page_title'] = get_phrase('inportant_links');
        $this->load->view('backend/index', $page_data);
    }
    
    function location()
    {
        $page_data['page_name']  = 'home/locationPage';
        $page_data['page_title'] = get_phrase('location');
        $this->load->view('backend/index', $page_data);
    }
    
    function present()
    {
        $page_data['page_name']  = 'home/presentPage';
        $page_data['page_title'] = get_phrase('student_present_section');
        $this->load->view('backend/index', $page_data);
    }
    
    function gallery()
    {
        $page_data['page_name']  = 'home/galleryPage';
        $page_data['page_title'] = get_phrase('gallery_section');
        $this->load->view('backend/index', $page_data);
    }
    
    function admission_query()
    {
        $page_data['page_name']  = 'home/admission_query';
        $page_data['page_title'] = get_phrase('admission_query');
        $this->load->view('backend/index', $page_data);
    }

    function search_query_list()
    {   
        $class_id = $_POST['class_id'];
        $msg = 'Clsss: '.$this->db->get_where('class',['class_id'=>$class_id])->row()->name;
        $page_data['class_id']  = $class_id;
        $htmlData = $this->load->view('backend/admin/home/admission_query_list', $page_data, true);
        $this->jsonMsgReturn(true,$msg,$htmlData);
    }
            
    function confirm_std()
    {
        $this->load->library('nihalitsms'); 
        $mobile = str_replace('%', '', $this->uri(4));        
        //send url
        $token = encryptor('encrypt', $this->uri(3));
        $url = 'http://freehtmltopdf.com/?convert='.base_url().'index.php?Home/check_token/'.$token;
        $shorten = $this->shorten($url);
        $msg = $sms['desc'].'. '.$shorten;
		//pd($msg);
		
        //call api function
        $smsId = $this->nihalitsms->long_sms_api($msg,$mobile);
        if(is_numeric($smsId)==true){
            $smsToken = $smsId;
        }else{
            $smsToken = '';
        }
        $arr = array(
            'user_id' => $this->uri(3),
            'sms_token' => $smsToken,
            'date' => date('Y-m-d')
        );
        $this->db->insert('sms_token',$arr);
        
        //update status
        $this->db->where('id',$this->uri(3));
        $this->db->update('admit_std',array('status'=>1));
        $this->flashmsg('student_status_confirmd');
        redirect(base('Homemanage', 'admission_query'));
    }
    
    function pendding_std()
    {
        $this->db->where('id',$this->uri(3));
        $this->db->update('admit_std',array('status'=>0));
        $this->flashmsg('student_status_pendding');
        redirect(base('Homemanage', 'admission_query'));
    }
    
    function delete_admit_std()
    {
        unlink('assets/'.$this->uri(4));
        $this->db->where('id',$this->uri(3));
        $this->db->delete('admit_std');
        $this->flashmsg('student_deleted');
        redirect(base('Homemanage', 'admission_query'));
    }

    function ajax_delete_admit_std()
    {        
        $session = ci()->db->get_where('settings', array('type' => 'admission_session'))->row()->description;

        $id = $this->uri(3);
        $id = explode('-',$id);
        $img_id = $id[0];
        $name = $id[1];
        $dir = 'assets/images/admission_student/'.$session.'/'.$name;

        unlink($dir);
        $this->db->where('id',$img_id);
        $this->db->delete('admit_std');
        $this->jsonMsgReturn(true,'Delete Success.');
    }

    function delete_files()
    {
        unlink('assets/otherFiles/'.$this->uri(4));
        $this->dashboard_model->delete_table_files($this->uri(3));
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'manage_home'));
    }
    
    function add_files()
    {
        if(!empty($_FILES['files']['name'])):
        $ext = end(explode(".", $_FILES['files']['name']));
        $name = str_replace(' ','-', $_POST['filetitle']).rand(99, 199);
        $this->load->helper(array('form','url'));
        $config['upload_path'] = './assets/otherFiles/';
        $config['allowed_types'] = '*';
        $config['file_name'] = $name;
        $config['max_size']    = 3072;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('files'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->flashmsg($error['error'],'error');
            redirect(base('homemanage', 'manage_home'));
        }
        else
        {
            $this->upload->data();
            $this->dashboard_model->insertFiles($_POST['filetitle'],$name.'.'.$ext);
            $this->flashmsg('Inserted with file');
            redirect(base('homemanage', 'manage_home'));
        }
        else:
            $this->flashmsg('Please insert file', 'errror');
            redirect(base('homemanage', 'manage_home'));
        endif;
    }
    
    function getPageInfo($value)
    {
        $names = $this->db->get_where('frontpages',array('track_name'=>$value))->row()->title;
        $mark = $this->db->get_where('frontpages',array('track_name'=>$value))->row()->description;
        $Response = array('name' => $names, 'mark' => $mark);
        echo json_encode($Response);
    }
    
    function update_admission_info()
    {
        $data = ['admission_sms_title', 'admission_sms_description', 'admission_exam_date', 'admission_exam_time', 'admission_session','admission_exam_mark'];

        foreach($data as $k=>$each){
            $this->db->where('type', $each);
            $this->db->update('settings',array('description'=>$_POST[$each]));
        }       
                
        $_POST['admission_link_status'] = !empty($_POST['admission_link_status'])?1:0;
        $this->db->where('type', 'admission_link_status');
        $this->db->update('settings',array('description'=>$_POST['admission_link_status']));
        
        $this->flashmsg('update_admission_setting');
        redirect(base('Homemanage', 'admission_query'));
    }

    function ajax_update_admission_info()
    {
        $data = ['admission_sms_title', 'admission_sms_description', 'admission_exam_date', 'admission_exam_time', 'admission_session','admission_exam_mark'];

        foreach($data as $k=>$each){
            $this->db->where('type', $each);
            $this->db->update('settings',array('description'=>$_POST[$each]));
        }       
                
        $_POST['admission_link_status'] = !empty($_POST['admission_link_status'])?1:0;
        $this->db->where('type', 'admission_link_status');
        $this->db->update('settings',array('description'=>$_POST['admission_link_status']));

        $page_data['nihalit'] = $_SESSION['name'] == 'NihalIT'?'Found':'';
        $arr = ['admission_exam_date','admission_exam_time',
        'admission_link_status','admission_sms_title',
        'admission_sms_description','admission_session','admission_exam_mark'];
        foreach($arr as $k=>$each){
            $page_data[$each] = $this->db->get_where('settings',['type'=>$each])->row()->description;
        }
        $htmlData = $this->load->view('backend/admin/ajax_elements/update_admission_info' , $page_data, true);
        $this->jsonMsgReturn(true,'Information Updated.',$htmlData);
    }
    
    //    MANAGE ADMISSION MARK
    
    function add_admission_result()
    {
        $session = $this->db->get_where('settings', 
                ['type'=>'admission_session'])
                    ->row()->description;
        $uniq_id = $this->db->get_where('admission_result',
                ['uniq_id'=>$_POST['uniq_id'], 'session' => $session])
                    ->row()->id;
        $id = $this->db->get_where('admit_std',
                ['uniq_id'=>$_POST['uniq_id'], 'session' => $session])
                    ->row()->id;
        $_POST['std_id'] = $id;
        $_POST['session'] = $session;
        if(!empty($uniq_id)):
            $this->db->where('std_id',$id);
            $this->db->update('admission_result',['mark'=>$_POST['mark']]);
            $this->flashmsg('Mark Updated');
            redirect(base('homemanage', 'admission_result'));
        else:
            $this->db->insert('admission_result',$_POST);
            $this->flashmsg('Mark Inserted');
            redirect(base('homemanage', 'admission_result'));
        endif;        
    }

    function ajax_add_admission_result()
    {
        $session = $this->db->get_where('settings', 
                ['type'=>'admission_session'])
                    ->row()->description;
        $uniq_id = $this->db->get_where('admission_result',
                ['uniq_id'=>$_POST['uniq_id'], 'session' => $session])
                    ->row()->id;
        $id = $this->db->get_where('admit_std',
                ['uniq_id'=>$_POST['uniq_id'], 'session' => $session])
                    ->row()->id;
        $_POST['std_id'] = $id;
        $_POST['session'] = $session;
        if(!empty($uniq_id)):
            $this->db->where('std_id',$id);
            $this->db->update('admission_result',['mark'=>$_POST['mark']]);
            $htmlData = $this->getAdmitStdName($_POST['uniq_id'],'html');
            $this->jsonMsgReturn(true,'Mark Updated.',$htmlData);
        else:
            $this->db->insert('admission_result',$_POST);            
            $htmlData = $this->getAdmitStdName($_POST['uniq_id'],'html');
            $this->jsonMsgReturn(true,'Mark Inserted.',$htmlData);
        endif; 
    }

    function bulk_add_admission_result()
    {
        $session = $this->db->get_where('settings', 
                ['type'=>'admission_session'])
                            ->row()->description;

        foreach($_POST['roll'] as $k=>$each){
            if($_POST['mark'][$k] != ''){      

                $uniq_id = $this->db->get_where('admission_result',
                        ['uniq_id'=>$each, 'session' => $session])
                            ->row()->id;
                $id = $this->db->get_where('admit_std',
                        ['uniq_id'=>$each, 'session' => $session])
                            ->row()->id;
                $data['std_id'] = $id; // table id
                $data['uniq_id'] = $each; // uniq id
                $data['mark']   = $_POST['mark'][$k]; // mark
                $data['session'] = $session; // running session
                if(!empty($uniq_id)):
                    $this->db->where('std_id',$id);
                    $this->db->update('admission_result',['mark'=>$data['mark']]);
                else:
                    $this->db->insert('admission_result',$data);          
                endif;                 
            }
        }
        $this->jsonMsgReturn(true,'Mark Updated.');
    }

    function getValidAddmisionStudent()
    {
        $session = $this->db->get_where('settings', 
                ['type'=>'admission_session'])
                            ->row()->description;
        $uniqId = $this->uri->segment(3);
        $studentUniqId = $this->db->get_where('admit_std',
                        ['uniq_id'=>$uniqId, 'session' => $session])
                            ->row()->id;
        $existMark = $this->db->get_where('admission_result',
                        ['uniq_id'=>$uniqId, 'session' => $session])
                            ->row()->mark;                            
        if(!empty($studentUniqId)){
            if(!empty($existMark)){
                $this->jsonMsgReturn(true,$existMark);    
            } else {
                $this->jsonMsgReturn(true,'');    
            }            
        } else {
            $this->jsonMsgReturn(false,'');    
        }
    }
    
    function getAdmitStdName($value, $html = '')  //ajax response
    {
        $session = $this->db->get_where('settings', 
                        ['type'=>'admission_session'])
                                    ->row()->description;
        // $namebn = $this->db->get_where('admit_std',
        //                 ['uniq_id'=>$value, 'status'=>'1', 'session' => $session])
        //                             ->row()->namebn;
        // $mark = $this->db->get_where('admission_result',
        //                 ['uniq_id'=>$value, 'session' => $session])
        //                             ->row()->mark;
        // $fnamebn = $this->db->get_where('admit_std',
        //                 ['uniq_id'=>$value, 'status'=>'1', 'session' => $session])
        //                             ->row()->fnamebn;              
              
		// if(empty($fnamebn)){
		// 	$fname = '';
		// }else{
		// 	$fname = ' (পিতা: '.$fnamebn.')';
		// }
		
        // if(!empty($mark)){
        //     $stdMark = $mark;
        // }else{
        //     $stdMark = '';
        // }
		// $Response = array('name' => $namebn.$fname, 'mark' => $stdMark);
        // echo json_encode($Response);
        
        $page_data['admission_year'] = $session;
        $page_data['student_id']     = $value;

        if(!empty($html)){
            $htmlData = $this->load->view('backend/admin/admission/ajax_admission_student_info' , $page_data, true);
            return $htmlData;
        } else {
            $this->load->view('backend/admin/admission/ajax_admission_student_info' , $page_data);
        }
        
        
    }
    
    function admission_result()
    {
        $page_data['page_name']  = 'home/admission_result';
        $page_data['page_title'] = get_phrase('admission_result');
        $this->load->view('backend/index', $page_data);
    }
    
    function getClassResult()
    {
        // pd($session);
        unset($_SESSION['flash_message']);
        unset($_SESSION['error']);
        !empty($_POST['group'])?$group=$_POST['group']:$group='';
        $session = $this->db->get_where('settings', 
            ['type'=>'admission_session'])
                    ->result_array();
        $session = $session[0]['description'];
        $this->db->select('*');
        $this->db->from('admit_std');
        $this->db->join('admission_result', 'admission_result.std_id = admit_std.id');
        $this->db->where('admit_std.class',$_POST['class']);
        $this->db->where('admit_std.group', $group);
        $this->db->where('admit_std.session', $session);
        $this->db->order_by('admission_result.mark','desc');
        $query = $this->db->get()->result_array();
        if(!empty($query)):
            $this->flashmsg('Found');
        else:
            $this->flashmsg('Not Found','error');
        endif;        
        $page_data['result']    = $query;
        $page_data['page_name']  = 'home/admission_result';
        $page_data['page_title'] = get_phrase('admission_result');
        $this->load->view('backend/index', $page_data);
    }

    function ajax_getClassResult()
    {
        $sex = $_POST['sex'] == 1?'male':'female';
        $group = !empty($_POST['group'])?$_POST['group']:'';
        $session = $this->db->get_where('settings', 
            ['type'=>'admission_session'])
                    ->row()->description;
        $this->db->select('*');
        $this->db->from('admit_std');
        $this->db->join('admission_result', 'admission_result.std_id = admit_std.id');
        $this->db->where('admit_std.sex',$sex);
        $this->db->where('admit_std.class',$_POST['class']);
        $this->db->where('admit_std.sex', $sex);
        $this->db->where('admit_std.group', $group);
        $this->db->where('admit_std.session', $session);
        $this->db->order_by('admission_result.mark','desc');
        $query = $this->db->get()->result_array();
        if(!empty($query)):
            $page_data['result']    = $query;
            $htmlData = $this->load->view('backend/admin/ajax_elements/admission_result_section_holder' , $page_data, true);
            $this->jsonMsgReturn(true,'Data Found.',$htmlData);            
        else:
            $this->jsonMsgReturn(false,'No Data Found.');
        endif;
    }

    public function transfer_admit_student()
    {
        $fee = $_POST['fee'];
        unset($_POST['fee']);
        
        $this->db->where('id',$_POST['student_id']);
        $data = $this->db->get('admit_std')->result_array();

        // pd($data[0]);
        //student table section
        $admint_student_id = $data[0]['id'];
        unset($data[0]['id']);
        unset($data[0]['student_id']);
        $stdInfo1 = array_slice($data[0], 0, 15);
        $stdInfo1['student_code'] = $stdInfo1['uniq_id'];
        unset($stdInfo1['uniq_id']);
        $studentInfo['jscpecinfo'] = $data[0]['jscinfo'];
        $studentInfo['birthday'] = $data[0]['date'];
        $studentInfo['mobile'] = $data[0]['mobile'];
        $studentInfo['sex'] =  $this->db->get_where('admit_std',['uniq_id'=>$stdInfo1['student_code']])->row()->sex;
        $studentInfo['from_admit_std'] = 'Yes';
        $studentInfo['password'] = substr(md5(rand(0, 1000000)), 0, 7);
        $studentTable = array_merge($stdInfo1,$studentInfo);
        

        // pd($studentTable);
        $this->db->insert('student', $studentTable);
        $enrolInfo['student_id'] = $this->db->insert_id();
        // $this->db->update('admit_std',array('student_id'=>$enrolInfo['student_id']),array('id'=>$admint_student_id));

        //student image rename and move to upload folder
        $session = $this->db->get_where('settings', array('type' => 'admission_session'))->row()->description;
        $ext = strtolower(pathinfo($data[0]['img'], PATHINFO_EXTENSION));
        copy("assets/images/admission_student/$session/".$data[0]['img'], 'uploads/student_image/'.$enrolInfo['student_id'].'.'.$ext);


        //enroll table section
        unset($_POST['student_id']);
        $enrolInfo['enroll_code']    = substr(md5(rand(0, 1000000)), 0, 7); 
        $enrolInfo['date_added']     = strtotime(date("Y-m-d H:i:s"));
        $enrolInfo['year']           = $this->running_year;
        $enrolTable = array_merge($enrolInfo,$_POST);
        // pd($enrolTable);
        $this->db->insert('enroll', $enrolTable);


        //invoice table section
        // $invoiceInfo['student_id']         = $enrolInfo['student_id'];
        // $invoiceInfo['class_id']           = $_POST['class_id'];
        // $invoiceInfo['acc_code']           = $studentTable['student_code'];
        // $invoiceInfo['fee_name']           = 'Admission Fee';
        // $invoiceInfo['fee_amount']         = $fee;
        // $invoiceInfo['description']        = 'Admission Fee';
        // $invoiceInfo['amount']             = $fee;
        // $invoiceInfo['amount_paid']        = $fee;
        // $invoiceInfo['due']                = '';
        // $invoiceInfo['status']             = 'paid';
        // $invoiceInfo['creation_timestamp'] = strtotime(date('m/d/Y'));
        // $invoiceInfo['year']               = $this->running_year;
       
        // $this->db->insert('invoice', $invoiceInfo);
        // $invoice_id = $this->db->insert_id();

        //payment table section
        // $paymentInfo['invoice_id']        =   $invoice_id;
        // $paymentInfo['student_id']        =   $enrolInfo['student_id'];
        // $paymentInfo['title']             =   'Admission Fee';
        // $paymentInfo['description']       =   'Admission Fee';
        // $paymentInfo['payment_type']      =   'income';
        // $paymentInfo['method']            =   '1';
        // $paymentInfo['amount']            =   $fee;
        // $paymentInfo['timestamp']         =   strtotime(date('m/d/Y'));
        // $paymentInfo['year']              =   $this->running_year;
        // $this->db->insert('payment' , $paymentInfo);

        // UPDATE STUDENT STATUS IN ADMISSION TABLE
        $this->db->update('admit_std',['status'=>2],['uniq_id'=>$stdInfo1['student_code']]);
        
        $_SESSION['stdClass'] = $data[0]['class'];
        $_SESSION['stdGroup'] = notEmpty($data[0]['group']);

        $this->flashmsg('Student Admitted Successfuly');
        redirect(base('homemanage', 'admission_result'));
    }

    function updateHeaderImg()
    {
        $configUpload['upload_path']    = './assets/otherFiles';               
        $configUpload['allowed_types']  = '*';     
        $configUpload['max_size']       = '1024'; 
        $configUpload['max_width']      = '1500';  
        $configUpload['max_height']     = '300';    
        $configUpload['overwrite']      = TRUE;    
        $configUpload['file_name']      = 'header_image';                  
        $this->upload->initialize($configUpload);   
        if(!$this->upload->do_upload('header_img')){
            $uploadedDetails    = $this->upload->display_errors();
            $this->flashmsg('Error', 'error');
            redirect(base('admin', 'system_settings'));
        }else{
            $uploadedDetails    = $this->upload->data(); 
            $this->db->update('settings',array('description'=>$uploadedDetails['file_name']), array('settings_id'=>30));
            $this->flashmsg('Update Header Image');
            redirect(base('admin', 'system_settings'));
        }
    }

    function ajax_update_header_image()
    {
        $configUpload['upload_path']    = './assets/otherFiles';               
        $configUpload['allowed_types']  = '*';     
        $configUpload['max_size']       = '1024'; 
        $configUpload['max_width']      = '1500';  
        $configUpload['max_height']     = '300';    
        $configUpload['overwrite']      = TRUE;    
        $configUpload['file_name']      = 'header_image';                  
        $this->upload->initialize($configUpload);   
        if(!$this->upload->do_upload('header_img')){
            $uploadedDetails    = $this->upload->display_errors();
            $this->jsonMsgReturn(false,$uploadedDetails);
        }else{
            $uploadedDetails    = $this->upload->data(); 
            $this->db->update('settings',array('description'=>$uploadedDetails['file_name']), array('settings_id'=>30));
            $this->jsonMsgReturn(true,'Update Header Image');
        }
    }
	

    
    
    
            
            
    
    
    
    
    
    
    
    
    
    
    
    
    
    
    function add_logo()
    {
        $img = mt_rand().'_logo_img';
        $this->upload->initialize(upload_file(500,1000,1000,$img));
        if ( ! $this->upload->do_upload('logo_img')) 
        {
           $error = array('error' => $this->upload->display_errors());
           $this->flashmsg($error['error'],'error');
           redirect(base('homemanage', 'change_logo'));
        }else 
        {          
           //Image Resizing            
            $this->load->library('image_lib', resize_file(130,130));
            if ( ! $this->image_lib->resize())
            {               
                set_flashmsg($this->image_lib->display_errors(), 'error');
                $this->flashmsg($this->image_lib->display_errors(),'error');
                redirect(base('homemanage', 'change_logo'));
            }
        }
        $img_name = $this->upload->file_name;
        unlink('assets/'.$_POST['preimg']);
        $this->dashboard_model->insert_logo_img($img_name,$_POST['title']);
        $this->flashmsg('logo_updated');
        redirect(base('homemanage', 'change_logo'));
    }
    
    function add_header_info()
    {
        $implod = implode('+', $_POST);
        $this->dashboard_model->update_textinfo_table($implod, 'header_title');
        $this->flashmsg('header_info_updated');
        redirect(base('homemanage', 'school_name'));
    }
    
    function add_social_link()
    {
        $implod = implode('+', $_POST);
        $this->dashboard_model->update_textinfo_table($implod, 'social_links');
        $this->flashmsg('links_updated');
        redirect(base('homemanage', 'social_link'));
    }

    function ajax_update_social_link()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else { 
            $implod = implode('+', $_POST);
            $this->dashboard_model->update_textinfo_table($implod, 'social_links');
            $this->jsonMsgReturn(true,'Edit Success.');
        }
    }
    
    function add_slider()
    {
        //pd($_POST);
        $implod = implode('+', $_POST);
        $img = mt_rand().'_slider_img';
        $this->upload->initialize(upload_file_slider(1000,2000,2000,$img));
        if ( ! $this->upload->do_upload('img')) 
        {
           $error = array('error' => $this->upload->display_errors());
           set_flashmsg($error['error'], 'error');
           redirect(base('homemanage', 'slider'));
        }else 
        {          
           //Image Resizing            
            $this->load->library('image_lib', resize_file(770,400));
            if ( ! $this->image_lib->resize())
            {               
                set_flashmsg($this->image_lib->display_errors(), 'error');
                redirect(base('homemanage', 'slider'));
            }
        }
        $img_name = $this->upload->file_name;
        $this->dashboard_model->insert_imgTable($img_name,$implod,'slider');
        $this->flashmsg('inserted');
        redirect(base('homemanage', 'slider'));
    }

    function ajax_add_slider()
    {
        $check = check_array_value($_POST);
        if($check == false && empty($_FILES['img']['name'])){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else { 
            $implod = implode('+', $_POST);
            $img = mt_rand().'_slider_img';
            $this->upload->initialize(upload_file_slider(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) {
                $error = array('error' => $this->upload->display_errors());
                $this->jsonMsgReturn(false,$error);
            } else {      
                $ext = explode('.',$_FILES['img']['name']);    
                //Image Resizing    

                $this->load->library('image_lib', resize_file(770,400));
                $this->image_lib->resize();
                $img_name = $this->upload->file_name;
                $this->dashboard_model->insert_imgTable($img_name,$implod,'slider');

                $htmlData = $this->load->view('backend/admin/ajax_elements/slider_table_holder' , '', true);
                $this->jsonMsgReturn(true,'Add Success.',$htmlData);
            }            
        }
        
    }

    function ajax_edit_slider()
    {
        $slider_id = $this->uri(3);  
        $page_data['slider_id']   = $slider_id;
        $htmlData = $this->load->view('backend/admin/ajax_elements/edit_slider_form_holder' , $page_data, true);
        $this->jsonMsgReturn(true,'Edit Mode.',$htmlData);
    }
    
    function update_slider()
    {
        if(!empty($_FILES['img']['name'])){
            $id = $_POST['id'];
            $img = mt_rand().'_slider_img';
            $this->upload->initialize(upload_file_slider(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) 
            {
               $error = array('error' => $this->upload->display_errors());
               $this->flashmsg($error['error'],'error');
               redirect(base('homemanage', 'slider'));
            }else 
            {          
               //Image Resizing            
                $this->load->library('image_lib', resize_file(770,400));
                if ( ! $this->image_lib->resize())
                {               
                    $this->flashmsg($this->image_lib->display_errors(),'error');
                    redirect(base('homemanage', 'slider'));
                }
            }
            unlink('assets/images/slider_image/'.$_POST['Preimg']);
            unset($_POST['Preimg']);
            unset($_POST['id']);
            $implod = implode('+', $_POST);
            $img_name = $this->upload->file_name;
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'slider');
            $this->flashmsg('Updated');
            redirect(base('homemanage', 'slider'));
        } else {            
            $id = $_POST['id'];
            $img_name = $_POST['Preimg'];
            unset($_POST['Preimg']);
            unset($_POST['id']);
            unset($_POST['img']);
            $implod = implode('+', $_POST);
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'slider');
            $this->flashmsg('Updated without image');
            redirect(base('homemanage', 'slider'));
        }
    }

    function ajax_update_slider()
    {
        if(!empty($_FILES['img']['name'])){
            $id = $_POST['id'];
            $img = mt_rand().'_slider_img';
            $this->upload->initialize(upload_file_slider(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) {
               $error = array('error' => $this->upload->display_errors());
               $this->jsonMsgReturn(false,$error);
            } else {
               //Image Resizing            
                $this->load->library('image_lib', resize_file(770,400));  
                $this->image_lib->resize();              
            }
            unlink('assets/images/slider_image/'.$_POST['Preimg']);
            unset($_POST['Preimg']);
            unset($_POST['id']);
            $implod = implode('+', $_POST);
            $img_name = $this->upload->file_name;
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'slider');
            $status = 'Update With Image';
        } else {            
            $id = $_POST['id'];
            $img_name = $_POST['Preimg'];
            unset($_POST['Preimg']);
            unset($_POST['id']);
            unset($_POST['img']);
            $implod = implode('+', $_POST);
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'slider');
            $status = 'Update With Previous Image';
        }
        $htmlData['imageHolder'] = $this->load->view('backend/admin/ajax_elements/slider_table_holder' , '', true);
        $htmlData['addForm'] = $this->load->view('backend/admin/ajax_elements/add_slider_form_holder' , '', true);
        $this->jsonMsgReturn(true,$status,$htmlData);        
    }

    function ajax_delete_slider()
    {
        $id = $this->uri(3);
        $id = explode('-',$id);
        $img_id = $id[0];
        $name = $id[1];
        unlink('assets/images/slider_image/'.$name);
        $this->dashboard_model->delete_imgTable_info($img_id);
        $this->jsonMsgReturn(true,'Delete Success');
    }
    
    function delete_slider()
    {
        $id = $this->uri(3);
        $name = $this->uri(4);
        unlink('assets/images/slider_image/'.$name);
        $this->dashboard_model->delete_imgTable_info($id);
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'slider'));
    }
    
    function add_notice()
    {
        $Insert_id = $this->dashboard_model->insert_linkinfo_table($_POST,'notice');
        if(!empty($_FILES['file']['name'])):
        $this->load->helper(array('form','url'));
        $config['upload_path'] = './assets/otherFiles/';
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = $Insert_id.'_noticepdf';
        $config['max_size']    = 200;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->flashmsg($error['error'],'error');
            redirect(base('homemanage', 'notice'));
        }else
        {
            $this->upload->data();
            $this->flashmsg('Inserted with PDF file');
            redirect(base('homemanage', 'notice'));
        }
        else:
            $this->flashmsg('Inserted without file');
            redirect(base('homemanage', 'notice'));
        endif;
        
    }

    function ajax_add_notice()
    {
        $check = check_array_value($_POST,['file']);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {    
            $Insert_id = $this->dashboard_model->insert_linkinfo_table($_POST,'notice');
            if(!empty($_FILES['file']['name'])):
            $this->load->helper(array('form','url'));
            $config['upload_path'] = './assets/otherFiles/';
            $config['allowed_types'] = 'pdf';
            $config['file_name'] = $Insert_id.'_noticepdf';
            $config['max_size']    = 200;
            $this->upload->initialize($config);
            if (!$this->upload->do_upload('file')) {
                $error = array('error' => $this->upload->display_errors());                
            } else {
                $this->upload->data();
                $msg = 'Inserted with PDF file';
            }
            else:
                $msg = 'Inserted without file';
            endif;
            

            $htmlData = $this->load->view('backend/admin/ajax_elements/notice_table_holder' , '', true);
            if(!empty($error)){
                $this->jsonMsgReturn(false,$error,$htmlData);
            } else {
                $this->jsonMsgReturn(true,$msg,$htmlData);
            }
            
        }
    }

    function ajax_edit_notice()
    {
        $noticeID = $this->uri(3);
        $page_data['noticeID']   = $noticeID;
        $htmlData = $this->load->view('backend/admin/ajax_elements/edit_notice_form_holder' , $page_data, true);
        $this->jsonMsgReturn(true,'Edit Moad ON',$htmlData);
    }

    function ajax_update_notice()
    {
        $check = check_array_value($_POST,['file']);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $this->dashboard_model->update_linkinfo_table($_POST,'notice');
            if(!empty($_FILES['file']['name'])){
                if(file_exists('assets/otherFiles/'.$_POST['id'].'_noticepdf.pdf')==true){
                    unlink('assets/otherFiles/'.$_POST['id'].'_noticepdf.pdf');
                }
                $this->load->helper(array('form','url'));
                $config['upload_path'] = './assets/otherFiles/';
                $config['allowed_types'] = 'pdf';
                $config['file_name'] = $_POST['id'].'_noticepdf';
                $config['max_size']    = 3072;
                $this->upload->initialize($config);
                if (!$this->upload->do_upload('file')){
                    $error = array('error' => $this->upload->display_errors());                
                } else {
                    $this->upload->data();
                    $msg = 'Update with PDF file';
                }
            } else {
                $msg = 'Update without file';
            }

            $htmlData['noticeHolder'] = $this->load->view('backend/admin/ajax_elements/notice_table_holder', '', true);
            $htmlData['addForm'] = $this->load->view('backend/admin/ajax_elements/add_notice_form_holder', '', true);
            if(!empty($error)) {
                $this->jsonMsgReturn(false,$error,$htmlData);
            } else {
                $this->jsonMsgReturn(true,$msg,$htmlData);
            }
        }
    }
    
    function update_notice()
    {
        $this->dashboard_model->update_linkinfo_table($_POST,'notice');
        if(!empty($_FILES['file']['name'])):
        if(file_exists('assets/otherFiles/'.$_POST['id'].'_noticepdf.pdf')==true):
            unlink('assets/otherFiles/'.$_POST['id'].'_noticepdf.pdf');
        endif;        
        $this->load->helper(array('form','url'));
        $config['upload_path'] = './assets/otherFiles/';
        $config['allowed_types'] = 'pdf';
        $config['file_name'] = $_POST['id'].'_noticepdf';
        $config['max_size']    = 3072;
        $this->upload->initialize($config);
        if (!$this->upload->do_upload('file'))
        {
            $error = array('error' => $this->upload->display_errors());
            $this->flashmsg($error['error'],'error');
            redirect(base('homemanage', 'notice'));
        }
        else
        {
            $this->upload->data();
            $this->flashmsg('Updated with PDF file');
            redirect(base('homemanage', 'notice'));
        }
        else:
            $this->flashmsg('Updated without file');
            redirect(base('homemanage', 'notice'));
        endif;
    }
    
    function delete_notice()
    {
        $this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'notice'));
    }

    function ajax_delete_notice()
    {
        $this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->jsonMsgReturn(true,'Delete Success');
    }
    
    function add_important_notice()
	{
		$data['track_name'] = 'imnotice';
		$data['title'] = $_POST['title'];
		$data['description'] = $_POST['description'];
		$data['link'] = '';
		$this->db->insert('linkinfo',$data);
		$this->flashmsg('Insert important notice');
		redirect(base('homemanage', 'important_notice'));
    }
    
    function ajax_add_important_notice()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $data['track_name'] = 'imnotice';
            $data['title'] = $_POST['title'];
            $data['description'] = $_POST['description'];
            $data['link'] = '';
            $this->db->insert('linkinfo',$data);

            $htmlData = $this->load->view('backend/admin/ajax_elements/important_notice_table_holder', '', true);
            $this->jsonMsgReturn(true,'Add Success.', $htmlData);
        }
    }

    function ajax_edit_important_notice()
    {
        $imNoticeId = $this->uri(3);
        $page_data['imNoticeId']   = $imNoticeId;
        $htmlData = $this->load->view('backend/admin/ajax_elements/edit_important_notice_form_holder' , $page_data, true);
        $this->jsonMsgReturn(true,'Edit Moad ON',$htmlData);
    }

    function ajax_update_important_notice()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $this->dashboard_model->update_linkinfo_table($_POST,'imnotice');

            $htmlData['noticeHolder'] = $this->load->view('backend/admin/ajax_elements/important_notice_table_holder', '', true);
            $htmlData['addForm'] = $this->load->view('backend/admin/ajax_elements/add_important_notice_form_holder', '', true);
            $this->jsonMsgReturn(true,'Update Success',$htmlData);
        }
    }
	
	function update_important_notice()
	{
		$this->dashboard_model->update_linkinfo_table($_POST,'imnotice');
		$this->flashmsg('Updated important notice');
		redirect(base('homemanage', 'important_notice'));		
	}
	
	function delete_important_notice()
	{
		$this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'important_notice'));
    }
    
    function ajax_delete_important_notice()
    {
        $this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->jsonMsgReturn(true,'Delete Success');
    }    
    
    function update_manage_pages()
    {
        $tname = $_POST['track_name'];
        unset($_POST['track_name']);
        $this->db->where('track_name',$tname);
        $this->db->update('frontpages',$_POST);
        $this->flashmsg('Updated');
        redirect(base('homemanage', 'manage_home'));
    }
    
    function add_important_link()
    {
        $this->dashboard_model->insert_linkinfo_table($_POST,'link');
        $this->flashmsg('Inserted');
        redirect(base('homemanage', 'important_link'));
    }

    function ajax_add_important_link()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $this->dashboard_model->insert_linkinfo_table($_POST,'link');

            $htmlData = $this->load->view('backend/admin/ajax_elements/important_link_table_holder', '', true);
            $this->jsonMsgReturn(true,'Link Created.',$htmlData);
        }
    }

    function ajax_edit_important_link()
    {
        $imLink_id = $this->uri(3);
        $page_data['imLink_id']   = $imLink_id;
        $htmlData = $this->load->view('backend/admin/ajax_elements/edit_important_link_form_holder' , $page_data, true);
        $this->jsonMsgReturn(true,'Edit Moad ON',$htmlData);
    }

    function ajax_update_important_link()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $this->dashboard_model->update_linkinfo_table($_POST,'link');

            $htmlData['imLinkTable'] = $this->load->view('backend/admin/ajax_elements/important_link_table_holder', '', true);
            $htmlData['addForm'] = $this->load->view('backend/admin/ajax_elements/add_important_link_form_holder', '', true);
            $this->jsonMsgReturn(true,'Update Success',$htmlData);
        }
    }
    
    function update_link()
    {
        $this->dashboard_model->update_linkinfo_table($_POST,'link');
        $this->flashmsg('Updated');
        redirect(base('homemanage', 'important_link'));
    }
    
    function delete_link()
    {
        $this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'important_link'));
    }

    function ajax_delete_link()
    {
        $this->dashboard_model->delete_linkinfo_table($this->uri(3));
        $this->jsonMsgReturn(true,'Delete Success');
    }
    
    function update_location()
    {
        $this->dashboard_model->update_textinfo_table($_POST['code'], 'location');
        $this->flashmsg('Updated');
        redirect(base('homemanage', 'location'));
    }

    function ajax_update_location()
    {
        $check = check_array_value($_POST);
        if(!$check){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else {
            $this->dashboard_model->update_textinfo_table($_POST['code'], 'location');

            $htmlData = $this->load->view('backend/admin/ajax_elements/location_iframe_holder', '', true);
            $this->jsonMsgReturn(true,'Update Location',$htmlData);
        }
    }
    
    function update_present_section()
    {
        if($_POST['status']=='on'){
            $status = 1;
        }else{
            $status = 0;
        }
        $this->dashboard_model->update_textinfo_table($status, 'present');
        $this->flashmsg('Updated');
        redirect(base('homemanage', 'present'));
    }

    function ajax_update_present_section()
    {
        if($_POST['status']=='on'){
            $status = 1;
            $msg = 'Website is now <b>Online</b>';
        }else{
            $status = 0;
            $msg = 'Website is now <b>Offline</b>';
        }
        $this->dashboard_model->update_textinfo_table($status, 'present');
        $this->jsonMsgReturn(true,$msg);
    }
    
    function add_gallery()
    {
        //pd($_POST);
        $implod = implode('+', $_POST);
        $img = mt_rand().'_gallery_img';
        $this->upload->initialize(upload_file_gallery(1000,2000,2000,$img));
        if ( ! $this->upload->do_upload('img')) 
        {
           $error = array('error' => $this->upload->display_errors());
           $this->flashmsg($error['error'], 'error');
           redirect(base('homemanage', 'gallery'));
        }else 
        {                    
           //Image Resizing            
            $this->load->library('image_lib', resize_file(700,700));
            if ( ! $this->image_lib->resize())
            {               
                $this->flashmsg($this->image_lib->display_errors(), 'error');
                redirect(base('homemanage', 'gallery'));
            }
        }
        $img_name = $this->upload->file_name;
        $this->dashboard_model->insert_imgTable($img_name,$implod,'gallery');
        $this->flashmsg('Inserted');
        redirect(base('homemanage', 'gallery'));  
        
    }

    function ajax_add_gallery()
    {
        $check = check_array_value($_POST);
        if($check == false && empty($_FILES['img']['name'])){
            $this->jsonMsgReturn(false,'Please Fill All Field Properly.');
        } else { 
            $implod = implode('+', $_POST);
            $img = mt_rand().'_gallery_img';
            $this->upload->initialize(upload_file_gallery(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) {
                $error = array('error' => $this->upload->display_errors());
                $this->jsonMsgReturn(false,$error);
            } else {          
                //Image Resizing            
                $this->load->library('image_lib', resize_file(700,700));
                $this->image_lib->resize();

                $img_name = $this->upload->file_name;
                $this->dashboard_model->insert_imgTable($img_name,$implod,'gallery');

                $htmlData = $this->load->view('backend/admin/ajax_elements/gallery_table_holder' , '', true);
                $this->jsonMsgReturn(true,'Add Success.',$htmlData);
            }            
        }
    }

    function ajax_edit_gallery()
    {
        $gallery_id = $this->uri(3);  
        $page_data['gallery_id']   = $gallery_id; 

        $htmlData = $this->load->view('backend/admin/ajax_elements/edit_gallery_form_holder' , $page_data, true);
        $this->jsonMsgReturn(true,'Edit Mode.',$htmlData);
    }

    function ajax_update_gallery()
    {
        if(!empty($_FILES['img']['name'])){
            $id = $_POST['id'];
            $img = mt_rand().'_gallery_img';
            $this->upload->initialize(upload_file_gallery(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) {
               $error = array('error' => $this->upload->display_errors());
               $this->jsonMsgReturn(false,$error);
            } else {
               //Image Resizing            
                $this->load->library('image_lib', resize_file(700,700));   
                $this->image_lib->resize();           
            }
            unlink('assets/images/gallery_image/'.$_POST['Preimg']);
            unset($_POST['Preimg']);
            unset($_POST['id']);
            $implod = implode('+', $_POST);
            $img_name = $this->upload->file_name;
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'gallery');
            $status = 'Update With Image';
        } else {            
            $id = $_POST['id'];
            $img_name = $_POST['Preimg'];
            unset($_POST['Preimg']);
            unset($_POST['id']);
            unset($_POST['img']);
            $implod = implode('+', $_POST);
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'gallery');
            $status = 'Update With Previous Image';
        }
        
        $htmlData['imageHolder'] = $this->load->view('backend/admin/ajax_elements/gallery_table_holder', '', true);
        $htmlData['addForm'] = $this->load->view('backend/admin/ajax_elements/add_gallery_form_holder', '', true);
        $this->jsonMsgReturn(true,$status,$htmlData);
    }
    
    function update_galleryInfo()
    {
        if(!empty($_FILES['img']['name'])){
            $id = $_POST['id'];
            $img = mt_rand().'_gallery_img';
            $this->upload->initialize(upload_file_gallery(1000,2000,2000,$img));
            if ( ! $this->upload->do_upload('img')) 
            {
               $error = array('error' => $this->upload->display_errors());
               $this->flashmsg($error['error'], 'error');
               redirect(base('homemanage', 'gallery'));
            }else 
            {          
               //Image Resizing            
                $this->load->library('image_lib', resize_file(700,700));
                if ( ! $this->image_lib->resize())
                {               
                    $this->flashmsg($this->image_lib->display_errors(), 'error');
                    redirect(base('homemanage', 'gallery'));
                }
            }
            unlink('assets/images/gallery_image/'.$_POST['Preimg']);
            unset($_POST['Preimg']);
            unset($_POST['id']);
            $implod = implode('+', $_POST);
            $img_name = $this->upload->file_name;
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'gallery');
            $this->flashmsg('Updated');
            redirect(base('homemanage', 'gallery'));
        }else{
            
            $id = $_POST['id'];
            $img_name = $_POST['Preimg'];
            unset($_POST['Preimg']);
            unset($_POST['id']);
            unset($_POST['img']);
            $implod = implode('+', $_POST);
            $this->dashboard_model->update_imgTable($id,$img_name,$implod,'gallery');
            $this->flashmsg('update_without_image');
            redirect(base('homemanage', 'gallery'));
        }
    }
    
    function delete_galleryImg()
    {
        $id = $this->uri(3);
        $name = $this->uri(4);
        unlink('assets/images/gallery_image/'.$name);
        $this->dashboard_model->delete_imgTable_info($id);
        $this->flashmsg('Deleted');
        redirect(base('homemanage', 'gallery'));
    }

    function ajax_delete_galleryImg()
    {
        $id = $this->uri(3);
        $id = explode('-',$id);
        $img_id = $id[0];
        $name = $id[1];
        unlink('assets/images/gallery_image/'.$name);
        $this->dashboard_model->delete_imgTable_info($img_id);
        $this->jsonMsgReturn(true,'Delete Success',$name);
    }


    function update_site_color()
    {
        $this->db->where('title', 'main_color');
        $var = $this->db->update('frontpages', array('description' => $_POST['main_color']));

        $this->db->where('title', 'hover_color');
        $var = $this->db->update('frontpages', array('description' => $_POST['hover_color']));
        $this->flashmsg('Color Changed.');
        redirect(base('admin', 'system_settings'));
    }
	
 
    // ======== TRUNCATE TABLE SECTION
    
    function cleanAdmitStdTable()
    {
        $this->db->truncate('admit_std'); 
        $this->flashmsg('Clean Admission Student Table');
        redirect(base('admin', 'system_settings'));
    }
    
    function cleanAdmitStdResultTable()
    {
        $this->db->truncate('admission_result'); 
        $this->flashmsg('Clean Admission Student Result Table');
        redirect(base('admin', 'system_settings'));
    }
    
    function cleanUrlTokenTable()
    {
        $this->db->truncate('admission_token'); 
        $this->flashmsg('Clean Url Token Table');
        redirect(base('admin', 'system_settings'));
    }
   
    
    
    //   ========= REUSEABLE FUNCTION

    function jsonMsgReturn($type, $msg, $html='') 
    {
        echo json_encode(['type'=>$type,'msg'=>$msg,'html'=>$html]);
    }

    function flashmsg($msg,$error = '')
    {
        if(!empty($error)):
            $this->session->set_flashdata('error' , get_phrase($msg));
        else:
            $this->session->set_flashdata('flash_message' , get_phrase($msg));
        endif;
    }
    
    function uri($uri)
    {
        $result = $this->uri->segment($uri);
        return $result;
    }
    
    function shorten($url)
    {
        $this->load->helper('bitlyurl');
        $params = array();
        $params['access_token'] = '84de1a5d29fb01105a4496292726a8b598b03328';
        $params['longUrl'] = $url;
        $params['domain'] = 'j.mp';
        $results = bitly_get('shorten', $params);
        return $results['data']['url'];
    }
}    