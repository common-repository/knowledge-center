<?php
/**
 * Getting Started
 *
 * @package KNOWLEDGE_CENTER
 * @since WPAS 5.3
 */
if (!defined('ABSPATH')) exit;
add_action('knowledge_center_getting_started', 'knowledge_center_getting_started');
/**
 * Display getting started information
 * @since WPAS 5.3
 *
 * @return html
 */
function knowledge_center_getting_started() {
	global $title;
	list($display_version) = explode('-', KNOWLEDGE_CENTER_VERSION);
?>
<style>
.about-wrap img{
max-height: 200px;
}
div.comp-feature {
    font-weight: 400;
    font-size:20px;
}
.edition-com {
    display: none;
}
.green{
color: #008000;
font-size: 30px;
}
#nav-compare:before{
    content: "\f179";
}
#emd-about .nav-tab-wrapper a:before{
    position: relative;
    box-sizing: content-box;
padding: 0px 3px;
color: #4682b4;
    width: 20px;
    height: 20px;
    overflow: hidden;
    white-space: nowrap;
    font-size: 20px;
    line-height: 1;
    cursor: pointer;
font-family: dashicons;
}
#nav-getting-started:before{
content: "\f102";
}
#nav-release-notes:before{
content: "\f348";
}
#nav-resources:before{
content: "\f118";
}
#nav-features:before{
content: "\f339";
}
#emd-about .embed-container { 
	position: relative; 
	padding-bottom: 56.25%;
	height: 0;
	overflow: hidden;
	max-width: 100%;
	height: auto;
	} 

#emd-about .embed-container iframe,
#emd-about .embed-container object,
#emd-about .embed-container embed { 
	position: absolute;
	top: 0;
	left: 0;
	width: 100%;
	height: 100%;
	}
#emd-about ul li:before{
    content: "\f522";
    font-family: dashicons;
    font-size:25px;
 }
#gallery {
display: -webkit-box;
display: -ms-flexbox;
display: flex;
-ms-flex-wrap: wrap;
    flex-wrap: wrap;
}
#gallery .gallery-item {
	margin-top: 10px;
	margin-right: 10px;
	text-align: center;
        cursor:pointer;
}
#gallery img {
	border: 2px solid #cfcfcf; 
height: 405px; 
width: auto; 
}
#gallery .gallery-caption {
	margin-left: 0;
}
#emd-about .top{
text-decoration:none;
}
#emd-about .toc{
    background-color: #fff;
    padding: 25px;
    border: 1px solid #add8e6;
    border-radius: 8px;
}
#emd-about h3,
#emd-about h2{
    margin-top: 0px;
    margin-right: 0px;
    margin-bottom: 0.6em;
    margin-left: 0px;
}
#emd-about p,
#emd-about .emd-section li{
font-size:18px
}
#emd-about a.top:after{
content: "\f342";
    font-family: dashicons;
    font-size:25px;
text-decoration:none;
}
#emd-about .toc a,
#emd-about a.top{
vertical-align: top;
}
#emd-about li{
list-style-type: none;
line-height: normal;
}
#emd-about ol li {
    list-style-type: decimal;
}
#emd-about .quote{
    background: #fff;
    border-left: 4px solid #088cf9;
    -webkit-box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    box-shadow: 0 1px 1px 0 rgba(0,0,0,.1);
    margin-top: 25px;
    padding: 1px 12px;
}
#emd-about .tooltip{
    display: inline;
    position: relative;
}
#emd-about .tooltip:hover:after{
    background: #333;
    background: rgba(0,0,0,.8);
    border-radius: 5px;
    bottom: 26px;
    color: #fff;
    content: 'Click to enlarge';
    left: 20%;
    padding: 5px 15px;
    position: absolute;
    z-index: 98;
    width: 220px;
}
</style>

