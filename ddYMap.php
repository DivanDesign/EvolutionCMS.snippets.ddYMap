<?php
/**
 * ddYMap.php
 * @version 1.1 (2013-07-16)
 *
 * @desc Выводит Яндекс.Карту на страницу.
 * 
 * @uses Сниппет ddGetDocumentField 2.4 (если координаты нужно получать, см. $getField).
 * 
 * @note Внимание! На странице уже должен быть подключен jQuery.
 * @note Из пары параметров coords / getField необходимо передавать лишь один.
 * 
 * @param $geoPos {comma separated string} - Координаты на карте (Долгота и Широта, перечисленные через запятую). По умолчанию: ''.
 * @param $getField {string} - Имя поля документа, содержащего координаты, значение которого необходимо получить.
 * @param $getId {integer} - ID документа, значение поля которого нужно получить. По умолчанию: текущий документ.
 * @param $mapElementId {string} - ID контейнера, где будет находиться Яндекс.Карта. По умолчанию: 'map'.
 * @param $icon {string} - Изображение иконки для метки на карте. По умолчанию: без иконки (используется стандартная).
 * @param $iconOffset {comma separated string} - Смещение иконки в пикселях относительно базового положения, задается в виде пары чисел, разделенных запятой (x, y). Базовое положение: иконка располагается горизонтально по центру точки ($geoPos), вертикально — над точкой.
 * @param $scrollZoom {0; 1} - Разрешёно ли изменение масштаба карты колесом мыши? По умолчанию: 0.
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
	$inlineScript = '$(function(){$.ddYMap.init({elementId: "'.$mapElementId.'", latLng: new Array('.$geoPos.')';
	
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
	
	$inlineScript .= '});});';
	
	//Подключаем инлайн-скрипт с инициализацией
	$modx->regClientStartupScript('<script type="text/javascript">'.$inlineScript.'</script>', array('name' => '$.ddYMap.inline', 'version' => '1.0', 'plaintext' => true));
}
?>