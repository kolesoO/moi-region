<?if(!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**@global $USER **/
?>

    <?if (!$isMainPage || !defined("NOT_CLOSE_SECTION_IN_FOOTER")) :?>
        </div></section>
    <?endif?>
    <footer class="footer bg-dark text-white pt-5 pb-5">
        <div class="container">
            <div class="row">
                <div class="col-lg-3 col-md-4 col-12">
                    <div class="h5">
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_TEMPLATE_PATH . "/include/footer/menu-pre_title.php"
                            ],
                            false
                        );?>
                    </div>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:menu",
                        "footer",
                        Array(
                            "ROOT_MENU_TYPE" => "bottom",
                            "MAX_LEVEL" => "1",
                            "CHILD_MENU_TYPE" => "bottom",
                            "USE_EXT" => "Y",
                            "DELAY" => "N",
                            "ALLOW_MULTI_SELECT" => "Y",
                            "MENU_CACHE_TYPE" => "N",
                            "MENU_CACHE_TIME" => "3600",
                            "MENU_CACHE_USE_GROUPS" => "Y",
                            "MENU_CACHE_GET_VARS" => ""
                        )
                    );?>
                </div>
                <div class="col-lg-3 d-lg-block d-none">
                    <h5>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.include",
                            ".default",
                            [
                                "AREA_FILE_SHOW" => "file",
                                "PATH" => SITE_TEMPLATE_PATH . "/include/index/catalog_sections-title.php"
                            ],
                            false
                        );?>
                    </h5>
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:catalog.section.list",
                        "footer",
                        [
                            "VIEW_MODE" => "TEXT",
                            "SHOW_PARENT_NAME" => "Y",
                            "IBLOCK_TYPE" => "1c_catalog",
                            "IBLOCK_ID" => IBLOCK_1C_CATALOG_CATALOG,
                            "SECTION_ID" => "",
                            "SECTION_CODE" => "",
                            "SECTION_URL" => "",
                            "COUNT_ELEMENTS" => "N",
                            "TOP_DEPTH" => "1",
                            "SECTION_FIELDS" => "",
                            "SECTION_USER_FIELDS" => "",
                            "ADD_SECTIONS_CHAIN" => "N",
                            "CACHE_TYPE" => "A",
                            "CACHE_TIME" => "36000000",
                            "CACHE_NOTES" => "",
                            "CACHE_GROUPS" => "Y"
                        ]
                    );?>
                </div>
                <div class="col-lg-6 col-md-8 col-12 mt-5 mt-lg-0 mt-md-0">
                    <?$APPLICATION->IncludeComponent(
                        "bitrix:main.include",
                        ".default",
                        [
                            "AREA_FILE_SHOW" => "file",
                            "PATH" => SITE_TEMPLATE_PATH . "/include/footer/info.php"
                        ],
                        false
                    );?>
                </div>
            </div>
        </div>
    </footer>
    <?
    if (!$USER->IsAuthorized()) {
        $APPLICATION->IncludeComponent(
            "kDevelop:blank",
            "auth-reg",
            []
        );
    }
    ?>
</body>
</html>