<?php add_thickbox(); ?>
<div id="emd-about" class="wrap about-wrap">
<div id="emd-header" style="padding:10px 0" class="wp-clearfix">
<div style="float:right"><img src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/kcenter-logo-250x150.gif"; ?>"></div>
<div style="margin: .2em 200px 0 0;padding: 0;color: #32373c;line-height: 1.2em;font-size: 2.8em;font-weight: 400;">
<?php printf(__('Welcome to Knowledge Center Community %s', 'knowledge-center') , $display_version); ?>
</div>

<p class="about-text">
<?php printf(__("Let's get started with Knowledge Center Community", 'knowledge-center') , $display_version); ?>
</p>
<div style="display: inline-block;"><a style="height: 50px; background:#ff8484;padding:10px 12px;color:#ffffff;text-align: center;font-weight: bold;line-height: 50px; font-family: Arial;border-radius: 6px; text-decoration: none;" href="https://emdplugins.com/plugin-pricing/knowledge-center-wordpress-plugin-pricing/?pk_campaign=knowledge-center-upgradebtn&amp;pk_kwd=knowledge-center-resources"><?php printf(__('Upgrade Now', 'knowledge-center') , $display_version); ?></a></div>
<div style="display: inline-block;margin-bottom: 20px;"><a style="height: 50px; background:#f0ad4e;padding:10px 12px;color:#ffffff;text-align: center;font-weight: bold;line-height: 50px; font-family: Arial;border-radius: 6px; text-decoration: none;" href="https://kcenter-pro.emdplugins.com//?pk_campaign=knowledge-center-buybtn&amp;pk_kwd=knowledge-center-resources"><?php printf(__('Visit Pro Demo Site', 'knowledge-center') , $display_version); ?></a></div>
<?php
	$tabs['getting-started'] = __('Getting Started', 'knowledge-center');
	$tabs['release-notes'] = __('Release Notes', 'knowledge-center');
	$tabs['resources'] = __('Resources', 'knowledge-center');
	$tabs['features'] = __('Features', 'knowledge-center');
	$active_tab = isset($_GET['tab']) ? sanitize_text_field($_GET['tab']) : 'getting-started';
	echo '<h2 class="nav-tab-wrapper wp-clearfix">';
	foreach ($tabs as $ktab => $mytab) {
		$tab_url[$ktab] = esc_url(add_query_arg(array(
			'tab' => $ktab
		)));
		$active = "";
		if ($active_tab == $ktab) {
			$active = "nav-tab-active";
		}
		echo '<a href="' . esc_url($tab_url[$ktab]) . '" class="nav-tab ' . esc_attr($active) . '" id="nav-' . esc_attr($ktab) . '">' . esc_html($mytab) . '</a>';
	}
	echo '</h2>';
