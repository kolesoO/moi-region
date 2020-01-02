<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 * @var CatalogSectionComponent $component
 * @var CBitrixComponentTemplate $this
 * @var string $templateName
 * @var string $componentPath
 */

$this->setFrameMode(true);
?>

<?if ($arResult["ITEMS_COUNT"] > 0) :?>
    <table class="table table-striped">
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Товар</th>
                <th scope="col">Стоимость</th>
            </tr>
        </thead>
        <tbody>
            <?foreach ($arResult["ITEMS"] as $key => $arItem) :
                $arPrice = $arItem["ITEM_PRICES"][0];
                ?>
                <tr>
                    <th scope="row"><?=($key + 1)?></th>
                    <td><?=$arItem['NAME']?></td>
                    <td><?=$arPrice["PRINT_BASE_PRICE"]?></td>
                </tr>
            <?endforeach;?>
        </tbody>
    </table>
<?else:?>
    <p>Список товаров пуст</p>
<?endif?>
