<?
/**
 * Bitrix Framework
 * @package bitrix
 * @subpackage main
 * @copyright 2001-2014 Bitrix
 */

/**
 * Bitrix vars
 * @global CMain $APPLICATION
 * @global CUser $USER
 * @param array $arParams
 * @param array $arResult
 * @param CBitrixComponentTemplate $this
 */

if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
?>

<form id="regform" name="regform" enctype="multipart/form-data" onsubmit="obAjax.userRegister(this, event)">
    <div class="modal-body">
        <?if (strlen($arResult["BACKURL"]) > 0) :?>
            <input type="hidden" name="backurl" value="<?=$arResult["BACKURL"]?>">
        <?endif?>
        <div class="form-group">
            <label for="email"><?=GetMessage("REGISTER_FIELD_EMAIL")?>*</label>
            <input id="email" type="email" name="LOGIN" class="form-control" value="<?=$arResult["VALUES"]["LOGIN"]?>" required>
        </div>
        <div class="form-group">
            <label for="pwd"><?=GetMessage("REGISTER_FIELD_PASSWORD")?>*</label>
            <input id="pwd" type="password" name="PASSWORD" class="form-control" value="<?=$arResult["VALUES"]["PASSWORD"]?>" required minlength="6" maxlength="50">
        </div>
        <div class="form-group">
            <label for="confirm-pwd"><?=GetMessage("REGISTER_FIELD_CONFIRM_PASSWORD")?>*</label>
            <input id="confirm-pwd" type="password" name="CONFIRM_PASSWORD" class="form-control" value="<?=$arResult["VALUES"]["CONFIRM_PASSWORD"]?>" required minlength="6" maxlength="50">
        </div>
    </div>
    <div class="modal-footer">
        <small class="text-danger error_txt"></small>
        <button type="submit" class="btn btn-success"><?=GetMessage("AUTH_REGISTER")?></button>
    </div>
</form>
