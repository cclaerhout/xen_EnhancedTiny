<?php

class Sedo_EnhancedTiny_Listener_Preloader
{
	public static function preloader($templateName, array &$params, XenForo_Template_Abstract $template)
	{
		if($templateName == 'editor')
		{
			$template->preloadTemplate('sedo_enhanced_tiny');
		}
	}
}