<?php
/**
 * ddYMap.php
 * @version 1.1 (2013-07-16)
 *
 * @desc A snippet that allows Yandex.Maps to be rendered on a page in a simple way.
 * 
 * @uses The snippet ddGetDocumentField 2.4 (if position getting from another field is required, see $geoPos).
 * 
 * @note Attention! The jQuery library should be included on the page.
 * @note From the pair of field/getField parameters one is required.
 * 
 * @param $geoPos {comma separated string} - Comma separated longitude and latitude. @required
 * @param $getField {string} - A field name with position that is required to be got.
 * @param $getId {integer} - Document ID with a field value needed to be received. Default: current document.
 * @param $mapElementId {string} - Container ID which the map is required to be embed in. Default: 'map'.
 * @param $icon {string} - An icon to use (relative address). Default: without (default icon).
 * @param $iconOffset {comma separated string} - An offset of the icon in pixels (x, y).Basic position: the icon is horizontally centered with respect to x and its bottom position is y. Default: '0,0'.
 * @param $scrollZoom {0; 1} - Allow zoom while scrolling. Default: 0.
 * 
 * @link http://code.divandesign.biz/modx/ddymap/1.1
 *
 * @copyright 2013, DivanDesign
 * http://www.DivanDesign.biz
 */

//Если задано имя поля, которое необходимо получить
if (isset($getField)){
	$geoPos = $modx->runSnippet('ddGetDocumentField', array(
		'id' => $getId,
		'field' => $getField
	));
}

//Если координаты заданы и не пустые
if (!empty($geoPos)){
	$mapElementId = isset($mapElementId) ? $mapElementId : 'map';
	
	//Подключаем библиотеку карт
	$modx->regClientStartupScript('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru-RU', array('name' => 'api-maps.yandex.ru', 'version' => '2.0-stable'));
	//Подключаем $.ddYMap
	$modx->regClientStartupScript('assets/js/jquery.ddYMap-1.0.min.js', array('name' => '$.ddYMap', 'version' => '1.0'));
	
	//Инлайн-скрипт инициализации
	$inlineScript = '(function($){$(function(){$.ddYMap.init({elementId: "'.$mapElementId.'", latLng: new Array('.$geoPos.')';
	
	//Если иконка задана
	if (!empty($icon)){
		//путь иконки на сервере
		$icon = ltrim($icon, '/');
		
		if (file_exists($icon)){
			//Получим её размеры
			$iconSize = getimagesize($icon);
			
			//если смещение не задано сделаем над опорной точкой ценруя по ширине
			$resultIconOffset = array($iconSize[0] / -2, $iconSize[1] * -1);
			if (!empty($iconOffset)){
				$iconOffset = explode(',', $iconOffset);
				//если задано сделает относительно положения по умолчанию
				$resultIconOffset[0] += $iconOffset[0];
				$resultIconOffset[1] += $iconOffset[1];
			}
			//Позиционируем точку по центру иконки
			$inlineScript .= ', placemarkOptions: {
				iconImageHref: "'.$icon.'",
				iconImageSize: ['.$iconSize[0].', '.$iconSize[1].'],
				iconImageOffset: ['.$resultIconOffset[0].', '.$resultIconOffset[1].']
			}';
		}
	}
	
	//Если нужен скролл колесом мыши, упомянем об этом
	if (isset($scrollZoom) && $scrollZoom == 1){$inlineScript .= ', scrollZoom: true';}
	
	$inlineScript .= '});});})(jQuery);';
	
	//Подключаем инлайн-скрипт с инициализацией
	$modx->regClientStartupScript('<script type="text/javascript">'.$inlineScript.'</script>', array('plaintext' => true));
}
?>