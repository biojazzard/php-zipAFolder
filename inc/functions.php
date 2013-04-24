<?php
/**
 * php-zipAFolder 1.01 - 2013 twitter: @biojazzard |
 *
 * @packageTDS data/json 1.01
 * @subpackageScript
 * @categoryPHP
 * @author Alfredo Llanos
 * @link http://tallerdelsoho.es/
 */

include('config.php');

function js ($photoFolder, $mode = 'json') {
	//{image : 'slides/jpg/javier-riano-01.jpg', title : 'Javier Riaño', thumb : 'slides/thumbs/javier-riano-01.jpg', url : ''},
	if(file_exists(FILES_FOLDER.$photoFolder)) {
		$handle = opendir(FILES_FOLDER.$photoFolder);
	} else {
		$json_row = array ('image' => './slides/404.jpg',
							'title' => 'No Folder',
							'thumb' => './slides/404.jpg',
							'url'   => '');
		$json_data[0] = $json_row;
		return $json_data;
	}
	$jpgRep = array('.jpg','.JPG','.png','.PNG');
	$espRep = array('-','_');
	$preFixRep = str_replace('.', ' - ', FILES_FOLDER);

	$i=0;
	$json_data = array ();

	while (false !== ($topics = readdir($handle))) {
		if ($topics != '.' && $topics != '..' && $topics != '.DS_Store') {
			$topicArray[$i] = $topics;
			$topicsRep = str_replace($jpgRep, '', $topics);
			$topicsRep = str_replace($espRep, ' ', $topicsRep);
			$topicsRep = ucwords(substr($topicsRep, 3, strlen($topicsRep)));
			if ($i<=9) {
				$zero = '0';
			} else {
				$zero = '';			
			}

				switch ($mode) {
					case 'array':
						$json_row = FILES_FOLDER.$photoFolder.MOBILE_SUFFIX.'/'.$topics;
					break;
					case 'html':
						$json_row = array ('image' => FILES_FOLDER.$photoFolder.MOBILE_SUFFIX.'/'.$topics,
							'title' => $topicsRep,
							'thumb' => FILES_FOLDER.$photoFolder.THUMB_SUFFIX.'/'.$topics,
							'url'   => '');
					break;
					case 'json':
						$json_row = array ('image' => FILES_FOLDER.$photoFolder.'/'.$topics,
							'title' => $topicsRep,
							'thumb' => FILES_FOLDER.$photoFolder.THUMB_SUFFIX.'/'.$topics,
							'url'   => '');
					break;
					default:
						$json_row = array ('image' => FILES_FOLDER.$photoFolder.'/'.$topics,
							'title' => $topicsRep,
							'thumb' => FILES_FOLDER.$photoFolder.THUMB_SUFFIX.'/'.$topics,
							'url'   => '');
	    			break;
	    	}

			$json_data[$i] = $json_row;
			$i++;
			$topicTotal = $i;
		}
	}
	/*
	 * Order y title: ASC: SORT_ASC, DESC: SORT_DESC
	 */
	foreach ($json_data as $key => $row) {
		$title[$key]  = $row['image'];
	}
	array_multisort($title, SORT_ASC, $json_data);
	/*
	 * Output
	 */
	switch ($mode) {
	    case 'html':
			$html_str = '
				<div data-role="page" data-add-back-btn="true" id="Gallery2" class="gallery-page">
					<div data-role="header">
						<h1>'.$photoFolder.'</h1>
					</div>
					<div data-role="content">	
						<ul class="gallery">';
						foreach ($json_data as $key => $row) {
							$html_str.= '<li><a href="'.$row['image'].'" rel="external"><img src="'.$row['thumb'].'" alt="'.$row['title'].'" /></a></li>';
						}
						$html_str.= '</ul>
						</div>
						</div>';
					return $html_str;
	    break;
	    default:
	        return $json_data;
	    break;
	}
}
