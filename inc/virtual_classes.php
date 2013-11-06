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
      		
		if ($item->getType() == "Computer") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "Monitor") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "Software") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "NetworkEquipment") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "Printer") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "CartridgeItem") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "ConsumableItem") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
		if ($item->getType() == "Phone") {
			return $LANG["plugin_customfields"]["Custom_Field"];
		}
      		
      	return "";
	}
	
	static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      if ($item->getType() == "Computer") {
         $prof = new self();
         $ID = $item->getField("id");
        // j affiche le formulaire
         $prof->showForm($ID);
      } else if ($item->getType() == "Monitor") {
         $prof = new self();
         $ID = $item->getField("id");
        // j affiche le formulaire
         $prof->showForm($ID);
      }
      return true;
   }
      		
}');
   }
}

?>
