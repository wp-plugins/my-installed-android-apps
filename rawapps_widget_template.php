<?php

    $options=get_option("my_android_apps_widget");
    if (!is_array($options)) {
	    $options=array(
		    'title'=>'My Installed Android Apps',
		    'email'=> '',
		    'sort'=> 'name',
		    'limit'=> '10',
		    'show_description'=>'1',
		    'show_credit'=>'1',
		    'show_ratings'=>'1',
		    'show_noratings'=>'1',
		    'show_star'=>'1',
		    'show_downloads'=>'1'
		    );

	}
	
if($options['email'] == ''){
$options['email'] = 'Empty';
}
	

$ch = curl_init();
$site_url = "http://api.rawapps.com/api/rawapps_widget?format=json&source=market&type=day&lmt=".$options['limit']."&sort=".$options['sort']."&email=".$options['email'];
curl_setopt($ch, CURLOPT_URL,$site_url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
$result=curl_exec ($ch);
curl_close ($ch);

$json = json_decode($result);
$apps = $json->apps;
my_android_apps_widget_style();


if(count($apps) == 0){
//echo "<div><br><a href='http://www.rawapps.com/register' title='Register on RawApps.com'>Sign Up</a> on RawApps.com and Sync your android device.</div><br/>"   ;

echo "<div><br>
Ooops! It looks like you haven't synced your phone with RawApps yet.
In order to display your list of installed apps you'll first need to
sync your device using <a href='http://www.rawapps.com/about-us/rawapps-mobile/' title='Register on RawApps.com'>the free RawApps Mobile application</a>. Once
you've completed that process, please enter the same email address you
used to registered your account with RawApps, in the widget setting's
'Email' field.</div>";


echo "<div><br>
For detailed instructions on using this widget please visit:
<a href='http://www.rawapps.com/wp-widgets' title='Widgets on RawApps.com'>http://www.rawapps.com/wp-widgets</a></div>";


echo "<div><br>
Download the RawApp Mobile Syc App for Android:
<a href='http://www.rawapps.com/about-us/rawapps-mobile/' title='Widgets on RawApps.com'>http://www.rawapps.com/about-us/rawapps-mobile/</a></div>";








}
//echo $site_url;

foreach($apps as $app){


echo "<li class='item-li'>";
echo "<div>";
echo "<a href='http://www.rawapps.com/".$app->andro_app->post_id."' title='".$app->andro_app->name." for android'><img src='http://www.rawapps.com/wp-content/android/".$app->andro_app->art."' class ='rawapps-avatar' ></a>";

echo "<div class ='item-space'>";
echo "<div class='item-name'><a href='http://www.rawapps.com/".$app->andro_app->post_id."' style ='cursor:hand;' title='".$app->andro_app->name." for android'><label for='".$app->andro_app->name."' class='rawapps-text'>".$app->andro_app->name."</label></a></div>";
echo "<div class='item-creator'><label for='".$app->andro_app->seller."' class = 'rawapps-small-text' > by ".$app->andro_app->seller."</label></div>";
echo "<div class='item-creator rawapps-small-text'>In <a href='http://www.rawapps.com/category/android/android-".str_replace(' ','',str_replace('&','',strtolower($app->andro_app->category)))."' style ='cursor:hand;' title='".$app->andro_app->category." apps for android'><label for='".$app->andro_app->category."' class='rawapps-text'>".$app->andro_app->category."</label></a></div>";


if ($options['show_downloads']){
echo "<div class='item-downloads'><label for='".$app->andro_app->seller."' class = 'rawapps-text' > ".str_replace('>','',$app->andro_app->current_downloadContext)." Downloads</label></div>";
}

if ($options['show_ratings']){
	echo "<div class='item-ratings rawapps-small-text'>";
	echo "<label for='".$app->andro_app->seller."' class = 'rawapps-small-text' > ( ".(intval(floatval($app->andro_app->current_rating)*100)/100)." / 5.0 </label>";
		if ($options['show_noratings']){
			echo "<label for='".$app->andro_app->seller."' class = 'rawapps-small-text' > - ".$app->andro_app->current_ratingscount."</label>";
		}
	echo " Ratings )";

	echo "</div>";

}

if ($options['show_star']){
	echo '<div style="padding-top:5px;" class="item-ratings item-ratings widgetstars_text"><div class="widgetstars_out"><div class="widgetstars" style="width:'.(round($app->andro_app->current_rating) * 16).'px;">&nbsp;</div></div></div>';
	}


echo "</div>";
echo "<div style='clear:both;'></div>";

if ($options['show_description']){
        echo "<div class='item-space2'> </div>";
        echo "<div class='item-description rawapps-small-text'>".substr($app->andro_app->post_content,0,195)."<a  href='http://www.rawapps.com/".$app->andro_app->post_id."' title='".$app->andro_app->name." for android'>... Read more</a></div>";
}


echo "</div>";
echo "</li>";


}

if ($options['show_credit']){
	echo  "<div style='padding-bottom:10px' > <label class= 'rawapps-text'> <a  href='http://www.rawapps.com/' title='My Android Apps'>My Android Apps</a>  Powered By RawApps.com</label></div>";
}

function my_android_apps_widget_style() {
?>
<style type="text/css">
	.item-space{
           margin-left:38px;
           line-height:13px;
           padding-bottom:10px;
           padding-left:10px;
	}
	.item-space2{}
	.item-name{}
	.item-creator{}
	.item-downloads{}
	.item-ratings{}
	.item-description{
		padding-left:10px;
                padding-bottom:20px;
	}
	.rawapps-avatar{
		float:left;
		height:40px;
		padding:0;
		vertical-align:top;
		width:40px;
		padding-bottom:5px
	}
	.rawapps-text{
		font-size:11px;
        	cursor:pointer;
        }
	.rawapps-small-text{
		color:#777777;
		font-size:11px;
        }
	.item-li{
		list-style-type:none;
	}
       .widgetstars{
       		height:16px;
       		background-image:url(http://www.rawapps.com/wp-content/plugins/gd-star-rating/stars/oxygen/stars16.png);
       		background-position:0 16px;
       }
       .widgetstars_text{
       font-size:11px;
       color:#777;
       }
       .widgetstars_out{
		/*display:inline-block;*/
		margin-left:0px;height:16px;overflow:hidden;
		background-image:url(http://www.rawapps.com/wp-content/plugins/gd-star-rating/stars/oxygen/stars16.png);
		background-position:0 0px;width:80px;
		background-color:transparent;margin-right:5px;
       }
</style>
<?php
}
?>


