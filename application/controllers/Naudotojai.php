<?php
class Naudotojai extends CI_Controller 
{
	public function __construct()
	{
	parent::__construct();
	
	$this->load->helper(array('form'));
	$this->load->library(array('form_validation'));
	$this->load->database();
	$this->load->helper('url');
	$this->load->model('Naudotojai_Model');
	$this->load->library('session');
	}
	
	
	
	public function pakeistiemail()
	{
	if ( isset($_POST['senas']) && isset($_POST['naujas'])    )
		{
		
		$this->Naudotojai_Model->pakeistiemail($_POST['senas'], $_POST['naujas']);
		  //flash:
		  $this->session->set_flashdata("emailpakeistas", "Dabar el. p. yra {$_POST['naujas']}");
		  redirect('naudotojai/pakeistiemail');
		}
		else
		{
		    $this->load->view('pakeistiemail');
		}
	

	}

	public function n_naudotojas()
	{
	
	
	$this->form_validation->set_rules('naud_vardas','vardas','trim|required|min_length[2]|max_length[30]', 
		array( 'required' => 'Neįvestas %s!' ,
			'min_length' => 'Vardą turi sudaryti ne mažiau kaip dvi raidės!' ,
			'max_length' => 'Vardą turi sudaryti ne daugiau kaip 30 raidžių!' 
		     )   
		); 
	$this->form_validation->set_rules('naud_pavarde','pavardė','trim|required|min_length[2]|max_length[15]', 
		array( 'required' => 'Neįvesta %s!' ,
			'min_length' => 'Pavardę turi sudaryti ne mažiau kaip dvi raidės!' ,
			'max_length' => 'Pavardę turi sudaryti ne daugiau kaip 15 raidžių!' 
		     )   
		); 
		
		$this->form_validation->set_rules('naud_email','el. paštas','valid_email|required|is_unique[naudotojai.naud_email]', 
		array( 'required' => 'Neįvestas %s!' ,
			'valid_email' => 'Turi būti teisingas el. pašto adresas!' ,
			'is_unique' => 'Toks adresas jau yra!' 
		     )   
		); 
		
		
	
	$this->form_validation->set_rules('naud_passw','slaptažodis','trim|required|min_length[6]|max_length[15]', 
		array( 'required' => 'Neįvestas %s!' ,
			'min_length' => 'Slaptažodį turi sudaryti ne mažiau kaip 6 ženklai!' ,
			'max_length' => 'Slaptažodį turi sudaryti ne daugiau kaip 15 ženklų!' 
			     )   
		); 
		
		
		
		$this->form_validation->set_rules('conf_passw','pakartojimas','required|matches[naud_passw]', 
		array( 'required' => 'Neįvestas slaptažodžio %s!' ,
			'matches' => 'Neteisingai pakartotas slaptažodis!' 
		     )   
		); 
		
		
		
		$this->form_validation->set_rules('naud_telef','telefonas','required|regex_match[/^[0-9)( -+]{5,20}$/]', 
		array( 'required' => 'Neįvestas %s!' ,
			'regex_match' => 'Neteisingas telefono numeris!' 
			)   
		); 
	
	$this->form_validation->set_rules('naud_adr','adresas','required|regex_match[/^(.+){5,100}$/]', 
		array( 'required' => 'Neįvestas %s!' ,
			'regex_match' => 'Neteisingas adresas!' 
			)   
		); 
	
	$this->form_validation->set_rules('naud_org','organizacija','required|regex_match[/^(.+){1,100}$/]', 
		array( 'required' => 'Neįvesta %s!' ,
			'regex_match' => 'Neteisinga organizacija!' 
			)   
		); 
		
		$this->form_validation->set_rules('naud_grupe','grupė','required|min_length[2]', 
		array( 'required' => 'Neįvesta %s!' ,
		'min_length'  =>  "Pasirinkitę grupę!"
			)   
		);
	
	
	if ($this->form_validation->run() == FALSE) 
		{
			$this->load->view('naujas_naudotojas');
		} 
		else 
		{
	
	
		if($this->input->post('save'))
		{
		
		$this->load->view('naujas_naudotojas');
		$naud_vardas=$this->input->post('naud_vardas');
		$naud_pavarde=$this->input->post('naud_pavarde');
		$naud_email=$this->input->post('naud_email');
		$naud_passw=$this->input->post('naud_passw');
		$naud_telef=$this->input->post('naud_telef');
		$naud_adr=$this->input->post('naud_adr');
		$naud_org=$this->input->post('naud_org');
		$naud_grupe=$this->input->post('naud_grupe');
		
		
		$this->Naudotojai_Model->save_naudotojas($naud_vardas, $naud_pavarde, $naud_passw, $naud_email, $naud_telef, $naud_adr, $naud_org, $naud_grupe);	
		// set flash data
    		$this->session->set_flashdata('msg', 'Naudotojas įrašytas');
    		
    		
    		//send email:  https://codeigniter.com/userguide3/libraries/email.html
    		/*
    		$config['protocol'] = 'sendmail';
            $config['mailpath'] = '/usr/sbin/sendmail';
            $config['charset'] = 'iso-8859-1';
            $config['wordwrap'] = TRUE; 
            $this->email->initialize($config);

            $this->email->from('kunal.saxena.kunal@gmail.com', 'Your Name');
            $this->email->to('kunal.saxena.kunal@gmail.com'); 
            $this->email->subject('Email Test');
            $this->email->message('Testing the email class.');  

            $this->email->send();

            echo $this->email->print_debugger();
    		*/
    		
    		redirect("naudotojai");  
		}
	}
	
	}// end function
	
