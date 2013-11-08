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
      	
		switch ($item->getType()) {
      		case "Computer":
      		case "Monitor":
      		case "Software":
      		case "NetworkEquipment":
      		case "Peripheral":
      		case "Printer":
      		case "CartridgeItem":
      		case "ConsumableItem":
      		case "Phone":
      		case "ComputerDisk":
      		case "Supplier":
				return $LANG["plugin_customfields"]["title"];
      			break;
      	}
      		
      	return "";
	}
	
	static function displayTabContentForItem(CommonGLPI $item, $tabnum=1, $withtemplate=0) {

      	// TODO: Rename $prof into something more explicit 
      	// (the name comes from a copy / paste https://forge.indepnet.net/projects/plugins/wiki/Fr_CreatePlugin084)
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
			case "ComputerDisk":
				$prof = new self();
				$ID = $item->getField("id");
				// j affiche le formulaire
				$prof->showForm($ID);
				break;
			case "Supplier":
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
