<? 
/*
    Copyright (C) 2013  xtr4nge [_AT_] gmail.com

    This program is free software: you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation, either version 3 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program.  If not, see <http://www.gnu.org/licenses/>.
*/ 
?>
<?
//include "../login_check.php";
include "../_info_.php";
include "/usr/share/FruityWifi/www/config/config.php";
include "/usr/share/FruityWifi/www/functions.php";

include "options_config.php";

// Checking POST & GET variables...
if ($regex == 1) {
    regex_standard($_GET["service"], "../msg.php", $regex_extra);
    regex_standard($_GET["action"], "../msg.php", $regex_extra);
    regex_standard($_GET["page"], "../msg.php", $regex_extra);
    regex_standard($io_action, "../msg.php", $regex_extra);
    regex_standard($_GET["install"], "../msg.php", $regex_extra);
}

$service = $_GET['service'];
$action = $_GET['action'];
$page = $_GET['page'];
$install = $_GET['install'];

if($service != "") {
    
    if ($action == "start") {
        
        // COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "$bin_cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec("$bin_danger \"$exec\"" );
            
            $exec = "$bin_echo '' > $mod_logs";
            exec("$bin_danger \"$exec\"" );
        }
    
        // ADD selected options
        $tmp = array_keys($mode_options);
        for ($i=0; $i< count($tmp); $i++) {
             if ($mode_options[$tmp[$i]][0] == "1") {
                if ($tmp[$i] ==  "M") {
                    if ($mode_options["M"][2] == "arp") {
                        $options .= " -M arp:remote " . $mode_options["M"][4];
                    } else {
                        $options .= " -M " . $mode_options["M"][2] . " " . $mode_options["M"][4];
                    }
                } else if ($tmp[$i] == "F") {
                    //$exec = "/usr/bin/etterfilter templates/" . $mode_options["F"][2] ." -o $mod_path/includes/filter.ef";
                    $exec = "/usr/bin/etterfilter templates/" . $mode_options["F"][2];
                    exec("$bin_danger \"$exec\"" );
                    $options .= " -F $mod_path/includes/filter.ef ";
                } else {
                    $options .= " -" . $tmp[$i] . " " . $mode_options[$tmp[$i]][2];
                } 
				
                //$options .= " -" . $tmp[$i] . " " . $mode_options[$tmp[$i]][2];
            }
        }
    
        // ADD MITM options
        if ($mode_options["M"][0] ==  1) {
            //$mitm = "-M " . $mode_options["M"][2] . " " . str_replace("/","\/",$mode_options["M"][4]);
            $mitm = "-M " . $mode_options["M"][2] . " " . $mode_options["M"][4];
        } else {
            $mitm = "";
        }
	
        $filename = "$mod_path/includes/templates/".$ss_mode;
        $data = open_file($filename);
        
	$exec = "$bin_ettercap -T $options -i $io_action >> $mod_logs &";        
	exec("$bin_danger \"$exec\"" );

		
    } else if($action == "stop") {
        // STOP MODULE
        $exec = "$bin_killall $mod_name";
        exec("$bin_danger \"$exec\"" );
        
        // COPY LOG
        if ( 0 < filesize( $mod_logs ) ) {
            $exec = "$bin_cp $mod_logs $mod_logs_history/".gmdate("Ymd-H-i-s").".log";
            exec("$bin_danger \"$exec\"" );
            
            $exec = "$bin_echo '' > $mod_logs";
            exec("$bin_danger \"$exec\"" );
        }

	$wait = 4;

    }

}

if ($install == "install_$mod_name") {

    $exec = "chmod 755 install.sh";
    exec("$bin_danger \"$exec\"" );

    $exec = "$bin_sudo ./install.sh > /usr/share/FruityWifi/logs/install.txt &";
    exec("$bin_danger \"$exec\"" );

    header('Location: ../../install.php?module='.$mod_name);
    exit;
}

if ($page == "status") {
    //header('Location: ../../../action.php');
    header('Location: ../../../action.php?wait='.$wait);
} else {
    //header('Location: ../../action.php?page='.$mod_name);
    header('Location: ../../action.php?page='.$mod_name.'&wait='.$wait);
}
//header('Location: ../../action.php?page=ngrep');

?>
