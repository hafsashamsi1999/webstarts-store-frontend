<?php

namespace App\Utility\Sites;

use App\Models\Sites;
use App\Models\Pages;
use App\Utility\Sites\Storage\CommonStorage;

class ViralLinkAdDeal {

	var $site = null;
	var $AdFileName = "adslider.js";
	var $AdFilePath = null;
	var $siteFolderPath = null;
	var $siteloaded = false;
	// To randomize the footer message
	var $random_footer = false; // Change this to turn on/off the random footer
	var $sHTML = '';
	var $keyword_array = array(
"<a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> Is The <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Best Website Builder</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build A Free Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build A Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build A Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build A Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Free Websites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Your Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Your Own Website For Free</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Build Your Own Websites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Business Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Business Website Builder</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheap Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheap Web Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheap Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheap Website Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheap Websites</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get The <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Cheapest Web Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Business Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Free Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Webpage</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create A Website For Free</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Free Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create My Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Web Sites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Webpage</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Your Own Free Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Your Own Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Your Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Create Your Own Website For Free</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating A Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating A Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating A Webpage</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating A Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating Webpage</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating Website</a>",
"Start <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Creating Your Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Dedicated Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Design Your Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Do It Yourself Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Register A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Domain</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Domain Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Domain With Free Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Easy To Use <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Drag And Drop Site Builder</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Easy To Use <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Drag And Drop Website Builder</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Easy Web Site Builder</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Use An <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Easy Website Builder</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free .Com Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Business Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain And Free Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain And Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain Host</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain Name</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain Names</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domain With Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Domains</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free File Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting And Domain</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting For Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting Websites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Hosting With Domain</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Image Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Personal Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Hosts</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Page</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Page Design</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Pages</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Site</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Site Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Web Sites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Build A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Webpage</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Build <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Webpages</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website And Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get A <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Builder</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Building</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Creator</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Host</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Hosts</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Maker</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website Making</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Website With Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Create <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Websites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Free Websites Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Freehosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Freewebhosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Get A Free Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Company</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> As Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Provider</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Service</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> For All Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Services</a>",
"Use <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> As Your <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Website</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How Do You Make A Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> ?",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How Do You Make Your Own Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a> ?",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Build A Web Page</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Build A Web Site</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Build A Website</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Build Your Own Website</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create A Web Page</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create A Web Site</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create A Webpage</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create A Website</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create Website</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Create Your Own Website</a> Using <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Free Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Web Page</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Web Site</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Webpage</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make A Website For Free</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make My Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">How To Make Your Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Free Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Web Page</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Web Site</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Webpage</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make A Website For Free</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Free Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make My Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Site</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Web Page</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Web Sites</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Free Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Web Page</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Web Site</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Webpage</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Own Website For Free</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Make Your Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Making A Web Page</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Making A Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Making Your Own Website</a> At <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Amazing <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Online Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Amazing <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Online Web Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Amazing <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Online Website Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Amazing <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Online Website Builders</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">PHP Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Builder Software</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Builders</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Creator</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free Web <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Site Maker</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Sitebuilder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Start A Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Builder Software</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Free Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Host</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Hosting Free</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Hosting Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Hosting Sites</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Builders</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Creation</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Creator</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Maker</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Page Software</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Site Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Site Builders</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Site Creation</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Web Site Creator</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webhost</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webhosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webpage Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webpage Creator</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webpage Maker</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Builder</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Builder Software</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Builders</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Building Tools</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Creation</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Creator</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Creator Software</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Free Hosting</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Hosting Free</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Maker</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Makers</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Website Making</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Get Free <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Webspace</a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"<a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Host Your Website </a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>",
"Start <a id=\"a_u0c0_linkAd\" href=\"http://www.webstarts.com\">Hosting Cheap Websites </a> With <a id=\"a_u0c0\" href=\"http://www.webstarts.com\">WebStarts.com</a>"
);
	/**
	 * Get the html for random keywords
	 * Created due to SEO issues with Google
	 * Uses keywords found in objects/keywords.php array
	 * Author: Tyler Jones
	 * Date: August 28, 2012
	 */
	function get_keyword_html()
	{
		if ($this->random_footer == true) {
			// Pulls in the keyword array $keyword_array
			$ka = $this->keyword_array;
			$count = count( $ka );
			// Get a random key
			$key = rand( 0, $count );

			return $ka[$key];
		} else {
			return "<a href='http://www.webstarts.com'>Create A Free Website With WebStarts.com</a>";
		}
	}

