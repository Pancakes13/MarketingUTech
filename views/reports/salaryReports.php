<?php
  require ("../../functions/php_globals.php");
  include ("../dashboard/dashboard.php");
?>
	<section class="content-header" style="background-color: #3a3c3f">
		<h1 style="color: white">
			<?php
				$salarySched = ((date('j',time()) <= 15)? 'First Half' : 'Second Half');
				$currentmonth = date('F',time());
				$currentyear = date('Y',time());
				echo "$salarySched of $currentmonth $currentyear"; 
			?>
		</h1>
	</section>
	<section class="content">
		<div class="recentSalary" style="height: 50%">
			<table class="table table-bordered table-hover table-condensed" id="table_wrapper">
	    		<thead>
	    			<tr>
	    				<th>Name</th>
	    				<th>No. of Days Worked</th>
	    				<th>No. of Paid Leaves</th>
	    				<th>No. of Unpaid Leaves</th>
	    			</tr>
	    		</thead>
	    		<tbody>
	    			<?php
	    				$qry = 'SELECT * FROM users';
	            		$result = mysqli_query($mysqli, $qry);
	            		$timestamp = time();
	            		$str = date('w', mktime(0, 0, 0, date('m', $timestamp), 1, date('Y', $timestamp)));
	            		if ($result) {
	            			while ($row = mysqli_fetch_assoc($result)) {
	                            $qery = "SELECT `totalHours` , `date`
	                                    FROM `timetable`
	                                    WHERE user_id = ".$row['id']."";
	                            $res = mysqli_query($mysqli, $qery);
	                            if ($res) {
	                                $days = 0;
	                                $cnt=0;
	                                $upper = 15;
                                    $lower = 1;
                                    if($salarySched == 'Second Half'){
                                    	$upper = date("t",time());
                                    	$lower = 16;
                                    }
	                                while ($daysWorked = mysqli_fetch_assoc($res)) {
	                                    $mydate = $daysWorked['date'];
	                                    $date = date("j",strtotime($mydate));
	                                    $dayofweek = date("w",strtotime($mydate));
	                                    $month = date("F",strtotime($mydate));
	                                    $year = date("Y",strtotime($mydate));
	                                    
	                                    //  month of work is compared to the actual month
	                                    //  year of work is compared to the actual year
	                                    if ($month==$currentmonth && $year == $currentyear && ($date<=$upper && $date>=$lower)) {
	                                        $minHours = 0;
	                                        if ($row['workStatus'] == 'Regular') {
	                                            $minHours = 8;
	                                        }
	                                        if ($daysWorked['totalHours']>$minHours && ($dayofweek!=0 || $dayofweek!=6)) {
	                                            $days++;
	                                        }
	                                    	$cnt++;
	                                    }
	                                }
	                            }
	            				echo "
	            					<tr>
	            						<td>".$row['firstName']." ".$row['lastName']."</td>
	            						<td>".$days."</td>
	            						<td></td>
	            						<td></td>
	            					</tr>
	            				";
	            			}
	            		}
	    			?>
	    		</tbody>
	    	</table>
		</div>
		<div class="salaryLog">
			<?php
				$qery = "SELECT * FROM `timetable`";
                $res = mysqli_query($mysqli, $qery);
                if ($res) {
                    while ($paymentrow = mysqli_fetch_assoc($res)) {

                    }
                }
	        ?>
		</div>
	</section>
</div>