<div class="centerColumn" id="accountCouponsDefault">
<h1 id="accountCouponsDefaultHeading"><?php echo HEADING_TITLE; ?></h1>

<div class="multiLabelMenu">
	<div class="multiLabelMenu-nav">
		<div class="multiLabelMenu-nav-tab tab_selected" rel="table_coupons">Coupons</div>
		<div class="multiLabelMenu-nav-tab" rel="table_gift_certificate">Gift Certificate</div>
	</div>
	<div id="table_coupons" class="multiLabelMenu-concent content_selected">
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="ress">
		<tr class="ress_tit">
		    <th width="178" height="33" align="center" valign="middle">Coupon Code </th>
		    <th width="128" align="center" valign="middle">FaceValue </th>
		    <th width="141" align="center" valign="middle">Start Date </th>
		    <th width="121" align="center" valign="middle">Expire Date </th>
		    <th width="122" align="center" valign="middle">Status</th>
		</tr>
		<?php 
		while (!$customer_coupons->EOF){
		?>
		<tr>
			<td align="center"><?php echo $customer_coupons->fields['coupon_code'] ?></td>
			<td align="center">
			<?php 
			if (in_array($customer_coupons->fields['coupon_type'],array('S','O','E'))){
				echo 'free shipping<br />';
			}
			if ($customer_coupons->fields['coupon_amount']>0){
				echo sprintf('%01.2f',$customer_coupons->fields['coupon_amount']);
				if ($customer_coupons->fields['coupon_type']=='P')
					echo '%';
			}
			 ?>
			</td>
			<td align="center"><?php echo date('Y-m-d',strtotime($customer_coupons->fields['coupon_start_date'])) ?></td>
			<td align="center"><?php echo date('Y-m-d',strtotime($customer_coupons->fields['coupon_expire_date'])) ?></td>
			<td align="center"><?php echo sf_valid_coupons($customer_coupons->fields['coupon_id'],$_SESSION['customer_id'])?'valid':'invalid'; ?></td>
		</tr>
		<?php	
			$customer_coupons->MoveNext();
		}
		?>
	</table>
	</div>
	<div id="table_gift_certificate" class="multiLabelMenu-concent">
	<h2>Your Gift Certificate balance is: <?php echo sf_get_customer_gv_blance($_SESSION['customer_id'])?></h2>
	<table width="100%" border="0" cellpadding="0" cellspacing="0" class="ress">
		<tr class="ress_tit">
		    <th width="178" height="33" align="center" valign="middle">Gift Certificate Code </th>
		    <th width="128" align="center" valign="middle">FaceValue </th>
		    <th width="122" align="center" valign="middle">Status</th>
		</tr>
		<?php 
		while (!$customer_gift_certificate->EOF){
		?>
		<tr>
			<td align="center"><?php echo $customer_gift_certificate->fields['coupon_code'] ?></td>
			<td align="center">
			<?php 
			if ($customer_gift_certificate->fields['coupon_amount']>0){
				echo sprintf('%01.2f',$customer_coupons->fields['coupon_amount']);
				if ($customer_gift_certificate->fields['coupon_type']=='P')
					echo '%';
			}
			 ?>
			</td>
			<td align="center"><?php echo $customer_gift_certificate->fields['coupon_active']=='Y'?'valid':'invalid'; ?></td>
		</tr>
		<?php	
			$customer_gift_certificate->MoveNext();
		}
		?>
	</table>
	<p><a href="<?php echo zen_href_link(FILENAME_GV_SEND)?>">send a gift certificate</a></p>
	</div>
</div>
</div>