	/**
	 * Get the shtml
	 */
	function get_shtml()
	{
		$keyword_html = $this->get_keyword_html();
		$keyword_html = stripslashes( $keyword_html );

		$shtml = '<div id="d_u0c0_linkAd" style="height: 24px; padding-top:9px; Z-INDEX: 99999999999; POSITION: fixed; BOTTOM:0; LEFT:0; BACKGROUND-COLOR:#eee; width:100%; MIN-WIDTH:600px;">
					<script type="text/javascript" src="http://static.webstarts.com/library/jquery/jquery.min.js"></script>
					<script type="text/javascript" src="http://static.webstarts.com/library/tools/footerscript.js"></script>
					<!--<div id="d_u0c0_centerLinkAd" style="width:960px; margin:0 auto; position:relative;">-->
						<table style="position:absolute; top:5px; left:30px;">
							<tr>
								<td valign="middle"><img src="http://static.webstarts.com/library/images/footer-orb.png" /></td>
								<td valign="middle">
									<span style="FONT-SIZE: 10pt; FONT-FAMILY: Arial;">'.$keyword_html.'</span>
								</td>
							</tr>
						</table>
						<div id="d_u0c0_innerlinkAd" style="position:absolute; top:2px; right:15px;">
							<table>
								<tr>
									<td valign="middle"><script src="http://connect.facebook.net/en_US/all.js#xfbml=1"></script><fb:like href="http://www.facebook.com/WebStarts" send="false" layout="button_count" width="40" show_faces="false" font=""></fb:like></td>

									<td valign="middle"><a href="http://twitter.com/share" class="twitter-share-button" data-url="http://www.webstarts.com" data-text="Build a Free WebSite at" data-count="horizontal">Tweet</a><script type="text/javascript" src="http://platform.twitter.com/widgets.js"></script></td>

									<td valign="middle"><img id="x-remove" height="24px" width="24px" src="http://static.webstarts.com/library/images/x-close.png" style="cursor: hand; cursor: pointer;" /></td>
								</tr>
							</table>
						</div>
						<div id="d_u0c0_innerlinkAd" class="message-box" style="display:none; background-image:url(\'http://static.webstarts.com/library/images/chatbox.png\');  background-repeat:no-repeat; background-position:left top; height:95px; width:305px; padding:18px; position:absolute; top:-103px; right:-10px;">
							<span style="color:#666; font-family:Arial; font-size:13px;">
								Is this your website?  If so, you can prevent this footer from being displayed by upgrading your account.  <a href="http://www.webstarts.com/cadmin/dashboard/removeFooter.php?lts=removeFooter">Click here to upgrade now.</a>
							</span>
							<img id="x-close" height="20px" width="20px" style="position:absolute; cursor: hand; cursor: pointer; top:1px; right:28px;" src="http://static.webstarts.com/library/images/x-close.png" />
						</div>
					<!--</div>-->
				</div>';

		return $shtml;
	}


	function __construct(Sites $site){
		// Constructor code here
		$this->site = $site;
		$this->siteloaded = true;
		$this->siteFolderPath = $this->site->foldername;
		// Set sHTML!!!
		$this->sHTML = $this->get_shtml();
	}

	function ViralLinkAdDeal(Sites $site) {
		self::__construct($site);
	}

	function putViralLinkAd( $pagename, $siteFolderPath="" ) {

	}

	function putViralLinkAdInHTML($sHTML) {

	}

	function removeViralLinkAdDeal() {

		$pages = Pages::where(
						['siteid', $this->site->id],
						['external', '0'],
						['active', '<>', '2']
					)->get();

		foreach($pages as $page) {
			$this->removeViralLinkAd($page->name);
		}

		return true;
	}

	function removeViralLinkAd($pagename) {
		if (!$this->siteloaded) {
			return false;
		}

		$originalContent = $str_filecontent = $this->site->storage()->readPage($pagename);
		$str_filecontent = $this->replaceFooterCode($str_filecontent);

		if ($originalContent != $str_filecontent) {
			if (!empty($str_filecontent)) {
				$this->site->storage()->writePage($pagename, $str_filecontent);
			}
		}
	}