?>
<?php echo '<div class="tab-content" id="tab-getting-started"';
	if ("getting-started" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<div style="height:25px" id="rtop"></div><div class="toc"><h3 style="color:#0073AA;text-align:left;">Quickstart</h3><ul><li><a href="#gs-sec-268">Live Demo Site</a></li>
<li><a href="#gs-sec-270">Need Help?</a></li>
<li><a href="#gs-sec-271">Learn More</a></li>
<li><a href="#gs-sec-269">Installation, Configuration & Customization Service</a></li>
<li><a href="#gs-sec-100">Knowledge Center Community Introduction</a></li>
<li><a href="#gs-sec-102">EMD CSV Import Export Extension helps you get your data in and out of WordPress quickly, saving you ton of time</a></li>
<li><a href="#gs-sec-101">EMD Advanced Filters and Columns Extension for finding what's important faster</a></li>
<li><a href="#gs-sec-119">Knowledge Center Pro - Powerful Knowledge Base solution with advanced predictive search and integrated user rating</a></li>
<li><a href="#gs-sec-120">Knowledge Center Enterprise - All-in-one, powerful knowledge base solution with advanced predictive omnisearch, multi-view capabilities and more</a></li>
</ul></div><div class="quote">
<p class="about-description">The secret of getting ahead is getting started - Mark Twain</p>
</div>
<div id="gs-sec-268"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Live Demo Site</div><div class="changelog emd-section getting-started-268" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>Feel free to check out our <a target="_blank" href="https://kcentercom.emdplugins.com//?pk_campaign=knowledge-center-gettingstarted&pk_kwd=knowledge-center-livedemo">live demo site</a> to learn how to use Knowledge Center Community starter edition. The demo site will always have the latest version installed.</p>
<p>You can also use the demo site to identify possible issues. If the same issue exists in the demo site, open a support ticket and we will fix it. If a Knowledge Center Community feature is not functioning or displayed correctly in your site but looks and works properly in the demo site, it means the theme or a third party plugin or one or more configuration parameters of your site is causing the issue.</p>
<p>If you'd like us to identify and fix the issues specific to your site, purchase a work order to get started.</p>
<p><a target="_blank" style="
    padding: 16px;
    background: coral;
    border: 1px solid lightgray;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    margin: 10px 0;
    display: inline-block;" href="https://emdplugins.com/expert-service-pricing/?pk_campaign=knowledge-center-gettingstarted&pk_kwd=knowledge-center-livedemo">Purchase Work Order</a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-270"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Need Help?</div><div class="changelog emd-section getting-started-270" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>There are many resources available in case you need help:</p>
<ul>
<li>Search our <a target="_blank" href="https://emdplugins.com/support">knowledge base</a></li>
<li><a href="https://emdplugins.com/kb_tags/knowledge-center" target="_blank">Browse our Knowledge Center Community articles</a></li>
<li><a href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation" target="_blank">Check out Knowledge Center Community documentation for step by step instructions.</a></li>
<li><a href="https://emdplugins.com/emdplugins-support-introduction/" target="_blank">Open a support ticket if you still could not find the answer to your question</a></li>
</ul>
<p>Please read <a href="https://emdplugins.com/questions/what-to-write-on-a-support-ticket-related-to-a-technical-issue/" target="_blank">"What to write to report a technical issue"</a> before submitting a support ticket.</p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-271"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Learn More</div><div class="changelog emd-section getting-started-271" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>The following articles provide step by step instructions on various concepts covered in Knowledge Center Community.</p>
<ul><li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article316">Concepts</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article456">Quick Start</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article317">Working with Panels</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article318">Widgets</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article319">Standards</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article320">Administration</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article459">Creating Shortcodes</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article322">Screen Options</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article321">Localization(l10n)</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article460">Customizations</a>
</li>
<li>
<a target="_blank" href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation/#article323">Glossary</a>
</li></ul>
</div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-269"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Installation, Configuration & Customization Service</div><div class="changelog emd-section getting-started-269" style="margin:0;background-color:white;padding:10px"><div id="gallery"></div><div class="sec-desc"><p>Get the peace of mind that comes from having Knowledge Center Community properly installed, configured or customized by eMarket Design.</p>
<p>Being the developer of Knowledge Center Community, we understand how to deliver the best value, mitigate risks and get the software ready for you to use quickly.</p>
<p>Our service includes:</p>
<ul>
<li>Professional installation by eMarket Design experts.</li>
<li>Configuration to meet your specific needs</li>
<li>Installation completed quickly and according to best practice</li>
<li>Knowledge of Knowledge Center Community best practices transferred to your team</li>
</ul>
<p>Pricing of the service is based on the complexity of level of effort, required skills or expertise. To determine the estimated price and duration of this service, and for more information about related services, purchase a work order.  
<p><a target="_blank" style="
    padding: 16px;
    background: coral;
    border: 1px solid lightgray;
    border-radius: 12px;
    text-decoration: none;
    color: white;
    margin: 10px 0;
    display: inline-block;" href="https://emdplugins.com/expert-service-pricing/?pk_campaign=knowledge-center-gettingstarted&pk_kwd=knowledge-center-livedemo">Purchase Work Order</a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-100"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Knowledge Center Community Introduction</div><div class="changelog emd-section getting-started-100" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="5gMaLdkDzwQ" data-ratio="16:9">loading...</div><div class="sec-desc"><p>Watch Knowledge Center Community introduction video to learn about the plugin features and configuration.</p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-102"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">EMD CSV Import Export Extension helps you get your data in and out of WordPress quickly, saving you ton of time</div><div class="changelog emd-section getting-started-102" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="tJDQbU3jS0c" data-ratio="16:9">loading...</div><div class="sec-desc"><p>EMD CSV Import Export Extension helps bulk import, export, update entries from/to CSV files. You can also reset(delete) all data and start over again without modifying database. The export feature is also great for backups and archiving old or obsolete data.</p>
<p><a href="https://emdplugins.com/plugin-features/knowledge-center-importexport-addon/?pk_campaign=emdimpexp-buybtn&pk_kwd=knowledge-center-resources"><img style="width: 154px;" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></p></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-101"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">EMD Advanced Filters and Columns Extension for finding what's important faster</div><div class="changelog emd-section getting-started-101" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="JDIHIibWyR0" data-ratio="16:9">loading...</div><div class="sec-desc"><p>EMD Advanced Filters and Columns Extension for Knowledge Center Community edition helps you:</p><ul><li>Filter entries quickly to find what you're looking for</li><li>Save your frequently used filters so you do not need to create them again</li><li>Sort entry columns to see what's important faster</li><li>Change the display order of columns </li>
<li>Enable or disable columns for better and cleaner look </li><li>Export search results to PDF or CSV for custom reporting</li></ul><div style="margin:25px"><a href="https://emdplugins.com/plugin-features/knowledge-center-smart-search-and-columns-addon/?pk_campaign=emd-afc-buybtn&pk_kwd=knowledge-center-resources"><img style="width: 154px;" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-119"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Knowledge Center Pro - Powerful Knowledge Base solution with advanced predictive search and integrated user rating</div><div class="changelog emd-section getting-started-119" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="6uKd0WmQGU0" data-ratio="16:9">loading...</div><div class="sec-desc"><p>Provides an easy to use and access, responsive, centralized repository of knowledge base entries with advanced predictive search.</p>
<div style="margin:25px"><a href="https://emdplugins.com/plugins/knowledge-center-wordpress-plugin/?pk_campaign=kcenter-pro-buybtn&pk_kwd=knowledge-center-resources"><img style="width: 154px;" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px"><div id="gs-sec-120"></div><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Knowledge Center Enterprise - All-in-one, powerful knowledge base solution with advanced predictive omnisearch, multi-view capabilities and more</div><div class="changelog emd-section getting-started-120" style="margin:0;background-color:white;padding:10px"><div class="emd-yt" data-youtube-id="BKOEUvWSITM" data-ratio="16:9">loading...</div><div class="sec-desc"><p>Most advanced and fully featured knowledge base solution ever built for WordPress. Unleash the power of self-service community with relevant, accurate, and fast information delivery reducing support costs and increasing customer satisfaction.</p>
<p><a href="https://emdplugins.com/plugins/knowledge-center-wordpress-plugin/?pk_campaign=kcenter-ent-buybtn&pk_kwd=knowledge-center-resources" target="_blank">Learn how to create a self-service community using Knowledge Center Enterprise plugin</a></p>
<div style="margin:25px"><a href="https://emdplugins.com/plugins/knowledge-center-enterprise/?pk_campaign=kcenter-ent-buybtn&pk_kwd=knowledge-center-resources"><img style="width: 154px;" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/button_buy-now.png"; ?>"></a></div></div></div><div style="margin-top:15px"><a href="#rtop" class="top">Go to top</a></div><hr style="margin-top:40px">

<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-release-notes"';
	if ("release-notes" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<p class="about-description">This page lists the release notes from every production version of Knowledge Center Community.</p>


<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.8 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1467" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
XSS issues in the WordPress admin area</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1466" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
tested with WP 6.2</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.7.2 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1288" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
tested with WP 5.7</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.7.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1224" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added version numbers to js and CSS files for caching purposes</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1223" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates to translation strings and libraries</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.7.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1097" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates and improvements to libraries</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1096" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added previous and next buttons for the edit screens of panels</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.6.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1039" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Emd templates</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-1038" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
updates and improvements to libraries</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.5.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-947" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
Session cleanup workflow by creating a custom table to process records.</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-946" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
XSS related issues</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-945" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Cleaned up unnecessary code and optimized the library file content.</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.4.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-893" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
misc. library updates for better compatibility and stability</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.4.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-854" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Emd templating system to match modern web standards</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-853" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Created a new shortcode page which displays all available shortcodes. You can access this page under the plugin settings.</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.3.2 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-767" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Changed the text domain so that plugin can be translated to other languages in wordpress.org</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.3.1 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-766" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
misc. library updates for better compatibility and stability</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.3.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-581" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
library updates</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-580" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Ability to change emd templating system container type - fixed or full width</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.2.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-345" style="margin:0">
<h3 style="font-size:18px;" class="tweak"><div  style="font-size:110%;color:#33b5e5"><span class="dashicons dashicons-admin-settings"></span> TWEAK</div>
Updated codemirror libraries for custom CSS and JS options in plugin settings page</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-344" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
wpautop issue with br tags</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-343" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added container type field in the plugin settings</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-342" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added custom JavaScript option in plugin settings under Tools tab</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.1.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-236" style="margin:0">
<h3 style="font-size:18px;" class="fix"><div  style="font-size:110%;color:#c71585"><span class="dashicons dashicons-admin-tools"></span> FIX</div>
PHP 7 compatibility</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-235" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Configured to work with EMD Advanced Filters and Columns Extension</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-234" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Configured to work with EMD CSV Import Export Extension for bulk import/export</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<h3 style="font-size: 18px;font-weight:700;color: white;background: #708090;padding:5px 10px;width:155px;border: 2px solid #fff;border-radius:4px;text-align:center">2.0.0 changes</h3>
<div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-183" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Set custom CSS rules for all plugin pages including plugin shortcodes</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-182" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Display any side bar widget on plugin pages using EMD Widget Area</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-181" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Display or hide any custom field</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-180" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Hide the page navigation links on the frontend for archive posts</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-179" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Hide the previous and next post links on the frontend for single posts</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-178" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Set the page template of any entity, taxonomy and/or archive page to sidebar on left, sidebar on right or no sidebar (full width)</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-177" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Set slug of any entity and/or archive base slug</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-176" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Enable or disable all fields, taxonomies and relationships from backend and/or frontend</h3>
<div ></a></div></div></div><hr style="margin:30px 0"><div class="wp-clearfix"><div class="changelog emd-section whats-new whats-new-96" style="margin:0">
<h3 style="font-size:18px;" class="new"><div style="font-size:110%;color:#00C851"><span class="dashicons dashicons-megaphone"></span> NEW</div>
Added ability to customize plugin from the settings</h3>
<div ></a></div></div></div><hr style="margin:30px 0">
<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-resources"';
	if ("resources" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">Extensive documentation is available</div><div class="emd-section changelog resources resources-99" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-99"></div><div id="gallery" class="wp-clearfix"></div><div class="sec-desc"><a href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation">Knowledge Center Community Documentation</a></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px"><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">How to customize Knowledge Center Community</div><div class="emd-section changelog resources resources-104" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-104"></div><div class="emd-yt" data-youtube-id="4wcFcIfHhPA" data-ratio="16:9">loading...</div><div class="sec-desc"><p><strong><span class="dashicons dashicons-arrow-up-alt"></span> Watch the customization video to familiarize yourself with the customization options. </strong>. The video shows one of our plugins as an example. The concepts are the same and all our plugins have the same settings.</p>
<p>Knowledge Center Community is designed and developed using <a href="https://wpappstudio.com">WP App Studio (WPAS) Professional WordPress Development platform</a>. All WPAS plugins come with extensive customization options from plugin settings without changing theme template files. Some of the customization options are listed below:</p>
<ul>
	<li>Enable or disable all fields, taxonomies and relationships from backend and/or frontend</li>
        <li>Use the default EMD or theme templating system</li>
	<li>Set slug of any entity and/or archive base slug</li>
	<li>Set the page template of any entity, taxonomy and/or archive page to sidebar on left, sidebar on right or no sidebar (full width)</li>
	<li>Hide the previous and next post links on the frontend for single posts</li>
	<li>Hide the page navigation links on the frontend for archive posts</li>
	<li>Display or hide any custom field</li>
	<li>Display any sidebar widget on plugin pages using EMD Widget Area</li>
	<li>Set custom CSS rules for all plugin pages including plugin shortcodes</li>
</ul>
<div class="quote">
<p>If your customization needs are more complex, you’re unfamiliar with code/templates and resolving potential conflicts, we strongly suggest you to <a href="https://emdplugins.com/open-a-support-ticket/?pk_campaign=knowledge-center-hireme-custom&ticket_topic=pre-sales-questions">hire us</a>, we will get your site up and running in no time.
</p>
</div></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px"><div style="color:white;background:#0000003b;padding:5px 10px;font-size: 1.4em;font-weight: 600;">How to resolve theme related issues</div><div class="emd-section changelog resources resources-103" style="margin:0;background-color:white;padding:10px"><div style="height:40px" id="gs-sec-103"></div><div id="gallery" class="wp-clearfix"><div class="sec-img gallery-item"><a class="thickbox tooltip" rel="gallery-103" href="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/emd_templating_system.png"; ?>"><img src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/emd_templating_system.png"; ?>"></a></div></div><div class="sec-desc"><p>If your theme is not coded based on WordPress theme coding standards, does have an unorthodox markup or its style.css is messing up how Knowledge Center Community pages look and feel, you will see some unusual changes on your site such as sidebars not getting displayed where they are supposed to or random text getting displayed on headers etc. after plugin activation.</p>
<p>The good news is Knowledge Center Community plugin is designed to minimize theme related issues by providing two distinct templating systems:</p>
<ul>
<li>The EMD templating system is the default templating system where the plugin uses its own templates for plugin pages.</li>
<li>The theme templating system where Knowledge Center Community uses theme templates for plugin pages.</li>
</ul>
<p>The EMD templating system is the recommended option. If the EMD templating system does not work for you, you need to check "Disable EMD Templating System" option at Settings > Tools tab and switch to theme based templating system.</p>
<p>Please keep in mind that when you disable EMD templating system, you loose the flexibility of modifying plugin pages without changing theme template files.</p>
<p>If none of the provided options works for you, you may still fix theme related conflicts following the steps in <a href="https://docs.emdplugins.com/docs/knowledge-center-community-documentation">Knowledge Center Community Documentation - Resolving theme related conflicts section.</a></p>

<div class="quote">
<p>If you’re unfamiliar with code/templates and resolving potential conflicts, <a href="https://emdplugins.com/open-a-support-ticket/?pk_campaign=raq-hireme&ticket_topic=pre-sales-questions"> do yourself a favor and hire us</a>. Sometimes the cost of hiring someone else to fix things is far less than doing it yourself. We will get your site up and running in no time.</p>
</div></div></div><div style="margin-top:15px"><a href="#ptop" class="top">Go to top</a></div><hr style="margin-top:40px">
<?php echo '</div>'; ?>
<?php echo '<div class="tab-content" id="tab-features"';
	if ("features" != $active_tab) {
		echo 'style="display:none;"';
	}
	echo '>';
?>
<h3>Reduce support costs and increase customer satisfaction</h3>
<p>Explore the full list of features available in the the latest version of Knowledge Center. Click on a feature title to learn more.</p>
<table class="widefat features striped form-table" style="width:auto;font-size:16px">
<tr><td><a href="https://emdplugins.com/?p=10465&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/comments.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10465&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Powerful custom commenting system supporting private comments, configurable file uploads, sorting and more.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10464&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/responsive.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10464&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Allow access to your knowledge base from any device.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=10463&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/central-location.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10463&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Centralize your knowledge base content to help users find information faster.</a></td><td></td></tr>
<tr><td><a href="https://emdplugins.com/?p=12404&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/dashboard.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=12404&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Powerful knowledge base dashboard  to get instant insight.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=11726&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/user_roles.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=11726&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Awesome looking support agent pages detailing content contributions - agent info displayed as author box under each knowledge base content.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=11725&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/authors.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=11725&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Let support agents do more with easy role enhancements from plugin settings. </a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10620&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/dd.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10620&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Simply drag and drop knowledge base articles and everything else to  set display order.</a></td><td> - Premium feature (included in both Pro and Enterprise)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10479&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/attachment.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10479&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Attach files to articles for users to download.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10621&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/revision.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10621&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Keep track of revisions to your content with ease.</a></td><td> - Premium feature (included in both Pro and Enterprise)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10478&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/brush-pencil.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10478&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Create custom fields to your knowledge base content to provide additional information.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10619&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/shop.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10619&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Easy ways to organize your knowledge base content.</a></td><td> - Premium feature included in Starter edition but Pro and Enterprise have more powerful features. Enterprise is the best.)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10474&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/rgb.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10474&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Create and display related knowledge base content.</a></td><td> - Premium feature (Included in both Pro and Enterprise. Enterprise has more powerful features.)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10618&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/widgets.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10618&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Display recent and featured knowledge base content with widgets.</a></td><td> - Premium feature included in Starter edition but Pro and Enterprise have more powerful features. Enterprise is the best.)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10477&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/social-share.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10477&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Easy social sharing of knowledge base articles with a simple click.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10475&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/heart.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10475&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Powerful knowledge base content rating system for easy user engagement.</a></td><td> - Premium feature (Included in both Pro and Enterprise. Enterprise has more powerful features.)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10622&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/media-embeds.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10622&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Store video, audio, slides, tweets and make them searchable.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10473&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/mix-match.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10473&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Create awesome looking views with ease.</a></td><td> - Premium feature (included in both Pro and Enterprise)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10468&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/settings.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10468&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Customize your knowledge base exactly matching your brand. </a></td><td> - Premium feature included in Starter edition but Pro and Enterprise have more powerful features. Enterprise is the best.)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10480&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/content.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10480&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Create great looking guides combining multiple knowledge base articles.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10623&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/multiple-view.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10623&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Beautiful knowledge base content views. </a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10470&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/omniseach.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10470&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Instant answers with omnisearch - allow searches on any knowledge base content from a single location.</a></td><td> - Premium feature (included in both Pro and Enterprise)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10476&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/lightbulb.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10476&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Display related images, audio, video, terms, tweets on knowledge base content pages.</a></td><td> - Premium feature (Included in Enterprise only)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10469&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/qanda.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10469&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Powerful Q&A and Glossary views to help users find information fast.</a></td><td> - Premium feature included in Starter edition. Pro and Enterprise have more powerful features)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10624&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/zoomin.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10624&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Smart search for any content including content ratings.</a></td><td> - Add-on (included both Pro and Enterprise)</td></tr>
<tr><td><a href="https://emdplugins.com/?p=10625&pk_campaign=knowledge-center-com&pk_kwd=getting-started"><img style="width:128px;height:auto" src="<?php echo KNOWLEDGE_CENTER_PLUGIN_URL . "assets/img/csv-impexp.png"; ?>"></a></td><td><a href="https://emdplugins.com/?p=10625&pk_campaign=knowledge-center-com&pk_kwd=getting-started">Powerful import, export and update from or to CSV for any knowledge base content.</a></td><td> - Add-on (included both Pro and Enterprise)</td></tr>
</table>
<?php echo '</div>'; ?>
<?php echo '</div>';
}