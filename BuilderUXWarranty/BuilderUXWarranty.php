<?php
define( 'WP_DEBUG', false );
/**
 * @package BuilderUXWarranty
 * @version 1
Plugin Name: BuilderUXWarranty
Plugin URI: 
Description:
Version: 1
Author URI: fritz barry hoy
*/
 # ============= add builder user ===================

$user_id = 0; 
function install_warranty_request_page()
{
  global $user_id;
  $page = get_page_by_title('Warranty Request');

 if ( ! $page ) {

     $post = array(

            'comment_status' => 'closed',
            'ping_status' =>  'closed' ,
            'post_author' => $user_id,
            'post_date' => date('Y-m-d H:i:s'),
            'post_name' => 'builderux-warranty-request',
            'post_status' => 'publish' ,
            'post_title' => 'Builderux Warranty Request',
            'post_content' => '[builderux_warranty_request]',
            'post_type' => 'page',

      ); 
       $newvalue = wp_insert_post( $post, false );
      update_option( 'builderux_warranty_request', $newvalue );

    }else{

     $my_post = array(

         'ID'           => $page->ID,
         'post_content' => '[builderux_warranty_request]',

     );

    wp_update_post( $my_post );   

     }
 }

function install_builder_user(){

 global $user_id;

 $user = get_user_by( 'user_login', 'BuilderUXWarranty' );

 if ( ! $user ) {

     $userdata = array(

            'user_login' => 'BuilderUXWarranty',
            'user_nicename' =>  'BuilderUXWarranty' ,
            'display_name' => 'BuilderUXWarranty'

      ); 
     $user_id = $newvalue = wp_insert_user( $userdata );

    }else{
      $user_id = $user->ID;

    $userdata = array(

         'ID'            => $user->ID,
         'user_login'    => 'builderux',
         'user_nicename' =>  'builderux',
         'display_name'  => 'builderux'

    );
    wp_update_user( $userdata ); 
  }
}

function builderux_warranty_request(){
 include 'builderux_warranty_request.php'; 
}
function BuilderUXinHouse_activate() {
    // add options, build db tables, etc
        global $wpdb;
        $table_name = $wpdb->prefix ."builderUXWarranty_builderUXInhouse";
        $table_namedata = $wpdb->prefix ."builderUXWarranty_builderUXInhousedata";
        $sqlinsert = 'insert into '. $table_namedata. '(fieldname,leadname,labelname) values("Email","Email","Email Address")';

        if ( $wpdb->get_var('SHOW TABLES LIKE "' . $table_name.'"') != $table_name )  {

                $sql = 'CREATE TABLE ' . $table_name . '( 
                                templateid varchar(255) NOT NULL, 
                               redirect_page LONGTEXT,
                                error_page LONGTEXT, 
                                guid LONGTEXT,
                                wsdl LONGTEXT,
                                title varchar(255),
                                CommunityNumber varchar(15),  
								header_text LONGTEXT,
                                button_text varchar(255), 
                               date_last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                                PRIMARY KEY  (templateid) )';
                 $sql2 = 'CREATE TABLE ' . $table_namedata . '( 

                                fieldname varchar(255) not null,

                                leadname varchar(255),

                                labelname varchar(255),

                                date_last_update TIMESTAMP DEFAULT CURRENT_TIMESTAMP,

                                PRIMARY KEY  (fieldname) )';

                require_once(ABSPATH . 'wp-admin/includes/upgrade.php');

                dbDelta($sql);

                dbDelta($sql2);

                $wpdb->query($sqlinsert);            

                add_option('BuilderUX_database_version','1.0');

        } else {

            // check if fields are present

           try {

                $wpdb->query($sqlinsert);

           } catch(Execption $e){ }

       }

}
function BuilderUXinHouse_deactivate() {

 // add options, build db tables, etc


}

register_activation_hook(__FILE__, 'install_builder_user');

register_activation_hook(__FILE__, 'install_warranty_request_page'); 

add_shortcode( 'builderux_warranty_request', 'builderux_warranty_request' );

register_activation_hook(__FILE__,"BuilderUXinHouse_activate");

register_deactivation_hook(__FILE__,"BuilderUXinHouse_deactivate");

add_action('init', 'registerInHouse_my_script');

add_action('wp_footer', 'printInHouse_my_script',100);

add_action( 'wp_enqueue_scripts', 'printInHouse_my_css' );

