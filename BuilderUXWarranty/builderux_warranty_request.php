<?php
   if(isset($_GET['ClientInfo'])){
   $client_info=$_GET['ClientInfo'];
   } 
   if(isset($_GET['Subdivision']))
   {	
	  $Subdivision =$_GET['Subdivision'];
   }
   if(isset($_GET['Email'])){
	   $Email= $_GET['Email'];	 
   }
   if(isset($_GET['page']))
   { 
   	$page= $_GET['page'];	
   }
   if(isset($_GET['error_page'])){	
	   $error_page= $_GET['error_page'];	
   }  
  ?>
<script type='text/javascript' src='<?php echo plugins_url( 'js/builderux.js', __FILE__ ); ?>'></script>
    <div class="row">  
      <div class="col-sm-12"> 
        	<?php echo $client_info; ?> 
      </div>
    </div> 
   <br /><br /><br />
   <div class="row">
    <div class="col-sm-12"> 
      <div class="request_col">
       <form id="frm_warranty_request" name="frm_warranty_request" method="post">  
        <input type="hidden" id="email" name="email" value="<?php echo $Email ?>">
          <input type="hidden" id="subdivision" name="subdivision" value="<?php echo $Subdivision ?>" /> 
             <input type="hidden" id="page" name="page" value="<?php echo $page ?>">  
               <input type="hidden" id="error_page" name="error_page" value="<?php echo $error_page ?>" />
                  Please provide Information about your Warranty Request    
                 <textarea id="warranty_request" name="warranty_request" required> </textarea> 
                    <button class="btn btn-success" type="button" onclick="return nwarranty_request();"/>Submit

       </form>       
      </div>
     </div>
    </div>                 
