<?
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use Bitrix\Main\Application,
    Bitrix\Main\Context,
    Bitrix\Sale;

$arResult = [];
$basket = \Bitrix\Sale\Basket::loadItemsForFUser(\Bitrix\Sale\Fuser::getId(), SITE_ID);
$basket->refreshData(array('PRICE', 'COUPONS'));
$discounts = \Bitrix\Sale\Discount::buildFromBasket($basket, new \Bitrix\Sale\Discount\Context\Fuser($basket->getFUserId(true)));
$discounts->calculate();


$result = $discounts->getApplyResult(true);
$arQuantityList = $basket->getQuantityList();
foreach ($result['PRICES']['BASKET'] as $id => $item)
    $arResult['PRICE_FOR_SALE'] += ($item['PRICE'] * $arQuantityList[$id]);



$this->includeComponentTemplate();
