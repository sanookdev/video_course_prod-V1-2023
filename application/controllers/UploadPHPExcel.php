<?php
defined('BASEPATH') or exit('No direct script access allowed');

class UploadPHPExcel extends CI_Controller
{
    public function __construct(){
		parent::__construct();
        if(isset($this->session->userdata['user_role'])){
			if($this->session->userdata['user_role'] == '1'){
                $this->load->library('excel');
                $this->load->model('User_model');
			}
		}else{
            echo "You don't have permission this page.";
            exit();
        }
    }
    public function import(){
        if(isset($_FILES["file"]["name"]))
        {
            $reader = PHPExcel_IOFactory::createReader('Excel2007');
            $reader->setReadDataOnly(true);
            $file = $_FILES["file"]["tmp_name"];
            $objPHPExcel = $reader->load($file);
            $objWorksheet = $objPHPExcel->getActiveSheet();
            $header=true;
            if ($header) {
                $highestRow = $objWorksheet->getHighestRow();
                $highestColumn = $objWorksheet->getHighestColumn();
                $headingsArray = $objWorksheet->rangeToArray('A1:' . $highestColumn . '1', null, true, true, true);
                $headingsArray = $headingsArray[1];
                $r = -1;
                $namedDataArray = array();
                for ($row = 2; $row <= $highestRow; ++$row) {
                    $dataRow = $objWorksheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, null, true, true, true);
                    if ((isset($dataRow[$row]['A'])) && ($dataRow[$row]['A'] > '')) {
                        ++$r;
                        foreach ($headingsArray as $columnKey => $columnHeading) {
                            if($columnKey == 'B'){
                                $namedDataArray[$r]['username'] = strtoupper($dataRow[$row][$columnKey]);
                            }else if($columnKey == 'C'){
                                $password = md5($dataRow[$row][$columnKey]);
                                $namedDataArray[$r]['password'] = $password;
                            }else if($columnKey == 'D'){
                                $namedDataArray[$r]['fname'] = $dataRow[$row][$columnKey];
                            }else if($columnKey == 'E'){
                                $namedDataArray[$r]['lname'] = $dataRow[$row][$columnKey];
                            }else if($columnKey == 'F'){
                                $namedDataArray[$r]['phone'] = (substr($dataRow[$row][$columnKey],0,1) != '0') ? '0'.$dataRow[$row][$columnKey] : $dataRow[$row][$columnKey];
                            }
                            $namedDataArray[$r]['updated_by'] = $this->session->userdata('username');
                        }
                    } 
                }
            } else {
                //excel sheet with no header
                $namedDataArray = $objWorksheet->toArray(null, true, true, true);
            }

            $checkDuplicate = array();
			$result = array();
            $list = $namedDataArray ;
			if(count($list) > 0){
				for($i = 0 ; $i < count($list) ; $i++){
					if($this->User_model->checkDuplicate($list[$i]['username'])){
						$checkDuplicate[] = $list[$i]['username'];
					}else{
						if($this->db->insert('tb_user',$list[$i])){
							$result['success']['user'][] = $list[$i]['username'];
						}

					}
				}
				$result['fails']['user'] = $checkDuplicate;
				$result['status'] = 1;
			}else{
				$result['status'] = 0;
			}
		    echo json_encode($result);
        } 
    }
    
}