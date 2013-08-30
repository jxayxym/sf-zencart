<?php
$manufacturer_query = "select m.manufacturers_id, m.manufacturers_name
						from " . TABLE_MANUFACTURERS . " m
						order by manufacturers_name";


$manufacturer_list = $db->Execute($manufacturer_query);
  $manufacturer_array = array(
	'A'=>array(),
	'B'=>array(),
	'C'=>array(),
	'D'=>array(),
	'E'=>array(),
	'F'=>array(),
	'G'=>array(),
	'H'=>array(),
	'I'=>array(),
	'J'=>array(),
	'K'=>array(),
	'L'=>array(),
	'M'=>array(),
	'N'=>array(),
	'O'=>array(),
	'P'=>array(),
	'Q'=>array(),
	'R'=>array(),
	'S'=>array(),
	'T'=>array(),
	'U'=>array(),
	'V'=>array(),
	'W'=>array(),
	'X'=>array(),
	'Y'=>array(),
	'Z'=>array(),
  );
  if ($manufacturer_list->RecordCount()>0) {
    while (!$manufacturer_list->EOF) {
		$manufacturer_tag = strtoupper(substr(trim($manufacturer_list->fields['manufacturers_name']),0,1));
	  	     
	  $manufacturer_name = $manufacturer_list->fields['manufacturers_name'];
      $manufacturer_array[$manufacturer_tag][] = array('id' => $manufacturer_list->fields['manufacturers_id'],
                                       'text' => $manufacturer_name);

      $manufacturer_list->MoveNext();
    }
  }