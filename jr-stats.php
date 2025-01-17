<?php
/*
Plugin Name: JR Stats
Plugin URI: http://www.jakeruston.co.uk/2009/11/wordpress-plugin-jr-stats/
Description: This plugin allows you to display various statistics as a widget.
Version: 1.5.0
Author: Jake Ruston
Author URI: http://www.jakeruston.co.uk
*/

/*  Copyright 2010 Jake Ruston - the.escapist22@gmail.com

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/

$pluginname="stats";

// Hook for adding admin menus
add_action('admin_menu', 'jr_stats_add_pages');

// action function for above hook
function jr_stats_add_pages() {
    add_options_page('JR Stats', 'JR Stats', 'administrator', 'jr_stats', 'jr_stats_options_page');
}

if (!function_exists("_iscurlinstalled")) {
function _iscurlinstalled() {
if (in_array ('curl', get_loaded_extensions())) {
return true;
} else {
return false;
}
}
}

if (!function_exists("jr_show_notices")) {
function jr_show_notices() {
echo "<div id='warning' class='updated fade'><b>Ouch! You currently do not have cURL enabled on your server. This will affect the operations of your plugins.</b></div>";
}
}

if (!_iscurlinstalled()) {
add_action("admin_notices", "jr_show_notices");

} else {
if (!defined("ch"))
{
function setupch()
{
$ch = curl_init();
$c = curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
return($ch);
}
define("ch", setupch());
}

if (!function_exists("curl_get_contents")) {
function curl_get_contents($url)
{
$c = curl_setopt(ch, CURLOPT_URL, $url);
return(curl_exec(ch));
}
}
}

if (!function_exists("jr_stats_refresh")) {
function jr_stats_refresh() {
update_option("jr_submitted_stats", "0");
}
}


register_activation_hook(__FILE__,'stats_choice');

function stats_choice () {
if (get_option("jr_stats_links_choice")=="") {

if (_iscurlinstalled()) {
$pname="jr_stats";
$url=get_bloginfo('url');
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname);
update_option("jr_submitted_stats", "1");
wp_schedule_single_event(time()+172800, 'jr_stats_refresh'); 
} else {
$content = "Powered by <a href='http://arcade.xeromi.com'>Free Online Games</a> and <a href='http://directory.xeromi.com'>General Web Directory</a>.";
}

if ($content!="") {
$content=utf8_encode($content);
update_option("jr_stats_links_choice", $content);
}
}

if (get_option("jr_stats_link_personal")=="") {
$content = curl_get_contents("http://www.jakeruston.co.uk/p_pluginslink4.php");

update_option("jr_stats_link_personal", $content);
}
}

// jr_stats_options_page() displays the page content for the Test Options submenu
function jr_stats_options_page() {

    // variables for the field and option names 
    $opt_name = 'mt_stats_header';
	$opt_name_2 = 'mt_stats_color';
	$opt_name_3 = 'mt_stats_posts';
	$opt_name_4 = 'mt_stats_pages';
	$opt_name_5 = 'mt_stats_users';
    $opt_name_6 = 'mt_stats_plugin_support';
	$opt_name_7 = 'mt_stats_comments';
	$opt_name_8 = 'mt_stats_categories';
	$opt_name_9 = 'mt_stats_pingbacks';
	$opt_name_10 = 'mt_stats_links';
	$opt_name_11 = 'mt_stats_tags';
	$opt_name_12 = 'mt_stats_akismet';
    $hidden_field_name = 'mt_stats_submit_hidden';
    $data_field_name = 'mt_stats_header';
	$data_field_name_2 = 'mt_stats_color';
	$data_field_name_3 = 'mt_stats_posts';
	$data_field_name_4 = 'mt_stats_pages';
	$data_field_name_5 = 'mt_stats_users';
    $data_field_name_6 = 'mt_stats_plugin_support';
	$data_field_name_7 = 'mt_stats_comments';
	$data_field_name_8 = 'mt_stats_categories';
	$data_field_name_9 = 'mt_stats_pingbacks';
	$data_field_name_10 = 'mt_stats_links';
	$data_field_name_11 = 'mt_stats_tags';
	$data_field_name_12 = 'mt_stats_akismet';

    // Read in existing option value from database
    $opt_val = get_option( $opt_name );
	$opt_val_2 = get_option( $opt_name_2 );
	$opt_val_3 = get_option( $opt_name_3 );
	$opt_val_4 = get_option( $opt_name_4 );
	$opt_val_5 = get_option( $opt_name_5 );
    $opt_val_6 = get_option($opt_name_6);
	$opt_val_7 = get_option( $opt_name_7 );
	$opt_val_8 = get_option( $opt_name_8 );
	$opt_val_9 = get_option( $opt_name_9 );
	$opt_val_10 = get_option( $opt_name_10 );
	$opt_val_11 = get_option( $opt_name_11 );
	$opt_val_12 = get_option( $opt_name_12 );
    
if (!$_POST['feedback']=='') {
$my_email1="the.escapist22@gmail.com";
$plugin_name="JR Stats";
$blog_url_feedback=get_bloginfo('url');
$user_email=$_POST['email'];
$user_email=stripslashes($user_email);
$subject=$_POST['subject'];
$subject=stripslashes($subject);
$name=$_POST['name'];
$name=stripslashes($name);
$response=$_POST['response'];
$response=stripslashes($response);
$category=$_POST['category'];
$category=stripslashes($category);
if ($response=="Yes") {
$response="REQUIRED: ";
}
$feedback_feedback=$_POST['feedback'];
$feedback_feedback=stripslashes($feedback_feedback);
if ($user_email=="") {
$headers1 = "From: feedback@jakeruston.co.uk";
} else {
$headers1 = "From: $user_email";
}
$emailsubject1=$response.$plugin_name." - ".$category." - ".$subject;
$emailmessage1="Blog: $blog_url_feedback\n\nUser Name: $name\n\nUser E-Mail: $user_email\n\nMessage: $feedback_feedback";
mail($my_email1,$emailsubject1,$emailmessage1,$headers1);
?>

<div class="updated"><p><strong><?php _e('Feedback Sent!', 'mt_trans_domain' ); ?></strong></p></div>

<?php
}

    // See if the user has posted us some information
    // If they did, this hidden field will be set to 'Y'
    if( $_POST[ $hidden_field_name ] == 'Y' ) {
        // Read their posted value
        $opt_val = $_POST[ $data_field_name ];
		$opt_val_2 = $_POST[ $data_field_name_2 ];
		$opt_val_3 = $_POST[ $data_field_name_3 ];
		$opt_val_4 = $_POST[ $data_field_name_4 ];
		$opt_val_5 = $_POST[ $data_field_name_5 ];
        $opt_val_6 = $_POST[$data_field_name_6];
		$opt_val_7 = $_POST[ $data_field_name_7 ];
		$opt_val_8 = $_POST[ $data_field_name_8 ];
		$opt_val_9 = $_POST[ $data_field_name_9 ];
		$opt_val_10 = $_POST[ $data_field_name_10 ];
		$opt_val_11 = $_POST[ $data_field_name_11 ];
		$opt_val_12 = $_POST[ $data_field_name_12 ];

        // Save the posted value in the database
        update_option( $opt_name, $opt_val );
		update_option( $opt_name_2, $opt_val_2 );
		update_option( $opt_name_3, $opt_val_3 );
		update_option( $opt_name_4, $opt_val_4 );
		update_option( $opt_name_5, $opt_val_5 );
        update_option( $opt_name_6, $opt_val_6 );
        update_option( $opt_name_7, $opt_val_7 );
        update_option( $opt_name_8, $opt_val_8 );	
        update_option( $opt_name_9, $opt_val_9 );
        update_option( $opt_name_10, $opt_val_10 );	
        update_option( $opt_name_11, $opt_val_11 );		
        update_option( $opt_name_12, $opt_val_12 );		

        // Put an options updated message on the screen

?>
<div class="updated"><p><strong><?php _e('Options saved.', 'mt_trans_domain' ); ?></strong></p></div>
<?php

    }

    // Now display the options editing screen

    echo '<div class="wrap">';

    // header

    echo "<h2>" . __( 'JR Stats Plugin Options', 'mt_trans_domain' ) . "</h2>";
$blog_url_feedback=get_bloginfo('url');
	$donated=curl_get_contents("http://www.jakeruston.co.uk/p-donation/index.php?url=".$blog_url_feedback);
	if ($donated=="1") {
	?>
		<div class="updated"><p><strong><?php _e('Thank you for donating!', 'mt_trans_domain' ); ?></strong></p></div>
	<?php
	} else {
	if ($_POST['mtdonationjr']!="") {
	update_option("mtdonationjr", "444");
	}
	
	if (get_option("mtdonationjr")=="") {
	?>
	<div class="updated"><p><strong><?php _e('Please consider donating to help support the development of my plugins!', 'mt_trans_domain' ); ?></strong><br /><br /><form action="https://www.paypal.com/cgi-bin/webscr" method="post">
<input type="hidden" name="cmd" value="_s-xclick">
<input type="hidden" name="hosted_button_id" value="ULRRFEPGZ6PSJ">
<input type="image" src="https://www.paypal.com/en_US/GB/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal - The safer, easier way to pay online.">
<img alt="" border="0" src="https://www.paypal.com/en_GB/i/scr/pixel.gif" width="1" height="1">
</form></p><br /><form action="" method="post"><input type="hidden" name="mtdonationjr" value="444" /><input type="submit" value="Don't Show This Again" /></form></div>
<?php
}
}

    // options form
    
    $change4 = get_option("mt_stats_plugin_support");
	$change5 = get_option("mt_stats_posts");
	$change6 = get_option("mt_stats_pages");
	$change7 = get_option("mt_stats_users");
	$change8 = get_option("mt_stats_comments");
	$change9 = get_option("mt_stats_categories");
	$change10 = get_option("mt_stats_pingbacks");
	$change11 = get_option("mt_stats_links");
	$change12 = get_option("mt_stats_tags");
	$change13 = get_option("mt_stats_akismet");

if ($change4=="Yes" || $change4=="") {
$change4="checked";
$change41="";
} else {
$change4="";
$change41="checked";
}

if ($change5=="Yes" || $change5=="") {
$change5="checked";
$change51="";
} else {
$change5="";
$change51="checked";
}

if ($change6=="Yes" || $change6=="") {
$change6="checked";
$change61="";
} else {
$change6="";
$change61="checked";
}

if ($change7=="Yes" || $change7=="") {
$change7="checked";
$change71="";
} else {
$change7="";
$change71="checked";
}

if ($change8=="Yes" || $change8=="") {
$change8="checked";
$change81="";
} else {
$change8="";
$change81="checked";
}

if ($change9=="Yes" || $change9=="") {
$change9="checked";
$change91="";
} else {
$change9="";
$change91="checked";
}

if ($change10=="Yes" || $change10=="") {
$change10="checked";
$change101="";
} else {
$change10="";
$change101="checked";
}

if ($change11=="Yes" || $change11=="") {
$change11="checked";
$change111="";
} else {
$change11="";
$change111="checked";
}

if ($change12=="Yes" || $change12=="") {
$change12="checked";
$change121="";
} else {
$change12="";
$change121="checked";
}

if ($change13=="Yes" || $change13=="") {
$change13="checked";
$change131="";
} else {
$change13="";
$change131="checked";
}
    ?>
	<iframe src="http://www.jakeruston.co.uk/plugins/index.php" width="100%" height="20%">iframe support is required to see this.</iframe>
<form name="form1" method="post" action="">
<input type="hidden" name="<?php echo $hidden_field_name; ?>" value="Y">

<p><?php _e("Widget Title", 'mt_trans_domain' ); ?> 
<input type="text" name="<?php echo $data_field_name; ?>" value="<?php echo $opt_val; ?>" size="50">
</p><hr />

<p><?php _e("Enable Total Posts?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_3; ?>" value="Yes" <?php echo $change5; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_3; ?>" value="No" <?php echo $change51; ?>>No
</p><hr />

<p><?php _e("Enable Total Pages?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_4; ?>" value="Yes" <?php echo $change6; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_4; ?>" value="No" <?php echo $change61; ?>>No
</p><hr />

<p><?php _e("Enable Total Categories?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_8; ?>" value="Yes" <?php echo $change9; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_8; ?>" value="No" <?php echo $change91; ?>>No
</p><hr />

<p><?php _e("Enable Total Blogroll Links?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_10; ?>" value="Yes" <?php echo $change11; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_10; ?>" value="No" <?php echo $change111; ?>>No
</p><hr />

<p><?php _e("Enable Total Users?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="Yes" <?php echo $change7; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_5; ?>" value="No" <?php echo $change71; ?>>No
</p><hr />

<p><?php _e("Enable Total Comments?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_7; ?>" value="Yes" <?php echo $change8; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_7; ?>" value="No" <?php echo $change81; ?>>No
</p><hr />

<p><?php _e("Enable Total Pingbacks?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_9; ?>" value="Yes" <?php echo $change10; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_9; ?>" value="No" <?php echo $change101; ?>>No
</p><hr />

<p><?php _e("Enable Total Tags?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_11; ?>" value="Yes" <?php echo $change12; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_11; ?>" value="No" <?php echo $change121; ?>>No
</p><hr />

<p><?php _e("Enable Akismet Spam Count?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_12; ?>" value="Yes" <?php echo $change13; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_12; ?>" value="No" <?php echo $change131; ?>>No
</p><hr />

<p><?php _e("Hex Colour Code:", 'mt_trans_domain' ); ?> 
#<input size="7" name="<?php echo $data_field_name_2; ?>" value="<?php echo $opt_val_2; ?>">
(For help, go to <a href="http://html-color-codes.com/">HTML Color Codes</a>).
</p><hr />

<p><?php _e("Show Plugin Support?", 'mt_trans_domain' ); ?> 
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="Yes" <?php echo $change4; ?>>Yes
<input type="radio" name="<?php echo $data_field_name_6; ?>" value="No" <?php echo $change41; ?> id="Please do not disable plugin support - This is the only thing I get from creating this free plugin!" onClick="alert(id)">No
</p><hr />

<p class="submit">
<input type="submit" name="Submit" value="<?php _e('Update Options', 'mt_trans_domain' ) ?>" />
</p><hr />

</form>
<script type="text/javascript">
function validate_required(field,alerttxt)
{
with (field)
  {
  if (value==null||value=="")
    {
    alert(alerttxt);return false;
    }
  else
    {
    return true;
    }
  }
}

function validateEmail(ctrl){

var strMail = ctrl.value
        var regMail =  /^\w+([-.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;

        if (regMail.test(strMail))
        {
            return true;
        }
        else
        {

            return false;

        }
					
	}

function validate_form(thisform)
{
with (thisform)
  {
  if (validate_required(subject,"Subject must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(email,"E-Mail must be filled out!")==false)
  {email.focus();return false;}
  if (validate_required(feedback,"Feedback must be filled out!")==false)
  {email.focus();return false;}
  if (validateEmail(email)==false)
  {
  alert("E-Mail Address not valid!");
  email.focus();
  return false;
  }
 }
}
</script>
<h3>Submit Feedback about my Plugin!</h3>
<p><b>Note: Only send feedback in english, I cannot understand other languages!</b><br /><b>Please do not send spam messages!</b></p>
<form name="form2" method="post" action="" onsubmit="return validate_form(this)">
<p><?php _e("Your Name:", 'mt_trans_domain' ); ?> 
<input type="text" name="name" /></p>
<p><?php _e("E-Mail Address (Required):", 'mt_trans_domain' ); ?> 
<input type="text" name="email" /></p>
<p><?php _e("Message Category:", 'mt_trans_domain'); ?>
<select name="category">
<option value="General">General</option>
<option value="Feedback">Feedback</option>
<option value="Bug Report">Bug Report</option>
<option value="Feature Request">Feature Request</option>
<option value="Other">Other</option>
</select>
<p><?php _e("Message Subject (Required):", 'mt_trans_domain' ); ?>
<input type="text" name="subject" /></p>
<input type="checkbox" name="response" value="Yes" /> I want e-mailing back about this feedback</p>
<p><?php _e("Message Comment (Required):", 'mt_trans_domain' ); ?> 
<textarea name="feedback"></textarea>
</p>
<p class="submit">
<input type="submit" name="Send" value="<?php _e('Send', 'mt_trans_domain' ); ?>" />
</p><hr /></form>
</div>
<?php
}

if (get_option("jr_stats_links_choice")=="") {
stats_choice();
}

function show_stats($args) {

extract($args);

  $stats_header = get_option("mt_stats_header"); 
  $plugin_support = get_option("mt_stats_plugin_support");
  $statscolor = get_option("mt_stats_color");
  $stats_posts = get_option("mt_stats_posts");
  $stats_pages = get_option("mt_stats_pages");
  $stats_users = get_option("mt_stats_users");
  $stats_comments = get_option("mt_stats_comments");
  $stats_categories = get_option("mt_stats_categories");
  $stats_pingbacks = get_option("mt_stats_pingbacks");
  $stats_links = get_option("mt_stats_links");
  $stats_tags = get_option("mt_stats_tags");
  $stats_akismet = get_option("mt_stats_akismet");

if ($stats_header=="") {
$stats_header="Statistics";
}

if ($statscolor=="") {
$statscolor="000000";
}

$i=0;
$j=0;
$k=0;
$l=0;
$m=0;

echo $before_title.$stats_header.$after_title."<br />"; 

if ($stats_posts=="" || $stats_posts=="Yes") {
 global $post;
 $myposts = get_posts('numberposts=-1');
 foreach($myposts as $post) :
 $i ++;
 endforeach;
 
echo $before_widget."Total Posts: ".$i.$after_widget; 
}

if ($stats_pages=="" || $stats_pages=="Yes") {
$pages = get_pages();

  foreach ($pages as $pagg) :
 $j ++;
 endforeach;
 
echo $before_widget."Total Pages: ".$j.$after_widget; 
}

if ($stats_categories=="" || $stats_categories=="Yes") {
$categories = get_categories();

  foreach ($categories as $cagg) :
 $l ++;
 endforeach;
 
echo $before_widget."Total Categories: ".$l.$after_widget; 
}

if ($stats_links=="" || $stats_links=="Yes") {
global $wpdb;
$links=$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->links;");
 
echo $before_widget."Total Links: ".$links.$after_widget; 
}

if ($stats_users=="" || $stats_users=="Yes") {
global $wpdb;
$users=$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->users;");
 
echo $before_widget."Total Users: ".$users.$after_widget; 
}

if ($stats_comments=="" || $stats_comments=="Yes") {
$comments = get_comments();
  foreach($comments as $comm) :
  $k ++;
  endforeach;
 
echo $before_widget."Total Comments: ".$k.$after_widget; 
}

if ($stats_pingbacks=="" || $stats_pingbacks=="Yes") {
global $wpdb;
$pingbacks=$wpdb->get_var("SELECT COUNT(*) FROM $wpdb->comments WHERE comment_type='pingback';");
 
echo $before_widget."Total Pingbacks: ".$pingbacks.$after_widget; 
}

if ($stats_tags=="" || $stats_tags=="Yes") {
$tags = get_tags();

  foreach ($tags as $tagg) :
 $m ++;
 endforeach;
 
echo $before_widget."Total Tags: ".$m.$after_widget; 
}

if ($stats_akismet=="" || $stats_akismet=="Yes") {
$akismetcount = number_format_i18n(get_option('akismet_spam_count'));
 
echo $before_widget."Akismet Spam Count: ".$akismetcount.$after_widget; 
}

if ($plugin_support=="Yes" || $plugin_support=="") {
$linkper=utf8_decode(get_option('jr_stats_link_personal'));

if (get_option("jr_stats_link_newcheck")=="") {
$pieces=explode("</a>", get_option('jr_stats_links_choice'));
$pieces[0]=str_replace(" ", "%20", $pieces[0]);
$pieces[0]=curl_get_contents("http://www.jakeruston.co.uk/newcheck.php?q=".$pieces[0]."");
$new=implode("</a>", $pieces);
update_option("jr_stats_links_choice", $new);
update_option("jr_stats_link_newcheck", "444");
}

if (get_option("jr_submitted_stats")=="0") {
$pname="jr_stats";
$url=get_bloginfo('url');
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname);
update_option("jr_submitted_stats", "1");
update_option("jr_stats_links_choice", $content);

wp_schedule_single_event(time()+172800, 'jr_stats_refresh'); 
} else if (get_option("jr_submitted_stats")=="") {
$pname="jr_stats";
$url=get_bloginfo('url');
$current=get_option("jr_stats_links_choice");
$content = curl_get_contents("http://www.jakeruston.co.uk/plugins/links.php?url=".$url."&pname=".$pname."&override=".$current);
update_option("jr_submitted_stats", "1");
update_option("jr_stats_links_choice", $content);

wp_schedule_single_event(time()+172800, 'jr_stats_refresh'); 
}

echo "<br /><p style='color:#".$statscolor.";font-size:x-small'>Stats Plugin created by ".$linkper." - ".stripslashes(get_option('jr_stats_links_choice'))."</p>";
}
}

function init_stats_widget() {
register_sidebar_widget("JR Stats", "show_stats");
}

add_action("plugins_loaded", "init_stats_widget");

?>
