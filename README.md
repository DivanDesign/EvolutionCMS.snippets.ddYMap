# (MODX)EvolutionCMS.snippets.ddYMap

A snippet that allows [Yandex.Maps](https://maps.yandex.com) to be rendered on a page in a simple way.

It is useful to use the snippet with [mm_ddYMap](https://code.divandesign.biz/modx/mm_ddymap).


## Requires

* PHP >= 5.4
* [(MODX)EvolutionCMS.libraries.ddTools](https://code.divandesign.biz/modx/ddtools) >= 0.40.1 (not tested with older versions)


## Documentation

**Be advised!** The jQuery library must be included on the page.


### Installation


#### 1. Elements → Snippets: Create a new snippet with the following data

1. Snippet name: `ddYMap`.
2. Description: `<b>1.6.2</b> A snippet that allows Yandex.Maps to be rendered on a page in a simple way.`.
3. Category: `Core`.
4. Parse DocBlock: `no`.
5. Snippet code (php): Insert content of the `ddYMap_snippet.php` file from the archive.


#### 2. Elements → Manage Files

Upload the `jQuery.ddYMap-1.4.min.js` file to the `assets/js/` folder.


### Parameters description

From the pair of `geoPos` / `geoPos_docField` parameters one is required.

* `geoPos`
	* Desctription: Comma separated longitude and latitude.
	* Valid values: `string_commaSeparated`
	* **Required**
	
* `geoPos_docField`
	* Desctription: A field name with position that is required to be got.
	* Valid values: `string`
	* Default value: —
	
* `geoPos_docId`
	* Desctription: Document ID with a field value needed to be received.
	* Valid values: `integer`
	* Default value: — (current document)
	
* `mapElement`
	* Desctription: Container selector which the map is required to be embed in.
	* Valid values: `string`
	* Default value: `'#map'`
	
* `defaultType`
	* Desctription: Default map type.
	* Valid values:
		* `'map'` — schematic map
		* `'satellite'` — satellite map
		* `'hybrid'` — hybrid map
		* `'publicMap'` — public map
		* `'publicMapHybrid'` — hybrid public map
	* Default value: `'map'`
	
* `defaultZoom`
	* Desctription: Default map zoom.
	* Valid values: `integer`
	* Default value: `15`
	
* `icon`
	* Desctription: An icon to use (relative address or URL).
	* Valid values: `string`
	* Default value: — (default Yandex icon)
	
* `iconOffset`
	* Desctription: An offset of the icon in pixels (`x`, `y`).  
		Basic position: the icon is horizontally centered with respect to `x` and its bottom position is `y`.
	* Valid values: `string_commaSeparated`
	* Default value: `'0,0'`
	
* `scrollZoom`
	* Desctription: Allow zoom while scrolling.
	* Valid values:
		* `0`
		* `1`
	* Default value: `0`
	
* `mapCenterOffset`
	* Desctription: Center offset of the map with respect to the center of the map container in pixels.
	* Valid values: `string_commaSeparated`
	* Default value: `'0,0'`
	
* `lang`
	* Desctription: Map language — locale ID.  
		See [Yandex.Maps documentation](https://api.yandex.com/maps/doc/jsapi/2.x/dg/concepts/load.xml) for more information.
	* Valid values:
		* `'en_US'`
		* `'ru_RU'`
		* `'ru_UA'`
		* `'uk_UA'`
		* `'tr_TR'`
	* Default value: `'ru_RU'`
	
* `scriptsLocation`
	* Desctription: The tag where JS scripts will be included.
	* Valid values:
		* `'head'`
		* `'body'`
	* Default value: `'head'`


### Examples

```
[[ddYMap?
	&geoPos=`55.177446326764496,61.29041790962219`
	&icon=`assets/images/system/mapIcon.png`
]]
```


## Links

* [Home page](https://code.divandesign.biz/modx/ddymap)
* [Telegram chat](https://t.me/dd_code)


<link rel="stylesheet" type="text/css" href="https://DivanDesign.ru/assets/files/ddMarkdown.css" />