function registerInHouse_my_script() {

   wp_register_script('my-script', 'https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js', array('jquery'), '1.0', true);
   wp_register_script("jquery-ui","https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js",array("jquery"),'1.11.4',true);
   wp_register_script( 'validate-script', plugins_url( '/js/jquery.validate.min.js', __FILE__ ),'','','true' );
   wp_register_script( 'builder-ux', plugins_url( '/js/builderux.js', __FILE__ ),'','','true' );
   wp_localize_script( 'builder-ux', 'MyAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ) ) );
}
function printInHouse_my_css(){

    global $add_my_css;
    wp_register_style('custom-css', plugins_url( '/css/BuilderUXWarranty.css', __FILE__ ) );  
    wp_enqueue_style('custom-css');
    wp_register_style('jquery-ui-css', "https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css" );  
    wp_enqueue_style('jquery-ui-css');

}
function printInHouse_my_script() {

    global $add_my_script;
    if ( ! $add_my_script )
        return;
   if ( ! wp_script_is( 'jquery' ) ) {

      wp_print_scripts('my-script');

   }
    wp_print_scripts('validate-script');
    wp_print_scripts('jquery-ui');
    wp_print_scripts('builder-ux');  
}
function builderuxInHouse_css_and_js() {
wp_register_style('builderuxInHouse_css_and_js', plugins_url('css/bootstrap.min.css',__FILE__ ));
wp_enqueue_style('builderuxInHouse_css_and_js');
}

if (isset($_GET['page']) && ($_GET['page'] == 'BuilderUXinHouse-plugin')) { 

        // if we are on the plugin page, enable the script

    add_action('admin_print_styles', 'builderuxInHouse_css_and_js');
}
function BuilderUXinHouse_plugin_menu()
{
    add_menu_page('BuilderUXinHouse Settings','BuilderUXWarranty Plugin', 'manage_options', 'BuilderUXinHouse-plugin', 'BuilderUXinHouse_option_page');
}
add_action('admin_menu', 'BuilderUXinHouse_plugin_menu'); 

function BuilderUXWarranty_shortcodes(){

    add_shortcode('BuilderUXWarranty-template', 'BuilderUXWarranty_template');
}
function BuilderUXinHouse_option_page(){

        global $wpdb;
        $table_name = $wpdb->prefix ."builderUXWarranty_builderUXInhouse";
        $table_namedata = $wpdb->prefix ."builderUXWarranty_builderUXInhousedata";
        $title = "";
        $redirect_page = "";
        $button_text = "";
        $header_text = "";
        $error_page = "";
        $template_name = "";
        $delete ="";
        $CommunityNumber="";

       if(strtoupper($_SERVER['REQUEST_METHOD']) == 'POST'){

        $mypost = $_POST["builder"]; 
		$newdata = array(

                    'templateid'=> $_POST["templatename"],
                    'title' => $_POST["builder"]["title"],
		            'CommunityNumber' => $_POST["builder"]["CommunityNumber"],          
                    'header_text' => isset($_POST['builder']['header_text']) ? $_POST['builder']['header_text'] : "",
                    'button_text' => isset($_POST['builder']['button_text']) ? $_POST['builder']['button_text'] : "",
                    'guid' => $_POST["builder"]['guid'],
                    'wsdl' => $_POST["builder"]['wsdl'],
                    'redirect_page' => isset($_POST['builder']['redirect_page']) ? $_POST['builder']['redirect_page'] : "",
                    'error_page' => isset($_POST['builder']['error_page']) ? $_POST['builder']['error_page'] : "" 

                );    
                $wpdb->replace($table_name,$newdata,array('%s'));   
                $myselection = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $_POST["templatename"]."'");      
                $template_name = $myselection->templateid; 
                $title = $myselection->title;
				$CommunityNumber = $myselection->CommunityNumber;
                $header_text = $myselection->header_text;
                $button_text = $myselection->button_text;
                $guid = $myselection->guid;
                $wsdl = $myselection->wsdl;
                $redirect_page = $myselection->redirect_page;
				$error_page = $myselection->error_page; 

    } /** -- end of if post **/

    if (strtoupper($_SERVER['REQUEST_METHOD']) == 'GET'){

      if(isset($_GET["delete"]))  {

        $delete = $_GET["delete"];   

         if($delete){		 

          $id = $_GET["id"];     
          $wpdb->delete( $table_name, array( 'templateid' => $id ), array( '%s' ) );

         } 
      }

      if(isset($_GET["fid"])) {
        $fid = $_GET["fid"]; 
        if($fid)
            $wpdb->delete( $table_namedata, array( 'fieldname' => $fid ), array( '%s' ) );
      } 

      if(isset($_GET["id"])) {
        $id = $_GET["id"];
        if($id && !$delete) {
            $myselection = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $id."'");      
            $template_name = $myselection->templateid; 
            $title = $myselection->title;
	        $CommunityNumber = $myselection->CommunityNumber;
            $header_text = $myselection->header_text;
            $button_text = $myselection->button_text;
            $guid = $myselection->guid; 
            $wsdl = $myselection->wsdl;
            $redirect_page = $myselection->redirect_page;
            $error_page = $myselection->error_page; 
        }
      }   
     } /** end of if get **/

  ?>
    <div class="wrap">
    <?php screen_icon(); ?>
    <h2>BuilderUX </h2>
    <p>Welcome BuilderUXWarranty Plugin.</p>
    <div class="row">
        <div class="col-md-7">
        <form class="form-horizontal" id="validation-form" method='POST'>
            <div class="left">
                    <button class="btn btn-default" type="submit">Save Template</button>
             </div>
        <p>
           <div class="col-md-4">Template Name</div>
            <div class="col-md-8">
            <div class="form-group">
            <input type="text" id="filenamex" name="templatename" value="<?php echo $template_name; ?>"  class="form-control" required="required">
            </div></div>
         <div class="col-md-4">Redirect Page</div>   
              <div class="col-md-8">
            <div class="form-group"><input type="text" id="filenamex" name="builder[redirect_page]" value="<?php echo $redirect_page ?>"  class="form-control" required="required"> 
                </div></div>
          <div class="col-md-4">Error Page</div>   
              <div class="col-md-8">
            <div class="form-group"><input type="text" id="filenamex" name="builder[error_page]" value="<?php echo $error_page ?>"  class="form-control" required="required">  
                </div></div>

         <div class="col-md-4">Title</div>   
                <div class="col-md-8">
                   <div class="form-group"><input type="text" id="filenamex" name="builder[title]" value="<?php echo $title ?>"  class="form-control">  

           </div></div>
           <div class="col-md-4">Community Number</div>   
                <div class="col-md-8">
                   <div class="form-group"><input type="text" id="filenamex" name="builder[CommunityNumber]" value="<?php echo $CommunityNumber ?>" required="required"  class="form-control">  
                </div>
            </div>
            <div class="col-md-4">Header Text</div>
                <div class="col-md-8">   
                     <div class="form-group">
                       <textarea name="builder[header_text]"  cols=40 rows=5  class="form-control"><?php echo $header_text ?></textarea>
                     </div></div>
            <div class="col-md-4">Button Text</div>   
                <div class="col-md-8">
                      <div class="form-group"><input type="text" name="builder[button_text]"  value="<?php echo $button_text ?>"  class="form-control">      

               </div></div>
      <table class="table table-striped table-bordered table-hover">
       <tr> 
            <td>Label</td> 
            <td>Default Value</td> 
        </tr>
        <tr><td>Email</td>
            <td><input type="text" value="Email Address" name="form-field-label[Email]" readonly></td>                  
        </tr> 

       </table>
       <div class="left">
             <button class="btn btn-default" type="submit">Save Template</button>
      </div>
 </p>

 </form>
  </div>
  <div class="col-md-5"> 
    <div class="hr hr-18 dotted hr-double"></div>
      <div class="row">
        <h4 class="text-centre">Template List</h4>                
        <?php
             $templateids =  $wpdb->get_results('SELECT templateid FROM ' . $table_name);
             $uri_parts = explode('?', $_SERVER['REQUEST_URI'], 2);
             $ser_url = 'http://'.$_SERVER['HTTP_HOST'] . $uri_parts[0];
             foreach($templateids as $data){   
                echo "<div class='col-md-3'>";
                echo "<a href='".$ser_url."?page=BuilderUXinHouse-plugin&id=$data->templateid'><span class='fa fa-edit'></span>$data->templateid</a>";
                echo "</div>";
                echo "<div class='col-md-9 template_tag'>";
                echo "<input Type='text' size='30' value='[BuilderUXWarranty-template id=\"$data->templateid\"]'\> ";
                echo " <a href='".$ser_url."?page=BuilderUXinHouse-plugin&delete=1&id=$data->templateid'><span class='fa fa-edit'></span>Delete</a>";
                echo "</div>";
          } 
		  
        ?>
        
