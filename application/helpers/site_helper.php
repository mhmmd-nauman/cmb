<?php

if(!function_exists('sendPostRequest'))
{
   function sendPostRequest($url,$_param=array())
    {
        $ci=&get_instance();
        /*$ci->load->library('guzzle');
        $client=$ci->guzzle->newClient();
       // $response = $client->request('GET', 'https://api.github.com/repos/guzzle/guzzle');

        $response = $client->request('POST', $url, [
            'form_params' => $_param
        ]);


        var_dump($response);exit;
        $response = $client->request( 'POST',
            $url,
            [ 'form_params'
            => $_param
            ]
        );*/


        try {
        $curl = curl_init();
        curl_setopt_array($curl, array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_USERAGENT => 'Codular Sample cURL Request',
            CURLOPT_POST => 1,
            CURLOPT_POSTFIELDS => $_param,
            CURLOPT_SSL_VERIFYPEER=>false
        ));

        $output = curl_exec($curl);
        if ($output === false) {
            throw new Exception(curl_error($curl), curl_errno($curl));

        }
        } catch(Exception $e) {

            trigger_error(sprintf(
                'Curl failed with error #%d: %s',
                $e->getCode(), $e->getMessage()),
                E_USER_ERROR);

        }
        return $output;
}
}

function get_enum_values( $table, $field )
{
    $ci=& get_instance();
    if(strpos($table,'adm_')===false)
        $table=$ci->db->dbprefix($table);
    $type = $ci->db->query( "SHOW COLUMNS FROM {$table} WHERE Field = '{$field}'" )->row( 0 )->Type;
    preg_match("/^enum\(\'(.*)\'\)$/", $type, $matches);
    $enum = explode("','", $matches[1]);
    return $enum;
}

function writeExcelFile($title='ExcelSheet',$data=array(),$header=null,$return_file_path=false)
{
    $CI=& get_instance();
    $CI->load->library('excel');

    $objPHPExcel = new PHPExcel();
    $objPHPExcel->disconnectWorksheets();
    $myWorkSheet = new PHPExcel_Worksheet($objPHPExcel, substr($title,0,15));
    $objPHPExcel->addSheet($myWorkSheet, 0);
    $objPHPExcel->setActiveSheetIndex(0);
    if($header==null)
    {
        $objPHPExcel->getActiveSheet()->fromArray($data);
    }else
    {
        $objPHPExcel->getActiveSheet()->fromArray($header, null, 'A1');
        $objPHPExcel->getActiveSheet()->fromArray($data	, null,"A2");
    }
    foreach (range(0, count(@$data[0])-1) as $col) {
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($col)->setAutoSize(true);
    }
    $file_name=$title;
    $file_parts=pathinfo($file_name);
    $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
    if(@$file_parts['extension']===null)
    {
        $file_name.=".xlsx";

    }else if($file_parts['extension']=="csv")
    {
        $objWriter = new PHPExcel_Writer_CSV($objPHPExcel);
    }
    $file_path=FCPATH.("uploads/temp_pdf/$file_name");
    $objWriter->save( $file_path);
    if($return_file_path===false)
    {
        header('Content-Disposition: attachment;filename="'.$file_name.'"');
        echo file_get_contents($file_path);
        @unlink($file_path);
    }else
    {
        return $file_path;
    }
    return 1;
}
function getSingle($tbl,$field,$id,$value) {
    $result = '';
    $ci = & get_instance();
    $ci->db->select("$field as field");
    $ci->db->where($id, $value);
    $ci->db->limit(1);
    $query = $ci->db->get($tbl);
    if ($query->num_rows() > 0) {
        $result = $query->row('field');
    }else
        $result=0;
    return $result;
}
function get_rows($query){
    $c=  & get_instance();
    $result = $c->db->query($query);
    return $result->result();	
}
function db_record_exists($tbl,$where_array)
{
    $ci =& get_instance();
    $ci->db->where($where_array);
    $query = $ci->db->get($tbl);
    if ($query->num_rows() > 0){
        return true;
    }
    else{
        return false;
    }
}


function generic_select($tbl,$conditions=null,$orderBy=null,$limit=null,$start=0)
{
    $ci = & get_instance();
    return $ci->generic_model->generic_select($tbl,$conditions,$orderBy,$limit,$start);
}

