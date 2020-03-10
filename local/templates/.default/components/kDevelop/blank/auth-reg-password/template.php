<div class="modal fade" id="auth-reg-form" tabindex="-1" role="dialog" aria-labelledby="auth-reg" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div id="accordion" class="modal-content">
            <div class="modal-header">
                <div class="modal-title d-flex" id="auth-reg">
                    <a
                        href="#reg-form"
                        class="text-decoration-none text-success"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <span>Регистрация</span>
                    </a>
                    <a
                        href="#auth-form"
                        class="text-decoration-none text-success ml-3"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <span>Вход</span>
                    </a>
                    <a
                        href="#forgot-pass"
                        class="text-decoration-none text-success ml-3"
                        data-toggle="collapse"
                        role="button"
                        aria-expanded="false"
                        aria-controls="collapseExample"
                    >
                        <span>Забыли пароль?</span>
                    </a>
                </div>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div id="reg-form" data-parent="#accordion" class="collapse show">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:main.register",
                    "",
                    Array(
                        "USER_PROPERTY_NAME" => "",
                        "SEF_MODE" => "Y",
                        "SHOW_FIELDS" => Array(),
                        "REQUIRED_FIELDS" => Array(),
                        "AUTH" => "Y",
                        "USE_BACKURL" => "N",
                        "SUCCESS_PAGE" => "/personal/",
                        "SET_TITLE" => "N",
                        "USER_PROPERTY" => Array(),
                        "SEF_FOLDER" => SITE_DIR,
                        "VARIABLE_ALIASES" => Array()
                    )
                );?>
            </div>
            <div id="auth-form" data-parent="#accordion" class="collapse">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.auth.form",
                    "",
                    Array(
                        "REGISTER_URL" => $APPLICATION->GetCurPage(false),
                        "FORGOT_PASSWORD_URL" => "",
                        "PROFILE_URL" => "/profile/",
                        "SHOW_ERRORS" => "Y"
                    )
                );?>
            </div>
            <div id="forgot-pass" data-parent="#accordion" class="collapse">
                <?$APPLICATION->IncludeComponent(
                    "bitrix:system.auth.forgotpasswd",
                    "",
                    Array()
                );?>
            </div>
        </div>
    </div>
</div>
