<?if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<form name="system_auth_form<?=$arResult["RND"]?>" method="post" action="<?=$arResult["AUTH_URL"]?>">
    <div class="modal-body">
        <?
        if ($arResult['SHOW_ERRORS'] == 'Y' && $arResult['ERROR']) {
            ShowMessage($arResult['ERROR_MESSAGE']);
        }
        ?>
        <?if($arResult["BACKURL"] <> ''):?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <?foreach ($arResult["POST"] as $key => $value):?>
            <input type="hidden" name="<?=$key?>" value="<?=$value?>" />
        <?endforeach?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="AUTH">
        <div class="form-group">
            <label for="email1"><?=GetMessage("AUTH_LOGIN")?>*</label>
            <input id="email1" type="email" name="USER_LOGIN" class="form-control" required>
        </div>
        <div class="form-group">
            <label for="pwd1"><?=GetMessage("AUTH_PASSWORD")?>*</label>
            <input id="pwd1" type="password" name="USER_PASSWORD" class="form-control" required>
        </div>
    </div>
    <div class="modal-footer">
        <button type="submit" name="Login" class="btn btn-success"><?=GetMessage("AUTH_LOGIN_BUTTON")?></button>
    </div>
</form>