function getDistinct($tbl,$distinctField,$conditions=null,$orderBy=null,$limit=null,$start=0)
{
    $ci = & get_instance();
    return $ci->generic_model->getDistinct($tbl,$distinctField,$conditions,$orderBy,$limit,$start);
}

function tbl_count($tbl,$conditions=null)
{
    $ci = & get_instance();
    return $ci->generic_model->record_count($tbl,$conditions);
}

function generic_select_row($tbl,$conditions=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->generic_select($tbl,$conditions,null,1);
    if(isset($data[0]))
       return $data[0];
else
    return null ;
}


function getMaxRec($tbl,$key,$condition=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->getRec($tbl,$key,$condition);
    return $data;
}

function is_login($user_type=null,$redirect=true)
{
    $ci=& get_instance();
    if($user_type==null)
    {
        if($ci->session->userdata('is_logged_in'))
        {
            return true;
        }else if($redirect)
        {
            redirect(base_url('login'));

        }else
        {
            return false;
        }
    }else
    {
        if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')==strtolower($user_type)||$ci->session->userdata('username')==strtolower($user_type)||$ci->session->userdata('is_admin')))
        {
            return true;
        }else if($redirect)
        {
            $ci->session->set_flashdata('message', 'Access Denied');
            redirect(base_url());

        }else
        {
            return false;
        }
    }

}

function join_select_Table_array($select_data,$frmTbl, $tbl_array_field, $condition=null,$group_by=null,$orderBy=null,$result_as_array=null,$condition_or=null,$return_query=null,$limit=null,$start=0)
{
    $ci = & get_instance();
    $data=$ci->generic_model->joinselect_arrayTable($select_data,$frmTbl, $tbl_array_field, $condition,$group_by,$orderBy,$result_as_array,$condition_or,$return_query,$limit,$start);
    return $data;
}




function is_admin($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&$ci->session->userdata('is_admin'))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_faculty($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Faculty'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_tender($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='tenders'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}function is_pro($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='pro'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_uploader($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='uploader'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_dr_user($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='DR'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_application_viewer($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Application_viewer'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}

function is_admission_committee($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Admission_committee'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_admission_committee_dr($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='admission_committee_dr'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url('cms'));

    }else
    {
        return false;
    }
}
function is_admission_entryuser($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='Admissions_entryuser'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url());

    }else
    {
        return false;
    }
}
function is_library_committee($redirect=true)
{
    $ci=& get_instance();
    if($ci->session->userdata('is_logged_in')&&($ci->session->userdata('user_type')=='library_committee'||$ci->session->userdata('is_admin')))
    {
        return true;
    }else if($redirect)
    {
        $ci->session->set_flashdata('message', 'Access Denied');
        redirect(base_url('cms'));

    }else
    {
        return false;
    }
}

function join_select($select_data, $tbl, $tbl_fild, $join_tbl, $join_fild, $condition=null,$type=null,$group_by=null,$orderBy=null)
{
    $ci = & get_instance();
    $data=$ci->generic_model->joinselect($select_data, $tbl, $tbl_fild, $join_tbl, $join_fild, $condition,$type,$group_by,$orderBy);
    return $data;
}

function redirectToReffrer()
{
    $ci=& get_instance();
    $ref = $ci->input->server('HTTP_REFERER', TRUE);
    redirect($ref, 'location');
}