<?php
} 
?>
<?php
    function BuilderUXWarranty_template($args, $content){
    global $add_my_script;
    global $add_my_css;
    $add_my_script = true;
    global $wpdb;
    $table_name = $wpdb->prefix ."builderUXWarranty_builderUXInhouse";
    $tempid = $args['id'];
    if(isset($args['withcss']))
     $add_my_css = true;
    $front = "";          
    $data = array();       
    $subdivision = "";
    $CommunityNumber="";
    if($tempid.trim("")!==""){  
        $data  = $wpdb->get_row("SELECT * FROM " . $table_name." where templateid ='". $tempid."'");
        $tmp = (array) $data;
    if(empty($tmp)) return;
        $guid = $data->guid;
        $wsdl = $data->wsdl;
        $error_page = $data->error_page;
        $redirect_page = $data->redirect_page; 
        $button_text = $data->button_text;
        $title = $data->title;
        $CommunityNumber = $data->CommunityNumber;   
        $header_text = $data->header_text;
        $thisid = uniqid();
    }
    if (strtoupper($_SERVER['REQUEST_METHOD']) != 'POST'){ 
        $front .= "<div id='builder-contact-form'>";
        if($title)
          $front .= "<h3>".$title."</h3>";  
        if($header_text)
          $front .= "<p>".$header_text."</p>";
       $front .= "<form name='builder-contact-form' class='builder-contact-form' id='builder-contact-form-$tempid'  action='javascript:void(0);' method='POST'>";
            $front .= "<input type='hidden' name='builder[session]' value='".$thisid."'>";

           // $front .= "<input type='hidden' name='builder[guid]' value='".$guid."'>";

          //  $front .= "<input type='hidden' name='builder[sss]' value='".$wsdl."'>";

            $front .= "<input type='hidden' name='builder[page]' value='".$redirect_page."'>";
            $front .= "<input type='hidden' name='builder[error_page]' value='".$error_page."'>";
            $front .= "<input type='hidden' name='builder[source]' value=''>";
            $front .= "<input type='hidden' id='".$tempid."Community' value='".$CommunityNumber."' name='builder[Community]'>";
            $front .= "<input type='hidden' id='".$tempid."CommunityNumber' value='".$CommunityNumber."'  name='builder[CommunityNumber]'>";                 
            $front .= "<div class='container'>";         
            $front .= "<div class='textfield-wrapper'>";
		    $front .="<label class='sr-only' for='My First TemplateEmail'>Email Address</label>";
            $front .="<input type='email' id='My First TemplateEmail' rel='".$CommunityNumber."' placeholder='Email Address' name='builder[Email]'>" ;
            $front .= "</div>";
            $front .= "<div class='button-wrapper'>";
  	        $front .= "<div class='col-md-12'>
                       <div class='divide_diag'></div>
                       <div class='text-center'><button class='btn btn-success'  type='button'>".$button_text."</button></div>";
            $front .= "</div>";
           //** end button **//
		    $front .= "</div>"; // end of demo-wrapper
        $front .= "</div>";
        $front .= "</form>";
        $front .= "</div>";
        $front .= "<script>";
        $front .= "var myformid = '$tempid';";
        $front .= "</script>"; 
	  } else {    
    }
    return $front; 
}
add_action( 'wp_ajax_my_beback', 'my_beback' );
add_action('wp_ajax_nopriv_my_beback', 'my_beback');

