<div class="modal fade" id="auth-reg-form" tabindex="-1" role="dialog" aria-labelledby="auth-reg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="accordion" class="modal-content">
            <div class="modal-header">
                <div class="h5 modal-title" id="auth-reg">
                    <a
                        href="#reg-form"
                        class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Регистрация</span>
                    </a>
                    <a
                        href="#auth-form"
                        class="list-group-item text-decoration-none text-success bg-hover-success text-hover-white"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <i class="fas fa-shopping-basket mr-2"></i>
                        <span>Вход</span>
                    </a>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>


            <div class="modal-body">
                <div class="form-group">
                    <label for="question-title">Lorem ipsum</label>
                    <input id="question-title" type="text" class="form-control">
                </div>
                <div class="form-group">
                    <label for="question-text">Lorem ipsum</label>
                    <textarea id="question-text" class="form-control"></textarea>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-success">Lorem ipsum</button>
            </div>
        </div>
    </div>
</div>


<div id="reg-auth" class="popup" data-animate>
    <div class="popup_wrapper">
        <div class="popup_content animate-start js-popup_content">
            <a href="#" class="popup_content-close" data-popup-close><i class="icon close"></i></a>
            <div class="js-tabs">
                <div class="content_tab">
                    <a href="#" class="content_tab-item link dashed" data-tab_target="#reg-content">Регистрация</a>
                    <a href="#" class="content_tab-item link dashed" data-tab_target="#auth-content">Вход</a>
                </div>
                <div data-tab_content>
                    <div id="reg-content" data-tab_item>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:main.register",
                            "",
                            Array(
                                "USER_PROPERTY_NAME" => "",
                                "SEF_MODE" => "Y",
                                "SHOW_FIELDS" => Array(),
                                "REQUIRED_FIELDS" => Array(),
                                "AUTH" => "Y",
                                "USE_BACKURL" => "Y",
                                "SUCCESS_PAGE" => "",
                                "SET_TITLE" => "N",
                                "USER_PROPERTY" => Array(),
                                "SEF_FOLDER" => SITE_DIR,
                                "VARIABLE_ALIASES" => Array()
                            )
                        );?>
                    </div>
                    <div id="auth-content" data-tab_item>
                        <?$APPLICATION->IncludeComponent(
                            "bitrix:system.auth.form",
                            "",
                            Array(
                                "REGISTER_URL" => $APPLICATION->GetCurPage(false),
                                "FORGOT_PASSWORD_URL" => "",
                                "PROFILE_URL" => "#",
                                "SHOW_ERRORS" => "Y"
                            )
                        );?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
