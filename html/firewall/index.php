<?php
require("../init.php");

// get the ssh ports
$q = "select * from preferences where name LIKE 'fw_%';";
$data = array();
$res = $Db->pdo_query($q,$data,$dbPDO);
$j = count($res);
for($i=0;$i<$j;$i++) { 
  # ssh ports
  if($res[$i]['name'] == "fw_ssh_ports"){
    $ssh_ports = $res[$i]['value'];
  }
  if($res[$i]['name'] == "fw_sip_ports"){
    $sip_ports = $res[$i]['value'];
  }
  if($res[$i]['name'] == "fw_rtp_ports"){
    $rtp_ports = $res[$i]['value'];
  }
  if($res[$i]['name'] == "fw_https_ports"){
    $https_ports = $res[$i]['value'];
  }
}



?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/includes/meta.php");?>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/includes/title.php");?>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/includes/css.php");?>

  </head>
  <body>
    <?php include($_SERVER["DOCUMENT_ROOT"]."/includes/top-menu.php");?>

    <div class="container">

      <h1>Firewall</h1>
      <div class="well">
        <p>Configure firewall options here.</p>
      </div>
    
      <form method="post" action="update.php">
        <div class="panel panel-primary"> 
          <div class="panel-heading"> 
            <h3 class="panel-title">SSH Ports</h3> 
          </div> 
          <div class="panel-body">
            <p>SSH access to the server is available on the standard port 22 or a non-standard port 32122</p>
            <p>Select the port(s) you want to allow SSH access on</p>
            <input type="hidden" name="firewall_update" value="ssh_update">
            <div class="radio">
              <label>
                <input type="radio" name="fw_ssh_port" id="optionsRadios1" value="22" <?php echo $ssh_ports == "22" ? " checked" : "";?>>
                Port 22 only
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="fw_ssh_port" id="optionsRadios2" value="32122" <?php echo $ssh_ports == "32122" ? " checked" : "";?>>
                Port 32122 only
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="fw_ssh_port" id="optionsRadios3" value="both" <?php echo $ssh_ports == "both" ? " checked" : "";?>>
                Both ports 22 and 32122
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Update SSH Options</button>
          </div> 
        </div>
      </form>

      <form method="post" action="update.php">
        <div class="panel panel-primary"> 
          <div class="panel-heading"> 
            <h3 class="panel-title">SIP Ports</h3> 
          </div> 
          <div class="panel-body">
            <p>SIP signalling is port 5060 which is open to the world by default.</p>
            <p>You can block port 5060 if you have added whitelisted IP address(es)</p>
            <input type="hidden" name="firewall_update" value="sip_update">
            <div class="radio">
              <label>
                <input type="radio" name="fw_sip_port" id="optionsRadios1" value="5060" <?php echo $sip_ports == "5060" ? " checked" : "";?>>
                Open
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="fw_sip_port" id="optionsRadios2" value="off" <?php echo $sip_ports == "off" ? " checked" : "";?>>
                Closed
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Update SIP Options</button>
          </div> 
        </div>
      </form>

      <form method="post" action="update.php">
        <div class="panel panel-primary"> 
          <div class="panel-heading"> 
            <h3 class="panel-title">RTP Ports</h3> 
          </div> 
          <div class="panel-body">
            <p>RTP media is port range 8000 - 55000 which is open to the world by default.</p>
            <p>You can block RTP ports if you have added whitelisted IP address(es)</p>
            <input type="hidden" name="firewall_update" value="rtp_update">
            <div class="radio">
              <label>
                <input type="radio" name="fw_rtp_port" id="optionsRadios1" value="8000:55000" <?php echo $rtp_ports == "8000:55000" ? " checked" : "";?>>
                Open
              </label>
            </div>
            <div class="radio">
              <label>
                <input type="radio" name="fw_rtp_port" id="optionsRadios2" value="off" <?php echo $rtp_ports == "off" ? " checked" : "";?>>
                Closed
              </label>
            </div>
            <button type="submit" class="btn btn-primary">Update RTP Options</button>
          </div> 
        </div>
      </form>

      <div class="well">
        <h4>IP Tables Output</h4>
        <code><?php $last = exec('sudo /sbin/iptables -L', $o, $r);  print nl2br(htmlentities(implode("\n", $o)));?></code>
      </div>


    </div>

    <?php include($_SERVER["DOCUMENT_ROOT"]."/includes/js.php");?>
  
  </body>
</html>