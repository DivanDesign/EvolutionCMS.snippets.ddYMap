<?php
/**
 * ddYMap
 * @version 1.5 (2015-02-01)
 * 
 * @desc A snippet that allows Yandex.Maps to be rendered on a page in a simple way.
 * 
 * @uses The library modx.ddTools 0.12.
 * 
 * @note Attention! The jQuery library should be included on the page.
 * @note From the pair of “$geoPos” / “$docField” parameters one is required.
 * 
 * @param $geoPos {comma separated string} - Comma separated longitude and latitude. @required
 * @param $docField {string} - A field name with position that is required to be got.
 * @param $docId {integer} - Document ID with a field value needed to be received. Default: current document.
 * @param $mapElement {string} - Container selector which the map is required to be embed in. Default: '#map'.
 * @param $defaultType {'map'; 'satellite'; 'hybrid'; 'publicMap'; 'publicMapHybrid'} - Default map type: 'map' — schematic map, 'satellite' — satellite map, 'hybrid' — hybrid map, 'publicMap' — public map, 'publicMapHybrid' - hybrid public map. Default: 'map'.
 * @param $defaultZoom {integer} - Default map zoom. Default: 15.
 * @param $icon {string} - An icon to use (relative address). Default: without (default icon).
 * @param $iconOffset {comma separated string} - An offset of the icon in pixels (x, y).Basic position: the icon is horizontally centered with respect to x and its bottom position is y. Default: '0,0'.
 * @param $scrollZoom {0; 1} - Allow zoom while scrolling. Default: 0.
 * @param $mapCenterOffset {comma separated string} - Center offset of the map with respect to the center of the map container in pixels. Default: '0,0'.
 * @param $lang {'ru_RU'; 'en_US'; 'ru_UA'; 'uk_UA'; 'tr_TR'} - Map language — locale ID. See http://api.yandex.com/maps/doc/jsapi/2.x/dg/concepts/load.xml for more information. Default: 'ru_RU'.
 * @param $scriptsLocation {'head'; 'body';} - The tag where jQuery scripts are included. Default: 'head'.
 * 
 * @link http://code.divandesign.biz/modx/ddymap/1.5
 * 
 * @copyright 2015–2017 DivanDesign {@link http://www.DivanDesign.biz }
 */

//Подключаем modx.ddTools
require_once $modx->getConfig('base_path').'assets/snippets/ddTools/modx.ddtools.class.php';

//Для обратной совместимости
extract(ddTools::verifyRenamedParams($params, array(
	'docField' => 'getField',
	'docId' => 'getId'
)));

//Если задано имя поля, которое необходимо получить
if (isset($docField)){
	$geoPos = ddTools::getTemplateVarOutput(array($docField), $docId);
	$geoPos = $geoPos[$docField];
}

//Где должны быть подключены скрипты
$scriptsLocation = isset($scriptsLocation) ? $scriptsLocation : 'head';

//Если координаты заданы и не пустые
if (!empty($geoPos)){
	if (empty($lang)){$lang = 'ru_RU';}
	if (empty($mapElement)){$mapElement = '#map';}
	
	//Инлайн-скрипт инициализации
	$inlineScript = '(function($){$(function(){$("'.$mapElement.'").ddYMap({placemarks: new Array('.$geoPos.')';
	
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
				iconLayout: "default#image",
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
	if (!empty($defaultZoom)){$inlineScript .= ', defaultZoom: '.$defaultZoom;}
	//Если указано смещение центра карты
	if (isset($mapCenterOffset)){$inlineScript .= ', mapCenterOffset: new Array('.$mapCenterOffset.')';} 
	
	$inlineScript .= '});});})(jQuery);';
	
	if ($scriptsLocation == 'head') {
		//Подключаем библиотеку карт
		$modx->regClientStartupScript('//api-maps.yandex.ru/2.1/?lang=' . $lang, array('name' => 'api-maps.yandex.ru', 'version' => '2.1'));
		//Подключаем $.ddYMap
		$modx->regClientStartupScript($modx->getConfig('site_url') . 'assets/js/jquery.ddYMap-1.4.min.js', array('name' => '$.ddYMap', 'version' => '1.4'));
		//Подключаем инлайн-скрипт с инициализацией
		$modx->regClientStartupScript('<script type="text/javascript">'.$inlineScript.'</script>', array('plaintext' => true));
	}else{
		//Подключаем библиотеку карт
		$modx->regClientScript("<script defer type='text/javascript' src='//api-maps.yandex.ru/2.1/?lang=" . $lang . "'></script>", array('name' => 'api-maps.yandex.ru', 'version' => '2.1'));
		//Подключаем $.ddYMap
		$modx->regClientScript("<script defer type='text/javascript' src='" . $modx->getConfig('site_url') . "assets/js/jquery.ddYMap-1.4.min.js'></script>", array('name' => '$.ddYMap', 'version' => '1.4'));
		//Подключаем инлайн-скрипт с инициализацией
		$modx->regClientScript("<script defer type='text/javascript'>".$inlineScript."</script>", array('plaintext' => true));
	}
}
?>
