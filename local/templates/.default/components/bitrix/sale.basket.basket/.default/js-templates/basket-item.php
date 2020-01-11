<? if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var array $mobileColumns
 * @var array $arParams
 * @var string $templateFolder
 */
?>
<script id="basket-item-template" type="text/html">
    <div
            id="basket-item-{{ID}}"
            class="card-body bg-white border mb-3 shadow position-relative"
            data-entity="basket-item"
            data-id="{{ID}}"
    >
        <a
            href="javascript:void(0)"
            class="close_wrap lead text-success text-decoration-none"
            data-entity="basket-item-delete"
            title="Удалить"
        ><i class="fas fa-times"></i></a>
        <div class="row align-items-lg-center">
            <div class="col-lg-2 col-md-5 col-5">
                <a
                        href="#"
                        class="d-block image-block h-custom-100"
                        style="background-image:url('{{{IMAGE_URL}}}{{^IMAGE_URL}}<?=SITE_TEMPLATE_PATH?>/images/no-image.png{{/IMAGE_URL}}')"
                ></a>
            </div>
            <div class="col-lg-3 col-md-7 col-7 mb-lg-0 mb-4">
                <a href="#" class="h6 text-success text-decoration-none">{{NAME}}</a>
                <div class="text-secondary mt-2">
                    <div><small>Параметр товара:  1 кг</small></div>
                    <div><small>Параметр товара:  1 кг</small></div>
                    <div><small>Параметр товара:  1 кг</small></div>
                </div>
            </div>
            <div class="col-lg-2 col-md-4 col-4 align-self-lg-auto align-self-center">
                {{#SHOW_DISCOUNT_PRICE}}
                    <small class="text-secondary">
                        <s>{{{FULL_PRICE_FORMATED}}}</s>
                    </small>
                {{/SHOW_DISCOUNT_PRICE}}
                <div id="basket-item-price-{{ID}}" class="h6 mb-0">{{{PRICE_FORMATED}}}</div>
            </div>
            <div
                    data-entity="basket-item-quantity-block"
                    class="col-lg-2 col-md-4 col-4 align-self-lg-auto align-self-center">
                <input
                        id="basket-item-quantity-{{ID}}"
                        type="number"
                        class="form-control w-100"
                        value="{{QUANTITY}}"
                        data-value="{{QUANTITY}}"
                        data-entity="basket-item-quantity-field"
                >
            </div>
            <div class="col-lg-3 col-md-4 col-4 align-self-lg-auto align-self-center">
                {{#SHOW_DISCOUNT_PRICE}}
                    <small class="text-secondary">
                        <s>{{{SUM_FULL_PRICE_FORMATED}}}</s>
                    </small>&nbsp;
                {{/SHOW_DISCOUNT_PRICE}}
                <div id="basket-item-sum-price-{{ID}}" class="h5 mb-0">{{{SUM_PRICE_FORMATED}}}</div>
            </div>
        </div>
    </div>
</script>
