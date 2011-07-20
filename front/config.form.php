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

// Sponsor: Oregon Dept. of Administrative Services, State Data Center
// Original Author of file: Ryan Foster
// Contact: Matt Hoover <dev@opensourcegov.net>
// Project Website: http://www.opensourcegov.net
// Purpose of file: Main configuration page
// ----------------------------------------------------------------------

if (!defined('GLPI_ROOT')) {
   define('GLPI_ROOT', '../../..');
   include (GLPI_ROOT.'/inc/includes.php');
}

$plugin = new Plugin();
// Check if plugin is installed and enabled
if ($plugin->isActivated("customfields")) {
    checkRight('config', 'w');

   commonHeader($LANG['common'][12], $_SERVER['PHP_SELF'], 'plugins', 'customfields');
   echo "<div class='center'>";

   echo "<table class='tab_cadre' cellpadding='5'>";
   echo "<tr><th colspan='4'>".$LANG['plugin_customfields']['Manage_Custom_Fields']."</th></tr>";
   echo "<tr><th>".$LANG['plugin_customfields']['Device_Type']."</th>";
   echo "<th>".$LANG['plugin_customfields']['Status']."</th></tr>";

   $query = "SELECT *
             FROM `glpi_plugin_customfields_itemtypes`
             WHERE `itemtype` <> 'Version'
             ORDER BY `id`";

   $result = $DB->query($query);
   while ($data=$DB->fetch_assoc($result)) {
      $item = new $data['itemtype']();
      if ($item->canCreate()) {
         echo "<tr class='tab_bg_1'>";
         echo "<td><a href='./manage.php?itemtype=".$data['itemtype']."'>".
               $LANG['plugin_customfields']['device_type'][$data['itemtype']]."</a></td>";
         if ($data['enabled'] == 1) {
            echo "<td class='b'>".$LANG['plugin_customfields']['Enabled']."</td>";
         } else {
            echo "<td><i>".$LANG['plugin_customfields']['Disabled']."</i></td>";
         }
         echo "</tr>";
      }
   }
   echo "</table><br>";

   echo "<table class='tab_cadre' cellpadding='5'>";
   echo "<tr><th>".$LANG['plugin_customfields']['setup'][3]."</th></tr>"; // Setup of Custom Fields Plugin
   echo "<tr class='tab_bg_1'><td class='center'>";
   echo "<a href='./dropdown.php'>".
         $LANG['plugin_customfields']['Manage_Custom_Dropdowns']."</a>";
   echo "</td></tr>";
   echo "</table></div>";

} else {
   commonHeader($LANG['common'][12], $_SERVER['PHP_SELF'], "config", "plugins");
   echo "<div class='center'><br><br>".
        "<img src=\"".$CFG_GLPI["root_doc"]."/pics/warning.png\" alt='warning'><br><br>";
   echo "<b>Please activate the plugin</b></div>"; // text is hard coded because language setting are not accessible
}

if (strstr($_SERVER['PHP_SELF'],"popup")) {
   popFooter();
} else {
   commonFooter();
}
?>