function IsNotEmpty($field){
    return !(trim($field)===''||$field===null||$field=='0000-00-00'||$field=='0');
}
function slug_genrator($txt,$tbl)
{
    $ci = & get_instance();
    $text= $txt;
    // replace non letter or digits by -
    if($txt!=null)
    {
        $text= $txt;
    }
    $text = preg_replace('~[^\\pL\d]+~u', '-', $text);

    // trim
    $text = trim($text, '-');

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // lowercase
    $text = strtolower($text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    if (empty($text))
    {
        $text= 'n-a';
    }

    if($ci->generic_model->selectwhere($tbl, 'slug', $text))
    {
        $text=slug_genrator($text.'-'.rand(1,999),$tbl);
    }
    return $text;


}

function insert_db($tbl, $data, $isBatchInsertion = null, $return_inserted_id = false,$create_log=true)
{
    $ci = &get_instance();
    if ($ci->generic_model->insert($tbl, $data, $isBatchInsertion)) {
        $inserted_id=$ci->db->insert_id();
        if($isBatchInsertion==null && $create_log)
        {
            createDBLog($data,$tbl,null,$inserted_id,true);
        }
        if ($return_inserted_id) {
            return $inserted_id;
        } else {
            return $inserted_id;
        }
    } else
        return false;
}


function update_db($tbl,$id,$id_value,$data,$extraWhereArray=null)
{
    $ci= &get_instance();
    createDBLog($data,$tbl,$id,$id_value,$extraWhereArray);
    $result=$ci->generic_model->update($tbl,$id,$id_value,$data,$extraWhereArray);
    return $result;
}

function createDBLog($data, $tbl, $pk_field, $pk_value, $is_new = false,$is_delete=false)
{

    $ci= & get_instance();
    $session_user='';
    $log_type=debug_backtrace()[1]['function'];
    if($ci->session->userdata('username'))
        $session_user=$ci->session->userdata('username');
    else if($ci->session->userdata('std_id'))
    {
        $session_user= getSingle('students','cnic','id',$ci->session->userdata('std_id'));
    }
    if (!empty($session_user)) {
        if (strpos($tbl, 'adm_') === false)
            $tbl = $ci->db->dbprefix($tbl);
        $fields = custom_query("show columns from $tbl", true);

        if ($is_new)// Find PK
        {
            foreach ($fields as $v) {
                if ($v['Key'] == "PRI") {
                    $pk_field = $v['Field'];
                    break;
                }
            }
        }
        if (empty($pk_field))
            return;
        $old_row = generic_select_row($tbl, array($pk_field => $pk_value));
        $logDataHeader = array(
            'user_id' => $session_user,
            'db_table' => $tbl,
            'pk_field' => $pk_field,
            'pk_value' => $pk_value,
            'ip' => $ci->input->ip_address(),
            'time_string' => time(),
            'log_type' => $log_type

        );
        $logData = array();
        foreach ($data as $p => $q) {
            $old_value = '';

            if($is_delete==true)
            {
                $new_value='';

            }else
            {
                $new_value = $q;
            }
            $tempArray = array();
            foreach ($fields as $v) {

                if ($v['Field'] == $p) {
                    if ($is_new == false) {
                        foreach ($old_row as $k => $v1) {
                            if ($k == $p) {

                                $old_value = $v1;
                                break;
                            }

                        }
                    }

                    if ($new_value != $old_value) {
                        $tempArray = array(
                            'field' => $p,
                            'new_value' => $new_value,
                            'old_value' => $old_value,
                        );
                    }
                    break;

                }

            }

            if (!empty($tempArray))
                $logData[] = $tempArray;
        }

        if (!empty($logData)) {
            $id = insert_db('user_log_header', $logDataHeader,null,true,false);
            if ($id) {

                $final_log_data = array();
                foreach ($logData as $data) {
                    $final_log_data[] = $data + array('log_id' => $id);
                }

                insert_db('user_log_detail', $final_log_data, true);
            }
        }
    }

}
function delete_db($tbl,$key,$value)
{
    $c=  & get_instance();
    $rows=@generic_select($tbl,array($key=>$value));
    if(is_array($rows)||is_object($rows))
    {
        foreach ($rows as $row)
        {
            createDBLog($row,$tbl,$key,$value,false,true);
        }
    }
    return $c->generic_model->delete($tbl,$key,$value);
}
function get_user_session_by_key($key="std_id")
{
    $ci=& get_instance();
    return @$ci->session->userdata($key);
}
function validCnic($cnc)
{
    $c="";
    $cnc=trim($cnc);
    if(strpos($cnc,'-')>0)
        $c= $cnc;
    else
    {
        $c= substr_replace($cnc, '-', 5).substr_replace(substr($cnc,5,12), '-', -1,0);
    }
    if(preg_match("/^[0-9]{5}-[0-9]{7}-[0-9]{1}$/", $cnc)) {
        return $c;
    }else
    {
        return false;
    }
}
function validateNumberSMS($number)
{

    $number=str_replace('-','',$number);
    $number=str_replace(' ','',$number);
    $number=str_replace('+92','',$number);
    if($number[0]==0)
        $number=substr($number,1);
    $number='92'.$number;
    return $number;
}
function send_email_custom($from_email,$from_name,$to_email,$subject,$message)
{
    $c= & get_instance();
    $c->load->library('email');

    $c->email->from($from_email, $from_name);
    $c->email->to($to_email);
    $c->email->subject($subject);
    $c->email->message($message);
	$status=$c->email->send();
	return $status;
    /*if ( $c->email->send())
    {
        return 1;
    }else{
        return 0;
    }*/

}

function sendSMS($nmbr,$msg,$mask='THE IUB')
{
    $ci=& get_instance();
    $ci->load->model('telenor_api_model','sms_api');
    return $ci->sms_api->sendSmsMessage($msg,$nmbr,$mask);
}




function generate_anchor($class=null,$href=null,$title,$target=null)
{
    $c='';
    $h='';
    $tar='';
    if($class)
        $c='class="'.$class.'" ';
    if($href)
        $h='href="'.SITE_URL.$href.'" ';
    if($target)
        $tar='target="'.$target.'" ';

    return '<a '.$c.$h.$tar.'>'.$title.'</a>';
}
function convert_number_to_words($number) {

    $hyphen      = '-';
    $conjunction = ' and ';
    $separator   = ', ';
    $negative    = 'negative ';
    $decimal     = ' point ';
    $dictionary  = array(
        0                   => 'zero',
        1                   => 'one',
        2                   => 'two',
        3                   => 'three',
        4                   => 'four',
        5                   => 'five',
        6                   => 'six',
        7                   => 'seven',
        8                   => 'eight',
        9                   => 'nine',
        10                  => 'ten',
        11                  => 'eleven',
        12                  => 'twelve',
        13                  => 'thirteen',
        14                  => 'fourteen',
        15                  => 'fifteen',
        16                  => 'sixteen',
        17                  => 'seventeen',
        18                  => 'eighteen',
        19                  => 'nineteen',
        20                  => 'twenty',
        30                  => 'thirty',
        40                  => 'forty',
        50                  => 'fifty',
        60                  => 'sixty',
        70                  => 'seventy',
        80                  => 'eighty',
        90                  => 'ninety',
        100                 => 'hundred',
        1000                => 'thousand',
        1000000             => 'million',
        1000000000          => 'billion',
        1000000000000       => 'trillion',
        1000000000000000    => 'quadrillion',
        1000000000000000000 => 'quintillion'
    );

    if (!is_numeric($number)) {
        return false;
    }

    if (($number >= 0 && (int) $number < 0) || (int) $number < 0 - PHP_INT_MAX) {
        // overflow
        trigger_error(
            'convert_number_to_words only accepts numbers between -' . PHP_INT_MAX . ' and ' . PHP_INT_MAX,
            E_USER_WARNING
        );
        return false;
    }

    if ($number < 0) {
        return $negative . convert_number_to_words(abs($number));
    }

    $string = $fraction = null;

    if (strpos($number, '.') !== false) {
        list($number, $fraction) = explode('.', $number);
    }

    switch (true) {
        case $number < 21:
            $string = $dictionary[$number];
            break;
        case $number < 100:
            $tens   = ((int) ($number / 10)) * 10;
            $units  = $number % 10;
            $string = $dictionary[$tens];
            if ($units) {
                $string .= $hyphen . $dictionary[$units];
            }
            break;
        case $number < 1000:
            $hundreds  = $number / 100;
            $remainder = $number % 100;
            $string = $dictionary[$hundreds] . ' ' . $dictionary[100];
            if ($remainder) {
                $string .= $conjunction . convert_number_to_words($remainder);
            }
            break;
        default:
            $baseUnit = pow(1000, floor(log($number, 1000)));
            $numBaseUnits = (int) ($number / $baseUnit);
            $remainder = $number % $baseUnit;
            $string = convert_number_to_words($numBaseUnits) . ' ' . $dictionary[$baseUnit];
            if ($remainder) {
                $string .= $remainder < 100 ? $conjunction : $separator;
                $string .= convert_number_to_words($remainder);
            }
            break;
    }

    if (null !== $fraction && is_numeric($fraction)) {
        $string .= $decimal;
        $words = array();
        foreach (str_split((string) $fraction) as $number) {
            $words[] = $dictionary[$number];
        }
        $string .= implode(' ', $words);
    }
    return $string;
}
function convert_number_to_words_1($string)
{
    $s=convert_number_to_words($string);
    $s[0]=strtoupper($s[0]);
    return $s." only";
}
function custom_query($query,$result_as_array=null)
{
    $ci = & get_instance();
    return $ci->generic_model->custom_query($query,$result_as_array);
}

function generateCaptcha()
{

    $c=& get_instance();
    $config = array(
        'img_path'      => 'captcha_images/',
        'img_url'       => base_url().'captcha_images/',
        'img_width'     => 100,
        'img_height'    => 50,
        'word_length'   => 5,
        'font_size'     => 20,
        'pool'		=> '926831KFUEITMSCBA',
        'colors'        => array(
            'background' => array(100, 255, 50),
            'border' => array(255, 255, 255),
            'text' => array(0, 0, 0),
            'grid' => array(100, 200, 255)
        )
    );
    $captcha = create_captcha($config);

    // Unset previous captcha and store new captcha word
    $c->session->unset_userdata('captchaCode');
    @unlink($c->session->userdata('captchaImage'));
    $c->session->unset_userdata('captchaImage');
    $c->session->set_userdata('captchaCode',$captcha['word']);
    $c->session->set_userdata('captchaImage',$captcha['image']);

    // Display captcha image
    echo $captcha['image'];
}
function random_str($length, $keyspace = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ')
{
    $str = '';
    $charactersLength = strlen($keyspace);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $keyspace[rand(0, $charactersLength - 1)];
    }
    return $randomString;
    $max = mb_strlen($keyspace, '8bit') - 1;
    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }

}
function get_client_ip() {
    $ipaddress = '';
    if (getenv('HTTP_CLIENT_IP'))
        $ipaddress = getenv('HTTP_CLIENT_IP');
    else if(getenv('HTTP_X_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
    else if(getenv('HTTP_X_FORWARDED'))
        $ipaddress = getenv('HTTP_X_FORWARDED');
    else if(getenv('HTTP_FORWARDED_FOR'))
        $ipaddress = getenv('HTTP_FORWARDED_FOR');
    else if(getenv('HTTP_FORWARDED'))
        $ipaddress = getenv('HTTP_FORWARDED');
    else if(getenv('REMOTE_ADDR'))
        $ipaddress = getenv('REMOTE_ADDR');
    else
        $ipaddress = 'UNKNOWN';
    return $ipaddress;
}
if(!function_exists('confirm_admission'))
{
function confirm_admission($std_id)
	{
		$result = generic_select_row('std_registration_view',array('std_id'=>$std_id));
		if(is_object($result) || is_array($result)){
			return true;
		}
		else{
			return false;
		}
	}
}
if(!function_exists('sync_hostel_students'))
{
function sync_hostel_students($std_id)
	{
		$ci = & get_instance();
		$result = generic_select_row('std_registration_view',array('std_id'=>$std_id));
		$postData = array('name'=>$result->name,
                'cnic'=>$result->cnic,
                'regNo'=>$result->app_no,
                'father_name'=>$result->father_name,
                'domicile'=>$result->domicile,
                'present'=>$result->m_address,
                'permanent'=>$result->p_address,
                'email'=>$result->email,
                'phone'=>$result->phone,
                'blood'=>$result->blood_group,
                'gender'=>$result->gender,
                'religion'=>$result->religion
                );
		$ci->db = $ci->load->database('mis', TRUE);
		if(tbl_count("hst_students",array("cnic"=>$result->cnic))<=0)
        {
            insert_db("hst_students",$postData);
			$ci->db = $ci->load->database('default', TRUE);
			return true;
        }
		$ci->db = $ci->load->database('default', TRUE);
		return false;
		
	}
}
if(!function_exists('hostel_apply_expiry'))
{
	function hostel_apply_expiry()
	{
		$ci = & get_instance();
		$ci->db = $ci->load->database('mis', TRUE);
		$session = generic_select_row('hst_sessions',array('is_active'=>1,"expiry_date_new>="=>date('Y-m-d')));
		if(is_array($session) || is_object($session))
		{
			$ci->db = $ci->load->database('default', TRUE);
			return true;
		}
		$ci->db = $ci->load->database('default', TRUE);
		return false;
	}
}
if(!function_exists('already_hostel_apply'))
{
	function already_hostel_apply($std_id)
	{
		$ci = & get_instance();
		$std_record = generic_select_row('std_registration_view',array('std_id'=>$std_id));
		$ci->db = $ci->load->database('mis', TRUE);
		$session = generic_select_row('hst_sessions',array('is_active'=>1));
		if(is_array($session) || is_object($session))
		{
			if(tbl_count('hst_students_applied_view',array('cnic'=> $std_record->cnic,'session_id'=> $session->id))<=0)
			{
				return true;
			}
		}
		return false;
	}
}

