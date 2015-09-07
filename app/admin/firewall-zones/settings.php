<?php
// firewall zone settings.php
// modify firewall zone module settings like zone indicator, max. chars, ...

// validate session parameters
$User->check_user_session();

// default settings for firewall zones and firewall address objects: 
// {
//	/* zoneLength defines the maximum length of the unique generated or free text zone name */
// 	"zoneLength": 3,
//	/* ipType is used to indicate IPv4 and IPv6 address objects (the address object name will be generated as an additional information for ip addresses) */
// 	"ipType": {
// 		"0":"v4",
// 		"1":"v6"
// 		},
// 	/* standard separator used to keep address objects tidy */
// 	"separator": "_",
//	/* indicator is used to indicate a zone wether is owned by the company or by a customer. the indicater is the leading character of the zone name but separated in the database. */
// 	"indicator"{
// 		"0": "own",
// 		"1": "customer"
// 		},
//	/* to automaticaly generate firewall zone names you may choose between "decimal" and "hex" (see "zoneGeneratorType" below). to define free text zone names choose "text" */
// 	"zoneGenerator": "0",
// 	"zoneGeneratorType"{
// 		"0":"decimal",
// 		"1":"hex",
// 		"2":"text"
// 		}
// }


// fetch module settings
$firewallZoneSettings = json_decode($User->settings->firewallZoneSettings,true);

$FirewallZones = new FirewallZones($Database);

$Fsettings = $FirewallZones->get_zones();
var_dump($Fsettings);
?>

<!-- database settings -->
<form name="firewallZoneSettings" id="firewallZoneSettings">
<table id="settings" class="table table-hover table-condensed table-auto">

<!-- zoneLength -->
<tr>
	<td><?php print _('Maximum zone name length'); ?></td>
	<td style="width:120px;">
		<input type="text" class="form-control input-sm" name="zoneLength" value="<?php print $firewallZoneSettings['zoneLength']; ?>">
	</td>
	<td>
		<span class="text-muted"><?php print _("Choose a maximum lenght of the zone name.<br>The default length is 3, the maximum is 31 characters.<br>(keep in mind that your firewall may have a limit for the length of zone names or address objects )"); ?></span>
	</td>
</tr>
<!-- ipType -->
<tr>
	<td><?php print _('IPv4 address type alias'); ?></td>
	<td>
		<input type="text" class="form-control input-sm" name="ipType[0]" value="<?php print $firewallZoneSettings['ipType']['0']; ?>">
	</td>
	<td rowspan="2">
		<span class="text-muted"><?php print _("Address type aliases are used to indicate a IPv4 or IPv6 address object."); ?></span>
	</td>
</tr>
<tr>
	<td><?php print _('IPv6 address type alias'); ?></td>
	<td>
		<input type="text" class="form-control input-sm" name="ipType[1]" value="<?php print $firewallZoneSettings['ipType']['1']; ?>">
	</td>
</tr>
<!-- separator -->
<tr>
	<td><?php print _('Separator'); ?></td>
	<td>
		<input type="text" class="form-control input-sm" name="separator" value="<?php print $firewallZoneSettings['separator']; ?>">
	</td>
	<td>
		<span class="text-muted"><?php print _("The separator is used to keep the name of address objects tidy."); ?></span>
	</td>
</tr>
<!-- indicator -->
<tr>
	<td><?php print _('Own zone indicator'); ?></td>
	<td>
		<input type="text" class="form-control input-sm" name="indicator[0]" value="<?php print $firewallZoneSettings['indicator']['0']; ?>">
	</td>
	<td rowspan="2">
		<span class="text-muted"><?php print _("The indicator is used to indicate a zone wether is owned by the company or by a customer.<br>It is the leading character of the zone name but will be separated from the zone name in the database."); ?></span>
	</td>
</tr>
<tr>
	<td><?php print _('Customer zone indicator'); ?></td>
	<td>
		<input type="text" class="form-control input-sm" name="indicator[1]" value="<?php print $firewallZoneSettings['indicator']['1']; ?>">
	</td>
</tr>
<!-- zoneGenerator -->
<tr>
	<td><?php print _('Zone generator method'); ?></td>
	<td>
		<select name="zoneGenerator" class="form-control input-w-auto input-sm" style="width:110px;">
			<?php foreach ($firewallZoneSettings['zoneGeneratorType'] as $key => $generator) {
				if ($firewallZoneSettings['zoneGenerator'] == $key) {
					print '<option value='.$key.' selected>'.$generator.'</option>';
				} else {
					print '<option value='.$key.'>'.$generator.'</option>';
				}				
			}?>
		</select>
	</td>
	<td>
		<span class="text-muted"><?php print _("Generate zone names automaticaly with the setting &quot;decimal&quot; or &quot;hex&quot;.<br>To use your own unique zone names you can choose the option &quot;text&quot."); ?></span>
	</td>
</tr>
<!-- zone name padding / zero fill -->
<tr>
	<td><?php print _('Zone name padding'); ?></td>
	<td>
		<input type="checkbox" class="form-control input-sm" name="padding" <?php if($firewallZoneSettings['padding'] == 'on'){ print 'value="'.$firewallZoneSettings['padding'].'" checked';} ?>>
	</td>
	<td>
		<span class="text-muted"><?php print _("Insert leading zeros into the zone name if you want to have a constant length of your zone name.<br>You may not want to use this feature with the text option."); ?></span>
	</td>
</tr>
<!-- strict mode -->
<tr>
	<td><?php print _('Zone name strict mode'); ?></td>
	<td>
		<input type="checkbox" class="form-control input-sm" name="strictMode" <?php if($firewallZoneSettings['strictMode'] == 'on'){ print 'value="'.$firewallZoneSettings['strictMode'].'" checked';} ?>>
	</td>
	<td>
		<span class="text-muted"><?php print _("Zone name strict mode is enabled by default.<br>If you like to use your own zone names with the &quot;text&quot; mode you may uncheck this to have not unique zone names."); ?></span>
	</td>
</tr>
<!-- submit -->
<tr>
	<td>
		<?php 
		foreach ($firewallZoneSettings['zoneGeneratorType'] as $key => $value) {
			print '<input type="hidden" name="zoneGeneratorType['.$key.']" value="'.$value.'">';
		} ?>
	</td>
	<td style="text-align: right">
		<input type="submit" class="btn btn-default btn-sm" value="<?php print _("Save"); ?>">
	</td>
</tr>

</table>
</form>

<!-- save holder -->
<div class="settingsEdit"></div>