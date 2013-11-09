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
      		case "SoftwareVersion":
      		case "SoftwareLicense":
      		case "Ticket":
      		case "Contact":
      		case "Contract":
      		case "Document":
      		case "User":
      		case "Group":
      		case "Entity":
      		case "DeviceProcessor":
      		case "DeviceMemory":
      		case "DeviceMotherboard":
      		case "DeviceNetworkCard":
      		case "DeviceHardDrive":
      		case "DeviceDrive":
      		case "DeviceControl":
      		case "DeviceGraphicCard":
      		case "DeviceSoundCard":
      		case "DeviceCase":
      		case "DevicePowerSupply":
      		case "DevicePci":
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
      		case "SoftwareVersion":
      		case "SoftwareLicense":
      		case "Ticket":
      		case "Contact":
      		case "Contract":
      		case "Document":
      		case "User":
      		case "Group":
      		case "Entity":
      		case "DeviceProcessor":
      		case "DeviceMemory":
      		case "DeviceMotherboard":
      		case "DeviceNetworkCard":
      		case "DeviceHardDrive":
      		case "DeviceDrive":
      		case "DeviceControl":
      		case "DeviceGraphicCard":
      		case "DeviceSoundCard":
      		case "DeviceCase":
      		case "DevicePowerSupply":
      		case "DevicePci":
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