	function replaceFooterCode($str_filecontent='') {
		if (preg_match('%<div[^>]*(?:id[\s]*=["|\']?d_u0c0_linkAd["|\']?)[^>]*>[\s]*(?:</?script[^>]*>[\s]*)+<!--<div.*?<!--</div>-->[\s]*</div>%si', $str_filecontent)) {
			$str_filecontent = preg_replace('%<div[^>]*(?:id[\s]*=["|\']?d_u0c0_linkAd["|\']?)[^>]*>[\s]*(?:</?script[^>]*>[\s]*)+<!--<div.*?<!--</div>-->[\s]*</div>%si', '', $str_filecontent );
		} else {
			if (preg_match('%<div[^>]*(?:id[\s]*=["|\']?d_u0c0_linkAd["|\']?)[^>]*>.*?</div>%si', $str_filecontent)) {
				$str_filecontent = preg_replace('%<div[^>]*(?:id[\s]*=["|\']?d_u0c0_linkAd["|\']?)[^>]*>.*?</div>%si', '', $str_filecontent );
			} else {
				# Match attempt failed
			}
		}

		if (preg_match('%<script[^>]*(?:id[\s]*=["|\']?ViralAdScript["|\']?)[^>]*>[\s]*</script>%si', $str_filecontent)) {
			$str_filecontent = preg_replace('%<script[^>]*(?:id[\s]*=["|\']?ViralAdScript["|\']?)[^>]*>[\s]*</script>%si', '', $str_filecontent );
		}
		return $str_filecontent;
	}

	// This function runs on valid directory and not site object dependent
	function removeViralAdInDirectory($dir = '', $log_file='removefooter.log') {
		$adRemoved = false;
		$fileArray = array();
		$cs = new CommonStorage();
		$result = $cs->getFileList($dir,array("file"));
		if (is_array($result) && !empty($result))
		{
			if ( !$this->takeBackUp($dir, $log_file) ) {
				return false;
			}
			foreach($result as $f) {
				if(strpos($f, '.html') !== false) {
					$fileArray[] = $f;
				}
			}
			//if ($dh = opendir($dir))
			//{
				//while (($file = readdir($dh)) !== false)
				//{
					//if( filetype($dir."/".$file) == "file" && strpos($file, '.html') !== false)
						//$fileArray[] = $dir."/".$file;
				//}
				//closedir($dh);
			//}
		} else {
			_log("$dir is not a valid directory.", $log_file);
			return false;
		}

		foreach ($fileArray as $file) {
			$originalContent = $str_filecontent = $cs->readPage($file);

			$str_filecontent = $this->replaceFooterCode($str_filecontent);

			if ($originalContent != $str_filecontent) {
				if (!empty($str_filecontent)) {
					if ($cs->writePage($file, $str_filecontent) === false) {
						_log("File[$file] could not be written back.", $log_file);
					} else {
						$adRemoved = true;
					}
					//$this->site->putPageHTML($pagename,$str_filecontent);
				} else {
					_log("File[$file] is empty found.", $log_file);
				}
			}
		}

		// if there was no change in pages, remove the damn backup
		if ($adRemoved === false) {
			if ($cs->delete($dir."/htmlpages_withfooter.tar.gz")) {
				_log("Removing the backup file [$dir] FAILED.", $log_file);
			} else {
				_log("Removed backup [$dir], because no footer ad found.", $log_file);
			}
		} else {
			_log("Successfully removed ad", $log_file);
			_log("footer backup: [". $dir."/htmlpages_withfooter.tar.gz]", 'footer_backups.log');
		}
	}

	// This function will take all and only .html pages backup in the same directory location
	function takeBackUp($backuplocation='', $log_file='removefooter.log') {
		//$command = 'cd '.$backuplocation;
		//exec($command);
		//$tarCommand = "tar cfz ".
						//$backuplocation."/htmlpages_withfooter.tar.gz ".$backuplocation."/*.html";
		//$output = null;
		//$last_line	= system($tarCommand, $retval);
		$cs = new CommonStorage();
		$result = $cs->tar($backuplocation."/htmlpages_withfooter.tar.gz","cfz",$backuplocation."/*.html");
		if ($result) { // No output means, worked good otherwise something bad happened
			_log("Backup successfully taken for $backuplocation", $log_file);
			return true;
		} else {
			_log("Backup FAILED for $backuplocation", $log_file);
			return false;
		}
	}
}
?>