function my_beback(){ 

    // Handle request then generate response using WP_Ajax_Response                        
    $subdivision = $_POST["subdivision"];
    $email = $_POST["email"];	
      try {
       $opt =  array(
                'trace'         => 1,
                'exceptions'   => 0,
				'style'         => SOAP_DOCUMENT,
                'use'         => SOAP_LITERAL,
                'soap_version'   => SOAP_1_1,
                'encoding'      => 'UTF-8'

       ); 	 
      $client2 = new SoapClient("https://ssnet.homesbyavi.com/ssnet/buxCheckEmail/buxCheckEmail.asmx?WSDL",$opt);
      $args = array("Email" => $email,"Subdivision" => $subdivision);
	  $beback = $client2->CheckBuyerForWarranty($args);                          
      $xml = $client2->__getLastResponse();                         
	  $xmlget = simplexml_load_string($xml); 
	  $UserInfo= $xmlget->UserInfo;
	   $ClientInfo= $xmlget->ClientInfo;
	  $ClientID=$xmlget->ClientID; 
	  if(empty($ClientID) || $ClientID == "") {
		echo "false";  
	   }else{
	    echo $ClientInfo; 
	   }          

     } catch (Exception $e){
       print_r($e);

    }
    die("");  
} 

add_action( 'wp_ajax_my_beback_save', 'my_beback_save' );
add_action('wp_ajax_nopriv_my_beback_save', 'my_beback_save');

function my_beback_save() { 
    $subdivision = $_POST["subdivision"];
    $email = $_POST["email"];	
	if(isset($_POST["warranty_request"])){	
		 $warranty_request = $_POST["warranty_request"];
	}

     try {
       $opt =  array(
                'trace'         => 1,
                'exceptions'   => 0,
                'style'         => SOAP_DOCUMENT,
                'use'         => SOAP_LITERAL,
                'soap_version'   => SOAP_1_1,
                'encoding'      => 'UTF-8'
       );   
        $client2=new SoapClient("https://ssnet.homesbyavi.com/ssnet/buxCheckEmail/buxCheckEmail.asmx?WSDL",$opt);                          
		$args=array('Email'=>$email,'Subdivision'=>$subdivision,'WarrantyRequest'=>$warranty_request);                         
	 	$beback=$client2->AddBuyerWarranty($args);	

	} catch (Exception $e){
        print_r($e);
    }
    die("");
 }                  
add_action('init', 'BuilderUXWarranty_shortcodes');                          
?>