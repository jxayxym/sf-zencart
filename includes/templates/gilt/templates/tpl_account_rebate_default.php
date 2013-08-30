<?php 
if (empty($rebate_point_id)){
	echo '<p style="font-size:20px;text-align:center;">Sorry!You have\'t any Return-Money History!</p>';
}else{
?>
<table width="100%" cellpadding="2" style="border:1px solid #000;">
	<caption><h2>Rebate Detail</h2></caption>
	<caption>
	<div style="text-align: left;">
	<label style="font-weight:bold;">Level:</label><?php echo $return_money_customer->level['dengji_mingcheng']?> 
	<label style="font-weight:bold;margin-left:20px;">Rebate Points Num:</label><?php echo $return_money_customer->rebate_points ?> 
	</div>
	<div style="text-align: left;">
	<label style="font-weight:bold;">Return Money:</label><?php echo $currencies->format($return_money_customer->getTotalRebate()) ?>
	<label style="font-weight:bold;margin-left:20px;">Withdrawed:</label><?php echo $currencies->format($return_money_customer->getTotalWithdrawed())?>
	<label style="font-weight:bold;margin-left:20px;">Account Balance</label><?php echo $currencies->format($return_money_customer->getTotalRebate()-$return_money_customer->getTotalWithdrawed())?>
	</div>
	</caption>
	<tr>
		<th style="background:#555;color:#fff;height:20px;">Point\Date</th>
		<?php
		if (preg_match('/[0-9]{4}-[0-9]{2}-[0-9]{2}/', $_GET['fanli_date']))
			$date = $_GET['fanli_date'];
		else 
			$date = date('Y-m-d');
		$stamp_time = strtotime($date);	
		for ($i=0;$i<9;$i++){
			$fanli_date = date('n/d/Y',$stamp_time);
		?>
			<th style="background:#555;color:#fff;"><?php echo $fanli_date?></th>
		<?php
			$stamp_time = $stamp_time-24*60*60;
		}	
		?>
	</tr>
	<?php 
	$total = array();
	foreach ($rebate_point_id as $entry){
	?>
	<tr style="background:#F2F1EE;color:#000;height:20px;">
		<th style="background:#555;color:#fff;height:20px;">
		ID#<?php echo $entry['fanlidian_id'] ?><br />
		</th>
		<?php 
		$stamp_time = strtotime($date);
		for ($i=0;$i<9;$i++){
			$fanli_date = date('Y-m-d',$stamp_time);
			if (!isset($total[$fanli_date])) $total[$fanli_date] = 0; 
			if ( $stamp_time <= strtotime($entry['add_date']) ){//返利开始时间前
				echo '<td align="center">--</td>';
			} else {
				if ($stamp_time > strtotime($entry['fanli_end'])){
					echo '<td align="center">Completed!</td>';
				}elseif ((isset($record_fanli[$fanli_date][$entry['fanlidian_id']]))){
					$total[$fanli_date] += $record_fanli[$fanli_date][$entry['fanlidian_id']];
					echo '<td align="right">'.$currencies->format($record_fanli[$fanli_date][$entry['fanlidian_id']]).'</td>';
				}else{
					echo '<td align="center">?</td>';
				}	
			}	
			$stamp_time = $stamp_time-24*60*60;
		}	
		?>		
	</tr>	
	<?php	
	}
	?>
	<tr style="background:#555;color:#fff;height:20px;">
		<th>Total</th>
		<?php 
		$stamp_time = strtotime($date);
		for ($i=0;$i<9;$i++){
			$fanli_date = date('Y-m-d',$stamp_time);
			echo '<td align="right">'.$currencies->format($total[$fanli_date]).'</td>';
			$stamp_time = $stamp_time-24*60*60;
		}	
		?>	
	</tr>
</table>
<div style="font-size:20px;">
<?php 
$stamp_time = strtotime($date);
?>
<span><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_REBATE,'fanli_date='.date('Y-m-d',$stamp_time+9*24*60*60))?>">Next</a></span>
<span><a href="<?php echo zen_href_link(FILENAME_ACCOUNT_REBATE,'fanli_date='.date('Y-m-d',$stamp_time-9*24*60*60))?>">Back</a></span>
</div>	
<?php 
}
?>
