# (MODX)EvolutionCMS.snippets.ddYMap changelog


## Version 1.6.2 (2020-07-08)
* \* Attention! (MODX)EvolutionCMS.libraries.ddTools >= 0.40.1 is required (not tested in older versions).
* \* Improved compatibility with new versions of (MODX)EvolutionCMS.libraries.ddTools.
* \* The `defer` attribute is used only for external scripts (closes #2).
* \* Repository file structure was changed.
* \+ README.
* \+ README_ru.
* \+ CHANGELOG.
* \+ CHANGELOG_ru.
* \+ Composer.json.


## Version 1.6.1 (2018-02-02)
* \* Attention! PHP >= 5.4 is required.
* \* Attention! (MODX)EvolutionCMS.libraries.ddTools >= 0.21 is required.
* \* Parameters: The following have been renamed (the snippet works with the old names but they are deprecated):
	* \* `docField` → `geoPos_docField`.
	* \* `docId` → `geoPos_docId`.


## Version 1.6 (2017-11-28)
* \+ Parameters → `scriptsLocation`: The new parameter. Indicating where JS scripts are included.
* \* Fixed Javascript error `Mixed Content: the content must be served over HTTPS`.


## Version 1.5 (2015-02-01)
* \* Parameters:
	* \* `lang`: The new parameter. Setting the locale determines the language that map texts and controls are displayed in, the preferred language for returning map search results, and the default measurement units.
	* \* `mapElement`: The parameter is checked by `empty` instead of `isset`.


## Version 1.4.2 (2014-08-14)
* \* Wrong variable name has been fixed.


## Version 1.4.1 (2014-07-24)
* \* jQuery.ddYMap has been updated to 1.3.1.


## Version 1.4 (2014-07-10)
* \* Attention! (MODX)EvolutionCMS.libraries.ddTools >= 0.12 is required.
* \* Parameters: The following have been renamed (the snippet works with the old names but they are deprecated):
	* \* `getField` → `docField`.
	* \* `getId` → `docId`.
* \* The 2.1 version of Yandex. Maps API is used.
* \* jQuery.ddYMap has been updated to 1.3.


## Version 1.3 (2014-06-05)
* \+ Parameters → `mapCenterOffset`: The new parameter. It allows center offset of the map to be set in pixels with respect to the center of the map container.
* \* jQuery.ddYMap has been updated to 1.2.


## Version 1.2 (2014-03-16)
* \* Attention! (MODX)EvolutionCMS.libraries.ddTools >= 0.11 is required.
* \* Parameters:
	* \+ `defaultType`: The new parameter which allows to set default map type has been added.
	* \+ `defaultZoom`: The new parameter which allows to set default map zoom has been added.
	* \* `mapElement`:
		* \* Has been ranamed from `mapElementId`.
		* \+ Now takes a custom jQuery selector instead of an id. Default value equals '#map'.
* \* Absolute URL is used for referring to the jQuery.ddYMap library.
* \* jQuery.ddYMap has been updated to 1.1.
* \* The `ddTools:getTemplateVarOutput` method is used for getting field value instead of the `ddGetDocumentField` snippet.
* \* The fractional values bug of the icon offset has been fixed.


## Version 1.1.1 (2013-10-02)
* \+ Parameters → `icon`: An URL can be passed as a value for the parameter.
* \+ Multiple calls of the snippet on the same document are available now (inline script is included without explicit version pass).
* \* The dollar sign isn’t used as a global variable to avoid conflicts with other js-libraries in inline script.


## Version 1.1 (2013-07-16)
* \+ Parameters → `iconOffset`: The new parameter allowing an offset of the icon to be set.
* \* The `icon` path bug has been fixed.
* \* `isset($var) && $var != ''` was replaced with `!empty($var)` in the position (`geoPos`) and icon (`icon`) validation conditions.


## Version 1.0 (2013-07-12)
* \+ The first release.


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />
<style>ul{list-style:none;}</style>