<?php
/**
 * Name: Resolution Limiter
 * Author: Shish <webmaster@shishnet.org>
 * Link: http://trac.shishnet.org/shimmie2/
 * License: GPLv2
 * Description: Allows the admin to set min / max image dimentions
 */
class ResolutionLimit extends Extension {
	public function receive_event($event) {
		if(is_a($event, 'UploadingImageEvent')) {
			global $config;
			$min_w = $config->get_int("upload_min_width", -1);
			$min_h = $config->get_int("upload_min_height", -1);
			$max_w = $config->get_int("upload_max_width", -1);
			$max_h = $config->get_int("upload_max_height", -1);
			
			$image = $event->image;

			if($min_w > 0 && $image->width < $min_w) $event->veto("Image too small");
			if($min_h > 0 && $image->height < $min_w) $event->veto("Image too small");
			if($max_w > 0 && $image->width > $min_w) $event->veto("Image too large");
			if($max_h > 0 && $image->height > $min_w) $event->veto("Image too large");
		}
		if(is_a($event, 'SetupBuildingEvent')) {
			$sb = new SetupBlock("Resolution Limits");

			$sb->add_label("Min ");
			$sb->add_int_option("upload_min_width");
			$sb->add_label(" x ");
			$sb->add_int_option("upload_min_height");
			$sb->add_label(" px");

			$sb->add_label("<br>Max ");
			$sb->add_int_option("upload_max_width");
			$sb->add_label(" x ");
			$sb->add_int_option("upload_max_height");
			$sb->add_label(" px");
			
			$sb->add_label("<br>(-1 for no limit)");

			$event->panel->add_block($sb);
		}
	}
}
add_event_listener(new ResolutionLimit(), 40); // early, to veto UIE
?>
