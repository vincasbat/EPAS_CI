<?php
class Mokejimai extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Mokejimai_Model');
	$this->load->library('session');
	$this->load->library('pagination');
	}
	
	public function index()
	{
	
	$limit_per_page = 50;
        $start_index = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
        $total_records = $this->Mokejimai_Model->get_total();
        
        $result['data']=$this->Mokejimai_Model->displayrecords($limit_per_page, $start_index);
	$result['total']=$this->Mokejimai_Model->get_total();
	
	$config['base_url'] = base_url() . 'index.php/mokejimai/index';
            $config['total_rows'] = $total_records;
            $config['per_page'] = $limit_per_page;
            $config["uri_segment"] = 3;
             $config['num_links'] = 3;
             $config['full_tag_open'] = '<div class="pagination">';
		$config['full_tag_close'] = '</div>';
             $config['first_link'] = '<<';
	$config['last_link'] = '>>';
	$config['next_link'] = '>&nbsp;';
	$config['prev_link'] = '&nbsp;<';
	$config['first_tag_open'] = '<span class="firstlink">';
	$config['first_tag_close'] = '</span>';
	  
	$config['last_tag_open'] = '<span class="lastlink">';
	$config['last_tag_close'] = '</span>';
	  
	$config['next_tag_open'] = '<span class="nextlink">';
	$config['next_tag_close'] = '</span>';
	  
	$config['prev_tag_open'] = '<span class="prevlink">';
	$config['prev_tag_close'] = '</span>';
	
	$config['cur_tag_open'] = '<span class="curlink">';
$config['cur_tag_close'] = '</span>';

$config['num_tag_open'] = '<span class="numlink">';
$config['num_tag_close'] = '</span>';


			     
             
             
            $this->pagination->initialize($config);
             
           
            $result["links"] = $this->pagination->create_links();
	
	
	$this->load->view('mokejimai',$result);
	}
	
	
	
	
	
	}
	
	
