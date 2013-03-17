<?php
class Sedo_EnhancedTiny_Listener_Templates
{
	public static function listenhooks($hookName, &$contents, array $hookParams, XenForo_Template_Abstract $template)
	{
		switch ($hookName) 
		{
		case 'editor_js_setup':
			$options = XenForo_Application::get('options');
			
			//Phrases Management
			$phrases = '';
			
			if($options->enhancedtiny_wordcount)
			{	
				if($options->enhancedtiny_wordcount_mode == 'cust')
				{
					$phrase_wordcount = new XenForo_Phrase('Sedo_EnhancedTiny_unit_custom');
				}
				elseif(in_array($options->enhancedtiny_wordcount_mode, array('char', 'charwp')))
				{
					$phrase_wordcount = new XenForo_Phrase('Sedo_EnhancedTiny_unit_Characters');
				}
				else
				{
					$phrase_wordcount = new XenForo_Phrase('Sedo_EnhancedTiny_Words');
				}

				$phrases .= "\n$1wordcount_phrase: \"" . addslashes($phrase_wordcount) . '",';
			}
			
			if($options->enhancedtiny_fullscreen)
			{
				$phrases .= "$1fullscreen_desc: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_fullscreen')) . '",';			
			}

			if($options->enhancedtiny_autosave)
			{
				$phrases .= "$1restoredraft_desc: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_restoredraft')) . '",';
				$phrases .= "$1restoredraft_warning: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_restoredraft_warning')) . '",';

				if($options->enhancedtiny_autosave_ask_before_unload)
				{
					$phrases .= "$1autosave_unload_msg: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_autosave_unload_msg')) . '",';
				}
				
				if($options->enhancedtiny_autosave_display_in_statusbar)
				{
					$phrases .= "$1autosave_statusbar_msg: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_autosave_statusbar_msg')) . '",';				
				}
			}

			if($options->enhancedtiny_paste)
			{
				$phrases .= "$1selectall_desc: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_selectall_desc')) . '",';
				$phrases .= "$1paste_text_desc: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_paste_text_desc')) . '",';
				$phrases .= "$1paste_word_desc: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_paste_word_desc')) . '",';
				$phrases .= "$1plaintext_mode_sticky: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_plaintext_mode_sticky')) . '",';
				$phrases .= "$1plaintext_mode: \"" . addslashes(new XenForo_Phrase('Sedo_EnhancedTiny_plaintext_mode')) . '",';
			}			

			
				/*Activation*/
				if(!empty($phrases))
				{
					$contents = preg_replace("#(\s*?)backcolor_desc:.+#i", '$0' . $phrases, $contents);
				}

			//Plugins Managements
			$plugins = '';
			
			if($options->enhancedtiny_wordcount)
			{			
				$plugins .= 'wordcount,';
			}

			if($options->enhancedtiny_fullscreen)
			{
				$plugins .= 'fullscreen,';
			}
			
			if($options->enhancedtiny_autosave)
			{
				$plugins .= 'autosave,';			
			}

			if($options->enhancedtiny_paste)
			{
				$plugins .= 'paste,';
			}			


				/*Activation*/			
				if(!empty($plugins))
				{
					$contents = preg_replace("#var\s+?plugins(?:\s+?)?=(?:\s+?)?'#i", '$0' . $plugins, $contents);
				}

			//Add template "sedo_enhanced_tiny" (for extra plugins css for example)
        		$mergedParams = array_merge($template->getParams(), $hookParams);
        		$contents .= $template->create('sedo_enhanced_tiny', $mergedParams);

			break;
			
		case 'editor_tinymce_init':
			$options = XenForo_Application::get('options');	
				
			//Params Managements
			$params = '';

			if($options->enhancedtiny_wordcount)
			{
				$params .= "$1wordcount_align: '" . $options->enhancedtiny_wordcount_align . "',";
				$params .= "$1wordcount_mode: '" . $options->enhancedtiny_wordcount_mode . "',";
				
				if($options->enhancedtiny_wordcount_mode == 'cust')
				{
					$params .= "$1wordcount_countregex: " . addslashes($options->enhancedtiny_wordcount_custmod_matchregex) . ",";
					$params .= "$1wordcount_cleanregex: " . addslashes($options->enhancedtiny_wordcount_custmod_excluderegex) . ",";
				}
				
				if($options->enhancedtiny_wordcount_update_rate != 2000)
				{
					$params .= "$1wordcount_update_rate: " . $options->enhancedtiny_wordcount_update_rate . ",";
				}
				
				if($options->enhancedtiny_wordcount_update_on_delete)
				{				
					$params .= "$1wordcount_update_on_delete: true,";				
				}
			}
			
			if($options->enhancedtiny_autosave)
			{
				if($options->enhancedtiny_autosave_interval != 45)
				{
					$params .= "$1autosave_interval: '" . $options->enhancedtiny_autosave_interval . "s',";
				}
				
				if($options->enhancedtiny_autosave_minlength != 50)
				{
					$params .= "$1autosave_interval: " . $options->enhancedtiny_autosave_minlength . ",";
				}

				if($options->enhancedtiny_autosave_retention != 20)
				{
					$params .= "$1autosave_retention: '" . $options->enhancedtiny_autosave_retention . "m',";
				}
				
				if(!$options->enhancedtiny_autosave_ask_before_unload)
				{
					$params .= "$1autosave_ask_before_unload: false,";				
				}
				if($options->enhancedtiny_autosave_display_in_statusbar)
				{
					$params .= "$1autosave_display_in_statusbar: true,";				
				}				
			}

			if($options->enhancedtiny_paste)
			{
				if($options->enhancedtiny_paste_text_sticky)
				{
					$params .= "$1paste_text_sticky: true,";				
				}

				if($options->enhancedtiny_paste_text_sticky_default)
				{
					$params .= "$1paste_text_sticky_default: true,";				
				}
				
				if(!empty($options->enhancedtiny_paste_retain_style_properties))
				{
					$paste_retain_style_properties = self::cleanOutputOptions($options->enhancedtiny_paste_retain_style_properties);

					if($paste_retain_style_properties !== false)
					{
						$params .= "$1paste_retain_style_properties: \"$paste_retain_style_properties\",";
					}
				}

				if(!$options->enhancedtiny_paste_convert_middot_lists)
				{
					$params .= "$1paste_convert_middot_lists: false,";				
				}

				if(!$options->enhancedtiny_paste_remove_styles_if_webkit)
				{
					$params .= "$1paste_remove_styles_if_webkit: false,";				
				}								
			}

			//Params Managements: Toolbar Managements
			if($options->enhancedtiny_toolbar != 'top')
			{
				$params .= "$1theme_xenforo_toolbar_location: 'bottom',";				
			}
			
			if($options->enhancedtiny_toolbar_align != 'left')
			{
				$params .= "$1theme_xenforo_toolbar_align: '" . $options->enhancedtiny_toolbar_align . "',";				
			}
			
				/*Activation*/
				if(!empty($params))
				{
					$contents = preg_replace("#(\s+?)document_base_url(?:\s+?)?:.+,#i", "$0$params", $contents);
				}

			//Status Bar Management
			if($options->enhancedtiny_statusbar == 'bottom')
			{
				$statusbar = 'bottom';
			}
			elseif($options->enhancedtiny_statusbar == 'top')
			{
				$statusbar = 'top';
			}

				/*Activation*/	
				if(isset($statusbar))
				{
					$htmlpatch = '';
					if($options->enhancedtiny_statusbar_hidehtmlpath)
					{
						$htmlpatch = "$1theme_xenforo_path: false,";
					}
					
					
					$contents = preg_replace("#(\s+?)theme:(?:\s*?)?'xenforo',#i", "$0$1theme_xenforo_statusbar_location: '$statusbar',$htmlpatch", $contents);
				}

			break;
		}
	}

	public static function cleanOutputOptions($string, $explode_separator = ',', $rebuild_separator = ',')
	{
		$builder = explode($explode_separator, $string);
					
		if(!is_array($builder))
		{
			return false;
		}

		$output = '';
						
		$i = 0;
		foreach($builder as $item)
		{
			if(empty($item))
			{
				continue;
			}
			
			if($i == 0)
			{
				$output .= $item;
			}
			else
			{
				$output .= $rebuild_separator.$item;
			}
			
			$i++;
		}

		return $output;
	}
}
//Zend_Debug::dump($contents);