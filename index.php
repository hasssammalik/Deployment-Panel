<html>
<link rel="stylesheet" type="text/css" href="themes/blue/style.css">
<script type="text/javascript" src="jquery/jquery-latest.js"></script> 
<script type="text/javascript" src="jquery/jquery.tablesorter.js"></script> 
<script type="text/javascript" src="jquery/jquery.custom.js"></script>

<title>Backend CI/CD</title>
<body>
<div id="wrapper" style="margin: 264px;    margin-top: 50px;">
<h1>Backend API Deployments</h1>
<table id="keywords" class="tablesorter">
  <thead>
  <?php 
    $handle = fopen("Backend-Dep.log", "r");
    if ($handle) {
        if( ($line = fgets($handle)) == false){
          echo "No deployments were found.";
        }else {
  ?>
    <tr>
      <th>Date</th>
      <th>Branch</th>   
      <th>Domain</th>
      <th>Status</th>
      <th>Documentation</th>
      <th>Stress Test</th>
      <th>AWS Stack</th>
      <th>Delete</th>
    </tr>
  </thead>
  <tbody>
    <?php 
     $handle = fopen("Backend-Dep.log", "r");
      while (($line = fgets($handle)) !== false) { 
        list($date,$branch,$domain, $stack, $report) = explode(",", $line);
        list($dir) = explode(".", $domain);
        $url = "https://".$domain."/7tennis/api/v1/meta/version";
    ?>
   <form method="POST" action="del.php">    
    <tr>
      <td><?php echo $date; ?></td>     
      
      <td><?php echo $branch; ?></td>
      
      <td><a href="https://<?php echo $domain; ?>" target="_blank" ><?php echo $domain; ?></a></td>


       <?php 
        $Curlhandle = curl_init($url);
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($Curlhandle,  CURLOPT_RETURNTRANSFER, TRUE);
        $response = curl_exec($Curlhandle);
        $httpCode = curl_getinfo($Curlhandle, CURLINFO_HTTP_CODE);
        curl_close($Curlhandle);
        if ($httpCode >= 200 && $httpCode < 203 ) {
      ?>
      <td>
       <div class="tooltip">
       <span class="tooltiptext"><?php echo $httpCode; ?></span>
       <img src="images/ServiceUp.png"  style="height: 22px;width: 29px;">
       </div>
       </td>
      <?php } else { ?>
        <td>
        <div class="tooltip">
        <span class="tooltiptext"><?php echo "error: ".$httpCode; ?></span>
        <img src="images/ServiceDown.png"  style="height: 22px;width: 29px;">
        </div>
        </td>
      <?php } ?>
      </div>



      <?php if($branch=="develop" || $branch=="stable(dev)" ){?>
                <td><a href="documents/develop/" target="_blank"> Goto Doc </a></td> 
                <td><a href="<?php echo $report; ?>" target="_blank" >Goto Report</a></td>
      <?php }else{?>
                <td><a href="documents/<?php echo $dir;?>/" target="_blank">Goto Doc</a></td>
                <td>N/A</td>
      <?php }?>

     
      
      <td><?php echo $stack;?></td>
      
      <input type="hidden" name="domain" value= <?php echo $domain; ?> >
      
      <input type="hidden" name="stack" value= <?php echo $stack; ?> > 

      <?php if($branch=="develop" || $branch=="stable(dev)" ){?>
        <td><button id="buttonId"  type="submit" name="submit" value="del" style="border: 0px;    background-color: transparent;" disabled><img src="images/disable.png"  style="height: 22px;width: 29px;"></button></td>
      <?php }else{?>
        <td><button id="bar"  type="submit" name="submit" value="del" style="border: 0px; background-color: transparent;"><img src="images/delete.png"  style="height: 22px;width: 29px;"></button></td>
      <?php }?>

    </tr>
   </form>

    <?php  }
        }
        fclose($handle);
    }
    ?>



</tbody>
</table>
</body>
