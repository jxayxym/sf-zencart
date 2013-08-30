<?php 
$status_array = array(
	0=>'Pending',
	10=>'Processing',
	50=>'Invalid',
	100=>'Transfered',
	1000=>'Received'
);
?>
<table width="100%" cellpadding="2" style="border:1px solid #000;">
	<caption><h2>Withdrawed List</h2></caption>
	<tr style="background:#555;color:#fff;height:20px;">
		<th>ID</th>
		<th>Withdrawed</th>
		<th>Apply Time</th>
		<th>Status</th>
	</tr>
	<?php 
	while (!$result_withdrawed->EOF){
		if ($result_withdrawed->fields['status']==0)
			$color = '#F0AB2D';
		elseif ($result_withdrawed->fields['status']==10)
			$color = '#F0AB2D';
		elseif ($result_withdrawed->fields['status']==50)
			$color = 'red';
		elseif ($result_withdrawed->fields['status']==100)
			$color = 'blue';
		elseif ($result_withdrawed->fields['status']==1000)	
			$color = 'green';
	?>
	<tr style="background:#F2F1EE;height:20px;">
		<td align="right">#<?php echo $result_withdrawed->fields['fanli_tixian_id']?></td>
		<td align="right"><?php echo $currencies->format($result_withdrawed->fields['jinqian']) ?></td>
		<td align="right"><?php echo $result_withdrawed->fields['add_time']?></td>
		<td style="text-align:center;color:<?php echo $color?>">
		<?php echo $status_array[$result_withdrawed->fields['status']]?>
		<?php 
		if ($result_withdrawed->fields['status']==100){
		?>
		<br /><input type="button" value="Confirm Receive!" onclick='if(window.confirm("Are you sure that you have received!")) document.location.href="<?php echo zen_href_link(FILENAME_ACCOUNT_WITHDRAWE_HISTORY,'action=confirm_receive&tixian_id='.$result_withdrawed->fields['fanli_tixian_id'])?>"'>
		<?php			
		}
		?>
		</td>
	</tr>
	<?php	
		$result_withdrawed->MoveNext();
	}
	?>
</table>
