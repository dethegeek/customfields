<?php
/*
----------------------------------------------------------------------
GLPI - Gestionnaire Libre de Parc Informatique
Copyright (C) 2003-2009 by the INDEPNET Development Team.

http://indepnet.net/   http://glpi-project.org/
----------------------------------------------------------------------

LICENSE

This file is part of GLPI.

GLPI is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

GLPI is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with GLPI; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
------------------------------------------------------------------------
*/

// ----------------------------------------------------------------------
// Sponsor: Oregon Dept. of Administrative Services, State Data Center
// Original Author of file: Ryan Foster
// Contact: Matt Hoover <dev@opensourcegov.net>
// Project Website: http://www.opensourcegov.net
// Purpose of file: Create a class to take advantage of core features
// such as update and logging.
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   die('Sorry. You can\'t access this file directly.');
}

// CLASS customfields
class PluginCustomfieldsField extends CommonDBTM
{
   
   function getTabNameForItem(CommonGLPI $item, $withtemplate = 0)
   {
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
   
   static function displayTabContentForItem(CommonGLPI $item, $tabnum = 1, $withtemplate = 0)
   {
      
      // TODO: Rename $prof into something more explicit 
      // (the name comes from a copy / paste https://forge.indepnet.net/projects/plugins/wiki/Fr_CreatePlugin084)
      $itemType = $item->getType();
      switch ($itemType) {
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
            $customFieldsItemType = "PluginCustomfields" . $itemType;
            $customFieldsItem     = new $customFieldsItemType();
            $ID                   = $item->getField("id");
            // j affiche le formulaire
            $customFieldsItem->showForm($ID);
            break;
      }
      // TODO: Check if we must always return true 
      return true;
   }
   
   function showForm($id, $options = array())
   {
      global $CFG_GLPI, $DB;
      
      //$target = $this->getFormURL();
      $target = $CFG_GLPI["root_doc"] . "/plugins/customfields/front/field.form.php";
      if (isset($options['target'])) {
         $target = $options['target'];
      }
      
      if (!Session::haveRight("profile", "r")) {
         //return false;
      }

      switch ($this->associatedItemType()) {
         case "Computer":
            $canedit = Session::haveRight(strtolower($this->associatedItemType()), "w");
            $canread = Session::haveRight(strtolower($this->associatedItemType()), "r");
         case "ComputerDisk":
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
            $canedit = Session::haveRight("device", "w");
            $canread = Session::haveRight("device", "r");
            break;
         case "Monitor":
         case "Software":
         case "NetworkEquipment":
         case "Peripheral":
         case "Printer":
         case "CartridgeItem":
         case "ConsumableItem":
         case "Phone":
            $canedit = Session::haveRight(strtolower($this->associatedItemType()), "w");
            $canread = Session::haveRight(strtolower($this->associatedItemType()), "r");
            break;
         case "Supplier":
         case "Contact":
            $canedit = Session::haveRight("contact_enterprise", "w");
            $canread = Session::haveRight("contact_enterprise", "r");
            break;
         case "SoftwareVersion":
         case "SoftwareLicense":
            $canedit = Session::haveRight("software", "w");
            $canread = Session::haveRight("software", "r");
            break;
         case "Ticket":
            $canedit = Session::haveRight("update_ticket", "1");
            $canread = true;
            break;
         case "Contract":
         case "Document":
         case "User":
         case "Group":
            $canedit = Session::haveRight(strtolower($this->associatedItemType()), "w");
            $canread = Session::haveRight(strtolower($this->associatedItemType()), "r");
            break;
      }
      
      if ($canread != true) {
         return false;
      }
      
      //$canedit = Session::haveRight("profile", "w");
      
      $itemType           = $this->getType();
      $associatedItemType = $this->associatedItemType();
      $table              = $itemType::getTable();
      
      $sql    = "SELECT *
	  		    FROM `$table`
	          WHERE `id` = $id";
      $result = $DB->query($sql);
      
      $associatedItemCustomValues = $DB->fetch_assoc($result);
      
      $DB->free_result($result);
      
      $sql                = "SELECT `label`, `system_name`, `data_type`, `default_value`, `system_name`
	  		    FROM `glpi_plugin_customfields_fields`
	    		 WHERE `deleted` = '0' AND `itemtype` = '" . $associatedItemType . "'
			    ORDER BY `sort_order` ASC, `label` ASC";
      $result             = $DB->query($sql);
      $currentSectionName = '';
      
      echo "<form action='" . $target . "' method='post'>";
      echo "<table class='tab_cadre_fixe'>";
      
      while ($data = $DB->fetch_assoc($result)) {
         switch ($data['data_type']) {
            case 'sectionhead':
               $currentSectionName = $data['label'];
               echo "<tr><th colspan='2' class='center b'>" . $currentSectionName;
               echo "</th></tr>";
               break;
            default:
               if ($currentSectionName == '') {
                  $currentSectionName = "&nbsp;";
                  echo "<tr><th colspan='2' class='center b'>" . $currentSectionName;
                  echo "</th></tr>";
               }
               $fieldName         = $data['system_name'];
               $fieldDefaultValue = $associatedItemCustomValues[$fieldName];
               echo "<tr><td>" . $data['label'] . "</td><td>";
               
               $readonly = false;
               if ($data['restricted']) {
                  $checkfield = $data['itemtype'] . '_' . $data['system_name'];
                  $prof       = new pluginCustomfieldsProfile();
                  if (!$prof->fieldHaveRight($checkfield, 'r')) {
                     continue;
                  }
                  if (!$prof->fieldHaveRight($checkfield, 'w')) {
                     $readonly = true;
                  }
               }
               
               if ($data['data_type'] != 'sectionhead') {
                  $value = $associatedItemCustomValues[$fieldName];
               }
               
               switch ($data['data_type']) {
                  case 'general':
                     if (!$readonly) {
                        echo '<input type="text" size="20" value="' . $value . '" name="' . $fieldName . '"/>';
                     } else {
                        plugin_customfields_showValue($value);
                     }
                     break;
                  
                  case 'dropdown':
                     if (!$readonly) {
                        //                     dropdownValue($fields['dropdown_table'], $field_name, $value);
                        //Dropdown::show('Location', array('value'  => $value));
                        $dropdown_obj = new PluginCustomfieldsDropdown;
                        $tmp          = $dropdown_obj->find("system_name = '" . $data['system_name'] . "'");
                        $dropdown     = array_shift($tmp);
                        
                        Dropdown::show('PluginCustomfieldsDropdownsItem', array(
                           'condition' => $dropdown['id'] . " = plugin_customfields_dropdowns_id",
                           'name' => $fieldName,
                           'value' => $value,
                           'entity' => $_SESSION['glpiactive_entity']
                        ));
                     } else {
                        //                     plugin_customfields_showValue(Dropdown::getDropdownName($fields['dropdown_table'],
                        //                                                                             $value));
                     }
                     break;
                  
                  case 'date':
                     $editcalendar = !$readonly;
                     Html::showDateFormItem($fieldName, $value, true, $editcalendar);
                     break;
                  
                  case 'money':
                     if (!$readonly) {
                        echo '<input type="text" size="16" value="' . Html::formatNumber($value, true) . '" name="' . $fieldName . '"/>';
                     } else {
                        plugin_customfields_showValue(Html::formatNumber($value, true));
                     }
                     break;
                  
                  case 'yesno':
                     if (!$readonly) {
                        Dropdown::showYesNo($fieldName, $value);
                     } else {
                        plugin_customfields_showValue(Dropdown::getYesNo($fieldName, $value));
                     }
                     break;
                  
                  case 'text': // only in effect if the condition about 40 lines above is removed
                     if (!$readonly) {
                        echo '<textarea name="' . $fieldName . '" rows="4"
                          cols="35">' . $value . '</textarea>';
                     } else {
                        plugin_customfields_showValue($value, 'height:6em;width:23em;');
                     }
                     break;
                  
                  case 'number':
                     if (!$readonly) {
                        echo '<input type="text" size="10" value="' . $value . '" name="' . $fieldName . '"/>';
                     } else {
                        plugin_customfields_showValue($value);
                     }
                     break;
               }
               
               
               echo "</td></tr>";
         }
      }
      $DB->free_result($result);
      
      if ($canedit) {
         echo "<tr class='tab_bg_1'>";
         echo "<td class='center' colspan='2'>";
         echo "<input type='hidden' name='id' value='$id'>";
         echo "<input type='hidden' name='customfielditemtype' value='$itemType'>";
         echo "<input type='submit' name='update_customfield' value='" . _sx('button', 'Save') . "' class='submit'>";
         echo "</td></tr>";
      }
      echo "</table>";
      Html::closeForm();
   }
   function post_addItem()
   {
      
      // Just call post_updateitem, because custom fields are not really
      // "added"
      
      $this->post_updateItem();
   }
   
   /**
    * Add History Log after updating a custom field
    *
    * @param int $history
    * @return nothing|void
    */
   
   function post_updateItem($history = 1)
   {
      
      $oldvalues = array();
      $newvalues = array();
      
      foreach ($this->updates as $field) {
         
         $oldvalues = $field . " (" . $this->oldvalues[$field] . ")";
         $newvalues = $field . " (" . $this->fields[$field] . ")";
         
         Log::history($this->fields["id"], 
            $this->associatedItemType(), 
            array(
               0,
               $oldvalues,
               $newvalues
            ),
            0, 
            Log::HISTORY_UPDATE_SUBITEM);
      }
      
   }
}
?>