<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();?>

<div id="<?=$arResult['MAP_DATA']['general']['map_id']?>" class="map"></div>
<script>
    ymaps.ready(function(){
        let map = new obMap(<?=CUtil::PhpToJSObject($arResult['MAP_DATA'])?>);
        map.initMap();
        map.obMap.behaviors.disable('scrollZoom');
    });
</script>