	public function index()
	{
	$result['data']=$this->Naudotojai_Model->displayrecords();
	$this->load->view('naudotojai',$result);
	}
	
	
	public function delete()
	{
	$id=$this->input->get('naud_email');
	$this->Naudotojai_Model->deleterecord($id);
	
	$this->session->set_flashdata('del', 'Naudotojas ištrintas');
	
	redirect("naudotojai");                
	}
	
	
	public function updatedata()
	{

	$n_email=$this->input->get('n_email');
	
	//https://codeigniter4.github.io/userguide/libraries/validation.html#available-rules
	
	$this->form_validation->set_rules('naud_vardas','vardas','trim|required|min_length[2]|max_length[30]', 
		array( 'required' => 'Neįvestas %s!' ,
			'min_length' => 'Vardą turi sudaryti ne mažiau kaip dvi raidės!' ,
			'max_length' => 'Vardą turi sudaryti ne daugiau kaip 30 raidžių!' 
		     )   
		); 
	$this->form_validation->set_rules('naud_pavarde','pavardė','trim|required|min_length[2]|max_length[15]', 
		array( 'required' => 'Neįvesta %s!' ,
			'min_length' => 'Pavardę turi sudaryti ne mažiau kaip dvi raidės!' ,
			'max_length' => 'Pavardę turi sudaryti ne daugiau kaip 15 raidžių!' 
		     )   
		); 
	
	$this->form_validation->set_rules('naud_passw','slaptažodis','trim|required|min_length[6]|max_length[15]', 
		array( 'required' => 'Neįvestas %s!' ,
			'min_length' => 'Slaptažodį turi sudaryti ne mažiau kaip 6 ženklai!' ,
			'max_length' => 'Slaptažodį turi sudaryti ne daugiau kaip 15 ženklų!' 
			     )   
		); 
		
		$this->form_validation->set_rules('naud_telef','telefonas','required|regex_match[/^[0-9)( -+]{5,20}$/]', 
		array( 'required' => 'Neįvestas %s!' ,
			'regex_match' => 'Neteisingas telefono numeris!' 
			)   
		); 
	
	$this->form_validation->set_rules('naud_adr','adresas','required|regex_match[/^(.+){5,100}$/]', 
		array( 'required' => 'Neįvestas %s!' ,
			'regex_match' => 'Neteisingas adresas!' 
			)   
		); 
	
	$this->form_validation->set_rules('naud_org','organizacija','required|regex_match[/^(.+){1,100}$/]', 
		array( 'required' => 'Neįvesta %s!' ,
			'regex_match' => 'Neteisinga organizacija!' 
			)   
		); 
	
	
	$result['data']=$this->Naudotojai_Model->displayrecordById($n_email);
	$result['gr']=$this->Naudotojai_Model->get_grupes();
	
	 if ($this->form_validation->run() == FALSE) 
		{
			$this->load->view('naudotojas',$result);
		} 
		else 
		{
	
		if($this->input->post('update'))
		{
		
		
		
		
		$naud_vardas=$this->input->post('naud_vardas');
		$naud_pavarde=$this->input->post('naud_pavarde');
		$naud_passw=$this->input->post('naud_passw');
		$naud_telef=$this->input->post('naud_telef');
		$naud_addr=$this->input->post('naud_adr');
		$naud_org=$this->input->post('naud_org');
		$naud_grupe=$this->input->post('naud_grupe');
		$grupe=$this->input->post('grupe');
		
		$this->Naudotojai_Model->updaterecord($naud_vardas,$naud_pavarde,$naud_passw,$naud_telef,$naud_addr,$naud_org,$naud_grupe,$grupe, $n_email);
		redirect("naudotojai");
		}
		}//else
	}
	
}




?>

