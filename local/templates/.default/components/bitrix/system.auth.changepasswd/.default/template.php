<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

if($arResult["PHONE_REGISTRATION"]) {
	CJSCore::Init('phone_auth');
}

ShowMessage($arParams["~AUTH_RESULT"]);
?>

<?if($arResult["SHOW_FORM"]):?>
    <form method="post" action="<?=$arResult["AUTH_FORM"]?>" name="bform">
        <?if (strlen($arResult["BACKURL"]) > 0): ?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <? endif ?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="CHANGE_PWD">
        <div class="form-group">
            <label for="email"><?=GetMessage("AUTH_LOGIN")?>*</label>
            <input id="email" type="email" name="USER_LOGIN" class="form-control" value="<?=$arResult["LAST_LOGIN"]?>" required>
        </div>
        <div class="form-group">
            <label for="checkword"><?=GetMessage("AUTH_CHECKWORD")?>*</label>
            <input
                    id="checkword"
                    type="text"
                    name="USER_CHECKWORD"
                    maxlength="50"
                    value="<?=$arResult["USER_CHECKWORD"]?>"
                    class="form-control"
                    autocomplete="off"
                    required
                    readonly
            >
        </div>
        <div class="form-group">
            <label for="password"><?=GetMessage("AUTH_NEW_PASSWORD_REQ")?>*</label>
            <input
                    id="password"
                    type="password"
                    name="USER_PASSWORD"
                    maxlength="255"
                    value="<?=$arResult["USER_PASSWORD"]?>"
                    class="form-control"
                    autocomplete="off"
                    required
            >
        </div>
        <div class="form-group">
            <label for="confirm_password"><?=GetMessage("AUTH_NEW_PASSWORD_CONFIRM")?>*</label>
            <input
                    id="confirm_password"
                    type="password"
                    name="USER_CONFIRM_PASSWORD"
                    maxlength="255"
                    value="<?=$arResult["USER_CONFIRM_PASSWORD"]?>"
                    class="form-control"
                    autocomplete="off"
                    required
            >
        </div>
        <button type="submit" name="change_pwd" class="btn btn-success"><?=GetMessage("AUTH_CHANGE")?></button>
    </form>
<?endif?>
