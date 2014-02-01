# GLPI Custom fields plugin

## Introduction

This plugin enables the management of custom fields for GLPI objects and is
based on the original code by Matt Hoover and Ryan Foster (originally
sponsored by Oregon Dept. of Administrative Services,
State Data Center) located in the [GLPI forge][].

This fork enables the use of this plugin in GLPI 0.84 onwards.

## Installation

Download the current release (branch 1.5-bugfixes) and unpack the archive to a directory
"customfields" inside the GLPI plugin directory. Afterwards use the GLPI web
UI to install and activate the plugin.

Migrations of old version of the plugin are possible by just overwriting the
previous code with this version (better removing the files from the previous
version first) and using the update function in the web UI. (Please backup
your data prior to this!)

[GLPI forge]: https://forge.indepnet.net/projects/customfields
