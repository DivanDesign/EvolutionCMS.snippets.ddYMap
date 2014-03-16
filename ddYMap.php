<?php
/**
 * ddYMap.php
 * @version 1.2 (2014-03-16)
 * 
 * @desc A snippet that allows Yandex.Maps to be rendered on a page in a simple way.
 * 
 * @uses The library modx.ddTools 0.11 (if position getting from another field is required, see “$getField” and “$getId”).
 * 
 * @note Attention! The jQuery library should be included on the page.
 * @note From the pair of “$field” / “$getField” parameters one is required.
 * 
 * @param $geoPos {comma separated string} - Comma separated longitude and latitude. @required
 * @param $getField {string} - A field name with position that is required to be got.
 * @param $getId {integer} - Document ID with a field value needed to be received. Default: current document.
 * @param $mapElement {string} - Container selector which the map is required to be embed in. Default: '#map'.
 * @param $defaultType {'map'; 'satellite'; 'hybrid'; 'publicMap'; 'publicMapHybrid'} - Default map type: 'map' — schematic map, 'satellite' — satellite map, 'hybrid' — hybrid map, 'publicMap' — public map, 'publicMapHybrid' - hybrid public map. Default: 'map'.
 * @param $defaultZoom {integer} - Default map zoom. Default: 15.
 * @param $icon {string} - An icon to use (relative address). Default: without (default icon).
 * @param $iconOffset {comma separated string} - An offset of the icon in pixels (x, y).Basic position: the icon is horizontally centered with respect to x and its bottom position is y. Default: '0,0'.
 * @param $scrollZoom {0; 1} - Allow zoom while scrolling. Default: 0.
 * 
 * @link http://code.divandesign.biz/modx/ddymap/1.2
 * 
 * @copyright 2014, DivanDesign
 * http://www.DivanDesign.biz
 */

//Если задано имя поля, которое необходимо получить
if (isset($getField)){
	//Подключаем modx.ddTools
	require_once $modx->getConfig('base_path').'assets/snippets/ddTools/modx.ddtools.class.php';
	
	$geoPos = ddTools::getTemplateVarOutput(array($getField), $getId);
	$geoPos = $string[$getField];
}

//Если координаты заданы и не пустые
if (!empty($geoPos)){
	$mapElement = isset($mapElement) ? $mapElement : '#map';
	
	//Подключаем библиотеку карт
	$modx->regClientStartupScript('http://api-maps.yandex.ru/2.0-stable/?load=package.standard&amp;lang=ru-RU', array('name' => 'api-maps.yandex.ru', 'version' => '2.0-stable'));
	//Подключаем $.ddYMap
	$modx->regClientStartupScript($modx->getConfig('site_url').'assets/js/jquery.ddYMap-1.1.min.js', array('name' => '$.ddYMap', 'version' => '1.1'));
	
	//Инлайн-скрипт инициализации
	$inlineScript = '(function($){$(function(){$("'.$mapElement.'").ddYMap({latLng: new Array('.$geoPos.')';
	
	//Если иконка задана
	if (!empty($icon)){
		//путь иконки на сервере
		$icon = ltrim($icon, '/');
		
		//Пытаемся открыть файл
		$iconHandle = @fopen($icon, 'r');
		
		if ($iconHandle){
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
				iconImageOffset: ['.round($resultIconOffset[0]).', '.round($resultIconOffset[1]).']
			}';
			
			fclose($iconHandle);
		}
	}
	
	//Если нужен скролл колесом мыши, упомянем об этом
	if (isset($scrollZoom) && $scrollZoom == 1){$inlineScript .= ', scrollZoom: true';}
	//Тип карты по умолчанию
	if (!empty($defaultType)){$inlineScript .= ', defaultType: "'.$defaultType.'"';}
	//Масштаб карты по умолчанию
	if (!empty($defaultZoom)){$inlineScript .= ', zoom: '.$defaultZoom;}
	
	$inlineScript .= '});});})(jQuery);';
	
	//Подключаем инлайн-скрипт с инициализацией
	$modx->regClientStartupScript('<script type="text/javascript">'.$inlineScript.'</script>', array('plaintext' => true));
}
?>