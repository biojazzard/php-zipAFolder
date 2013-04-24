<?php
/**
 * Website Javierriano.com 1.02 - 2011 @biojazzard |
 *
 * @packageTDS data/json 1.02
 * @subpackageScript
 * @categoryPHP
 * @author Alfredo Llanos
 * @link http://tallerdelsoho.es/
 */

$files_to_zip = array(
  'img/marivi-vito-154x0.jpg',
  'img/vito-neska-154x0.jpg'
);

define('MODE',            'array');      // RELATIVA A: FILES_FOLDER

define('FILES_FOLDER',		'./img/');	  // RELATIVA a index.php
define('REQ_FOLDER',      'vito');      // RELATIVA A: FILES_FOLDER
define('THUMB_SUFFIX',		'_thumb');		// Sufijo Thumbnails
define('MOBILE_SUFFIX',		'');			    // Sufijo Mobiles, si se deja blanco: usa las imágenes ppales.

