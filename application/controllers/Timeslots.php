<?php
	class Timeslots extends MY_Controller{
		public function __construct(){
			parent::__construct();
			$this->load->model('select');
			$this->load->model('home');
			date_default_timezone_set('Asia/kolkata');
		}
		public function showtimeslots(){
			$post 	=	$this->input->post();
			$this->load->model('select');
			$timestamp = strtotime($post['date']);
			$day		= strtolower(date('D', $timestamp));
			$array 		=	array('user_id'	=>	$post['id']);
			$time 		=	$this->select->get_user_time($array);
			$array	=	array('vacation_doctor_id'	=>		$post['id']);
			$vacations	=	$this->select->get_some_vacations($array);
			$leave		=	array();
			if(count($vacations))
			{
				foreach ($vacations as $vac) {
					$leave[]	=	$vac['vacation_date'];
				}
			}
			
			if($time[$day]==0)
			{
				echo "<br><br><div class='alert alert-warning'>Doctor is not available on this date</div>";
			}
			else if(in_array($post['date'],$leave)){
				echo "<br><br><div class='alert alert-danger'>Doctor is not available on this date</div>";
			}
			else{
				//get appointments for that day for the same doctor
				$array	 =	array(
									'ap_date'	=>	$post['date'],
									'ap_status'	=>	1,
									'ap_doctor_id'=>	$post['id']
								);
				$this->load->model('home');
				$ap 	=	$this->home->get_all_row("appointment",$array,"ap_time");
				if(count($ap))
				{
					foreach ($ap as $x)
					{
						$preap[]	=	$x['ap_time'];
					}
				}
				else{
					$preap	=	array();
				}
				//print_r($preap);
				$array	=	array(
								'id'			=>	$post['id'],
								'is_active'		=>	1,
								); 
				$doc		=	$this->select->get_one_user($array);
				$mstart =	$time[$day."_morning_start"];
				$mend	=	$time[$day."_morning_end"];
				$estart	=	$time[$day."_evening_start"];
				$eend	=	$time[$day."_evening_end"];
				 
				$mstartsec =  $this->timetosec($mstart);
				//echo $mstartsec;
				$mendsec   =  $this->timetosec($mend);
				$estartsec =  $this->timetosec($estart);
				$eendsec   =  $this->timetosec($eend);
				$duration  =  $doc['user_time']*60;
				$today 	   =  date("Y-m-d");
				if($today == $post['date'])
				{
					$now 		=	explode(":",date("H:i:s"));
					$lastlimit 		= ($now[0]*3600+$now[1]*60+$now[2]+3600)*6;
				}
				
				//echo $lastlimit;
				?>
					<?php
						$today 		=	date('Y-m-d');
						$time 	=	date("H:i:s");
						$time 	=	explode(":",$time);
						$time 	=   ($time[0]*3600)+($time[1]*60)+($time[2]);
						$maxlimit =	$time + (2*3600);
						if($mstart != '00:00:00' && $mend !='00:00:00')
						{							
					?>
				 	<div class="col-sm-12">
				 		<center>
				 			<h3 class="text-center">Morning Shift</h3>
						 <?php
						 	$morningshiftstartsec = $mstartsec;
							while($mstartsec<$mendsec)
							{
								$class1 = "";
								if($today ==	$post['date'])
								{
									if($morningshiftstartsec<=$maxlimit)
									{
										$class1=		" hidden ";
									}
								}
								$starttime = $this->sectotime($mstartsec);
								$endtime = $this->sectotime(($mstartsec+$duration));
								
								$aptime 	=	$starttime." to ".$endtime;
								$disabled= '';
								$classshow = "btn-info";
								if(in_array($aptime,$preap))
								{
									$classshow = "btn disabled red";
									$disabled  = "disabled";
								}
									?>									  
									<button class="btn <?= $classshow;?>  <?= $class1; ?> " <?= $disabled; ?>  <?php if($disabled ==''){?> onClick="dateselected('<?= $mstartsec; ?>','<?= $aptime; ?>','M');" <?php } ?>  id="<?= $mstartsec; ?>" data-id="<?= $mstartsec ;?>" style="margin:5px;" >						
										<?= $aptime; ?>
									</button>
									<?php
								
								$mstartsec = $mstartsec+$duration;
								
							}
						?>
						</center>
					</div>
					<?php
						}
						if($estart != '00:00:00' && $eend !='00:00:00')
							{							
					?>
					<div class="col-sm-12">
						<center>
						<h3 class="text-center">Evening Shift</h3>
						 <?php
						 	$eveningshiftstartsec = $estartsec;
							while($estartsec<$eendsec)
							{
								$class1 = "";
								if($today ==	$post['date'])
								{

									if($eveningshiftstartsec<=$maxlimit)
									{
										$class1=		" hidden ";
									}									 
								}
								$starttime = $this->sectotime($estartsec);
								$endtime = $this->sectotime(($estartsec+$duration));
								$aptime 	=	$starttime." to ".$endtime;
								$disabled= '';
								$classshow = "btn-info";
								if(in_array($aptime,$preap))
								{
									$classshow = "btn  disabled red";
									$disabled  = "disabled";
								}
								?>
								  
								<button class="btn <?= $classshow; ?> <?= $class1; ?>" <?= $disabled; ?> <?php if($disabled==''){?> onClick="dateselected('<?= $estartsec; ?>','<?= $aptime; ?>','E');" <?php }?>  id="<?= $estartsec; ?>" data-id="<?= $estartsec ;?>" style="margin:5px;" >						
									<?= $aptime; ?>
								</button>
								<?php
								
								 $estartsec = $estartsec+$duration;							
							}
							?>
						</center>
						 </div>
				<?php		 
				}			
			}
		}
	}
?>