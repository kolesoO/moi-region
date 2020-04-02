<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
/**
 * @global CMain $APPLICATION
 * @var array $arParams
 * @var array $arResult
 */
?>

<?ShowError($arResult["strProfileError"]);?>
<div class="row">
    <form method="post" name="form1" action="<?=$arResult["FORM_TARGET"]?>" enctype="multipart/form-data" class="col-lg-6">
        <?=$arResult["BX_SESSION_CHECK"]?>
        <input type="hidden" name="lang" value="<?=LANG?>" />
        <input type="hidden" name="ID" value=<?=$arResult["ID"]?> />
        <div class="form-group">
            <label for="name"><?=GetMessage('NAME')?></label>
            <input id="name" class="form-control" type="text" name="NAME" value="<?=$arResult["arUser"]["NAME"]?>" required>
        </div>
        <div class="form-group">
            <label for="lname"><?=GetMessage('LAST_NAME')?></label>
            <input id="lname" class="form-control" type="text" name="LAST_NAME" value="<?=$arResult["arUser"]["LAST_NAME"]?>">
        </div>
        <div class="form-group">
            <label for="sname"><?=GetMessage('SECOND_NAME')?></label>
            <input id="sname" class="form-control" type="text" name="SECOND_NAME" value="<?=$arResult["arUser"]["SECOND_NAME"]?>">
        </div>
        <div class="form-group">
            <label for="email"><?=GetMessage('EMAIL')?></label>
            <input id="email" class="form-control" type="email" name="EMAIL" value="<?=$arResult["arUser"]["EMAIL"]?>" required>
        </div>
        <div class="form-group">
            <label for="phone"><?=GetMessage('USER_PHONE')?></label>
            <input id="phone" class="form-control" type="tel" name="PERSONAL_PHONE" value="<?=$arResult["arUser"]["PERSONAL_PHONE"]?>">
        </div>
        <div class="form-group">
            <label for="login"><?=GetMessage('LOGIN')?></label>
            <input id="login" class="form-control" type="text" name="LOGIN" value="<?=$arResult["arUser"]["LOGIN"]?>" required>
        </div>
        <?if($arResult['CAN_EDIT_PASSWORD']):?>
            <div class="form-group">
                <label for="new_pwd"><?=GetMessage('NEW_PASSWORD_REQ')?></label>
                <input id="new_pwd" class="form-control" type="password" name="NEW_PASSWORD" maxlength="50" value="" autocomplete="off" required>
            </div>
            <div class="form-group">
                <label for="confirm_new_pwd"><?=GetMessage('NEW_PASSWORD_CONFIRM')?></label>
                <input id="confirm_new_pwd" class="form-control" type="password" name="NEW_PASSWORD_CONFIRM" maxlength="50" value="" autocomplete="off" required>
            </div>
        <?endif?>
        <input type="submit" name="save" class="btn btn-success" value="<?=GetMessage("MAIN_SAVE")?>">
        <?if ($_REQUEST["AJAX_CALL"] == "Y" && strlen($arResult["strProfileError"]) == 0) :?>
            <br><div class="small text-success">Данные успешно сохранены</div>
        <?endif?>
    </form>
</div>
