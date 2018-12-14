<?php
	$config=	[
				
					 
					'userregistration'	=>	[
												[
												'field'	=>	'user_fname',
												'label'	=>	'First Name',
												'rules'	=>	'trim|required|alpha|min_length[3]'
						
												],
												[
													'field'	=>	'user_lname',
													'label'	=>	'Last name',
													'rules'	=>	'trim|required|alpha|min_length[3]'
							
												],
												[
													'field'	=>	'user_email',
													'label'	=>	'Email',
													'rules'	=>	'trim|valid_email|required|is_unique[users.user_email]'							
												],
												[
													'field'	=>	'user_phone',
													'label'	=>	'Phone',
													'rules'	=>	'trim|required|is_unique[users.user_phone]'							
												],
												[
													'field'	=>	'user_bank_name',
													'label'	=>	'Bank Name',
													'rules'	=>	'trim|required|alpha_numeric_spaces'							
												],
												[
													'field'	=>	'user_ac_name',
													'label'	=>	'Account Name',
													'rules'	=>	'trim|required'							
												],
												[
													'field'	=>	'user_ac_number',
													'label'	=>	'Account Number',
													'rules'	=>	'trim|required|alpha_numeric'							
												],
												[
													'field'	=>	'user_uname',
													'label'	=>	'Username',
													'rules'	=>	'trim|required|alpha_numeric|min_length[5]|is_unique[users.user_uname]'							
												],								 
												[
													'field'	=>	'pwd',
													'label'	=>	'Password',
													'rules'	=>	'required|min_length[8]|max_length[14]|alpha_dash'							
												],
												[
													'field'	=>	'cpwd',
													'label'	=>	'Confirm Password',
													'rules'	=>	'required|min_length[8]|max_length[14]|alpha_dash|matches[pwd]'							
												],
												[
													'field'	=>	'plan',
													'label'	=>	'Plan',
													'rules'	=>	'required'							
												]
											],
					 
						'user_login'		=>	[
													[
														'field'	=>	'user_uname',
														'label'	=>	'Username',
														'rules'	=>	'trim|required'
													],
													[
														'field'	=>	'pwd',
														'label'	=>	'Password',
														'rules'	=>	'required|min_length[8]|max_length[14]|alpha_dash'	
													]
												],
						'updateprofile'		=>	[
													[
														'field'	=>	'user_fname',
														'label'	=>	'First Name',
														'rules'	=>	'trim|required|alpha|min_length[3]'
							
													],
													[
														'field'	=>	'user_lname',
														'label'	=>	'Last name',
														'rules'	=>	'trim|required|alpha|min_length[3]'
								
													],
													[
														'field'	=>	'user_email',
														'label'	=>	'Email',
														'rules'	=>	'trim|valid_email|required'							
													],
													[
														'field'	=>	'user_phone',
														'label'	=>	'Phone',
														'rules'	=>	'trim|required'							
													]
												 
												],
							'adminregistration'	=>	[
												[
												'field'	=>	'user_fname',
												'label'	=>	'First Name',
												'rules'	=>	'trim|required|alpha|min_length[3]'
						
												],
												[
													'field'	=>	'user_lname',
													'label'	=>	'Last name',
													'rules'	=>	'trim|required|alpha|min_length[3]'
							
												],
												[
													'field'	=>	'user_email',
													'label'	=>	'Email',
													'rules'	=>	'trim|valid_email|required'							
												],
												[
													'field'	=>	'user_phone',
													'label'	=>	'Phone',
													'rules'	=>	'trim|required'							
												],
												[
													'field'	=>	'user_bank_name',
													'label'	=>	'Bank Name',
													'rules'	=>	'trim|required|alpha_numeric_spaces'							
												],
												[
													'field'	=>	'user_ac_name',
													'label'	=>	'Account Name',
													'rules'	=>	'trim|required'							
												],
												[
													'field'	=>	'user_ac_number',
													'label'	=>	'Account Number',
													'rules'	=>	'trim|required|alpha_numeric'							
												],
												[
													'field'	=>	'user_uname',
													'label'	=>	'Username',
													'rules'	=>	'trim|required|alpha_numeric|min_length[5]|is_unique[users.user_uname]'							
												],								 
												[
													'field'	=>	'pwd',
													'label'	=>	'Password',
													'rules'	=>	'required|min_length[8]|max_length[14]|alpha_dash'							
												],
												[
													'field'	=>	'cpwd',
													'label'	=>	'Confirm Password',
													'rules'	=>	'required|min_length[8]|max_length[14]|alpha_dash|matches[pwd]'							
												],
												[
													'field'	=>	'plan',
													'label'	=>	'Plan',
													'rules'	=>	'required'							
												]
											],
					 
				
				]


?>