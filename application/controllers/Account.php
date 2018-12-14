<?php
	class Account extends MY_Controller{
		public function verifydocemail(){
			$this->load->helper('form');
			$array['id'] 		=	$this->uri->segment(3);
			$array['user_code']	=	$this->uri->segment(4);
			/*print_r($array);*/
			$this->load->model('select');
			if($id 	=	$this->select->checkuser($array))
			{
				$_SESSION['new_doc_id']		=	$id;
				$this->load->view('home/verifydocemail');
			}
			else{
				return redirect(base_url('Error404'));
			}
		}
		public function resetdocpassword(){
			if(!isset($_SESSION['new_doc_id']))
			{
				return redirect(base_url('Error404'));
			}
			$post 	=	$this->input->post();			
			$this->load->library('form_validation');
            $this->form_validation->set_rules('user_pwd', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('user_pwd2', 'Confirm Password', 'matches[user_pwd]');
            
            if ($this->form_validation->run() == FALSE)
            {
                    $this->load->view('home/verifydocemail');
            }
            else{
            	$post['updated_at']	=	date('Y-m-d H:i:S');
            	$post['user_pwd']	=	md5($post['user_pwd']);
            	$post['user_code']	=	'';
            	unset($post['user_pwd2']);
            	$this->load->model('update');
            	if($this->update->update_table("users",'id',$_SESSION['new_doc_id'],$post))
            	{
            		$this->session->set_flashdata('logmsg','<p>Email has been verified. Please login to access your account.</p>');
            		unset($_SESSION['new_doc_id']);
            		return redirect(base_url('Login'));
            	}
            	else{
            		$this->seession->set_flashdata('verifymsg','<p>We are facing some technical issues. Please try after some time.</p>');
            		return redirect(base_url('Account/verifydocemail'));
            	}
            	//print_r($post);
            }
		}
	}
?>