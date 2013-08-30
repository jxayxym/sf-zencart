<div id="navCatTabsWrapper">
<div id="navCatTabs">
<ul>
	<li class="navTabsHome"><a href="<?php echo zen_href_link(FILENAME_DEFAULT)?>"><img src="<?php echo DIR_WS_TEMPLATE_IMAGES.'home.gif' ?>" alt="home" /></a></li>
	<li class="navTabs"><a class="navTabsLink navDropDownFlag" href="<?php echo zen_href_link(FILENAME_BRANDS)?>">BRANDS</a>
	<div class="navTabsBrand dropdown">
		<table width="100%" cellspacing="10">
			<tr>
			<td width="50%" class="navBox">
			<a href="<?php echo zen_href_link(FILENAME_BRANDS)?>"><span class="c_teal fw_bold">A - Z&nbsp;&nbsp;&nbsp;BRAND INDEX</span><br><span>WATCH SHOP STOCKS <b><?php $total_brands = get_total_manufacturers(); echo $total_brands;?></b> BRANDS</span></a>
			</td>
			<td width="50%" class="navBox"><a href="<?php echo zen_href_link(FILENAME_PRODUCTS_ALL)?>"  style="display:block;"><span class="c_teal fw_bold">SHOW ALL WATCHES</span><br><span><b>23,913</b> DIFFERENT WATCHES IN STOCK</span></a></td>		
			</tr>
		</table>
		<div>
			<div class="column">
			<div class="c_teal fw_bold mb10">MOST POPULAR BRANDS</div>
			<ul>
			<?php 
			$most_popular = get_ext_manufacturers(0);
			while (!$most_popular->EOF){
				echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$most_popular->fields['manufacturers_id']).'">'.$most_popular->fields['manufacturers_name'].'</a></li>';
				$most_popular->MoveNext();
			}
			?>
			</ul>
			</div>
			<?php 
			$other_popular = get_ext_manufacturers(2);
			$i = 0;
			echo '<div class="column2 other_popular"><div class="c_teal fw_bold placeholder">OTHER BRANDS</div><ul>';
			while (!$other_popular->EOF){
				$i++;
				echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$other_popular->fields['manufacturers_id']).'">'.zen_trunc_string($other_popular->fields['manufacturers_name'],15).'</a></li>';
				if ($i%17==0)  echo '</ul></div><div class="column other_popular"><div class="placeholder"></div><ul>';
				$other_popular->MoveNext();
			}
			echo '<li class="view_all_brands"><a href="'.zen_href_link(FILENAME_BRANDS).'" class="c_teal">VIEW All BRANDS('.$total_brands.')</a></li>';
			echo '</ul></div>';
			?>
			<div class="column2 luxury_brands">
			<div class="c_teal fw_bold placeholder">LUXURY BRANDS</div>
			<?php 
			$luxury_brands = get_ext_manufacturers(5);
			echo '<ul>';
			while (!$luxury_brands->EOF){
				echo '<li><a href="'.zen_href_link(FILENAME_DEFAULT,'manufacturers_id='.$luxury_brands->fields['manufacturers_id']).'">'.$luxury_brands->fields['manufacturers_name'].'</a></li>';
				$luxury_brands->MoveNext();
			}
			echo '</ul>';
			?>			
			</div>
		</div>
	</div>
	</li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=1')?>">MEN'S WATCHES</a></li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=2')?>">LADIES' WATCHES</a></li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=5')?>">COUPLE WATCHES</a></li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_DEFAULT,'cPath=3')?>">UNISEX WATCHES</a></li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_SPECIALS)?>">SPECIAL</a></li>
	<li class="navTabs"><a class="navTabsLink" href="<?php echo zen_href_link(FILENAME_FEATURED_PRODUCTS)?>">FEATURED</a></li>
</ul>
</div>
<br class="clearBoth" />
</div>
