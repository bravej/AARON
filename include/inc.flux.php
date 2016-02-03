<?php

	function RSS_Display($url)
	{
		$urls = array();
		libxml_use_internal_errors (true);
		$rss = simplexml_load_file($url);
		if ($rss)
		{
			foreach ($rss->channel->item as $item) { 
				$chaine = '<h2 style="display: inline">' . $item->title . '</h2> </br><a target=_blank href = '.$item->link.'>'.$item->link.'</a> ' . '</br> '. $item->description.'</br></br>';
					array_push($urls, $chaine);
			} 
			return $urls;
		}	
		else
		{

			$urls[0] = 'erreur';

			return $urls;
		}// on return une valeur pour pouvoir la traiter dans flux.php
	}

?>
