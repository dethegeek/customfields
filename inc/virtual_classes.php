<?php

//Generate classes for each itemtype managed by the plugin
$query = "SELECT *
             FROM `glpi_plugin_customfields_itemtypes`
             WHERE `itemtype` <> 'Version'
             ORDER BY `id`";
$result = $DB->query($query);
while ($data=$DB->fetch_assoc($result)) {
   if (!class_exists("PluginCustomfields".$data['itemtype'], false)) {
      eval('class PluginCustomfields'.$data['itemtype'].' extends CommonDBTM {
	
	function getTabNameForItem(CommonGLPI $item, $withtemplate=0) {
		global $LANG;
      	
      	// These if blocks may appear useless. Let us keep them while I discover the plugin
		if ($item->getType() == "Computer") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "Monitor") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "Software") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "NetworkEquipment") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "Peripheral") {
			return $LANG["plugin_customfields"]["title"];
		}
      	if ($item->getType() == "Printer") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "CartridgeItem") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "ConsumableItem") {
			return $LANG["plugin_customfields"]["title"];
		}
		if ($item->getType() == "Phone") {
			return $LANG["plugin_customfields"]["title"];
		}
      		
      	return "";
	}
	
	static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

		switch ($item->getType()) {
      		case "Computer":
        		$prof = new self();
         		$ID = $item->getField("id");
        		// j affiche le formulaire
         		$prof->showForm($ID);
      			break;
	      	case "Monitor":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
	      	case "Software":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "NetworkEquipment":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "Peripheral":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "Printer":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "CartridgeItem":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "ConsumableItem":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   	      	case "Phone":
		         $prof = new self();
		         $ID = $item->getField("id");
		        // j affiche le formulaire
		         $prof->showForm($ID);
      			break;
   }
      // TODO: Check if we must always return true 
      return true;
   }
      		
   function showForm($ID, $options=array()) {
      		
   }
      		
}');
   }
}

?>
