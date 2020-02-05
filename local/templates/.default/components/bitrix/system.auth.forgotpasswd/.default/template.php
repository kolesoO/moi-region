<?if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();?>

<form name="bform" method="post" target="_top" action="<?=$arResult["AUTH_URL"]?>">
    <div class="modal-body">
        <?ShowMessage($arParams["~AUTH_RESULT"]);?>
        <?if (strlen($arResult["BACKURL"]) > 0) :?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>" />
        <?endif?>
        <input type="hidden" name="AUTH_FORM" value="Y">
        <input type="hidden" name="TYPE" value="SEND_PWD">
        <div class="form-group">
            <label for="email3"><?=GetMessage("sys_forgot_pass_login1")?></label>
            <input id="email3" type="email" name="USER_LOGIN" class="form-control" required value="<?=$arResult["LAST_LOGIN"]?>">
        </div>
        <div class="form-group"><?=GetMessage("sys_forgot_pass_note_email")?></div>
    </div>
    <div class="modal-footer">
        <button type="submit" name="send_account_info" class="btn btn-success"><?=GetMessage("AUTH_SEND")?></button>
    </div>
</form>
