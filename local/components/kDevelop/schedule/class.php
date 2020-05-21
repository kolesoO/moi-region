<?php

if (!defined('B_PROLOG_INCLUDED') || B_PROLOG_INCLUDED !== true) die();

/**
 * @var $APPLICATION CMain
 */

class Schedule extends CBitrixComponent
{
    /** @inheritDoc */
    public function onPrepareComponentParams($arParams)
    {
        $arParams['IBLOCK_ID'] = (int) $arParams['IBLOCK_ID'];

        return $arParams;
    }

    /** @inheritDoc */
    public function executeComponent()
    {
        if ($this->arParams['IBLOCK_ID'] == 0) return;

        $this->arResult['CLOSEST_DELIVERY'] = $this->getForOrder();

        $this->includeComponentTemplate();
    }

    /**
     * @param array $filter
     * @param array $select
     * @return array
     */
    public function getData(array $filter, array $select = ['*']): array
    {
        $result = [];

        $rs = CIblockElement::GetList(
            [],
            $this->prepareFilter($filter),
            false,
            false,
            $select
        );
        if ($item = $rs->GetNextElement()) {
            $result = array_merge(
                $item->fields,
                ['PROPERTIES' => $item->GetProperties()]
            );
        }

        return $result;
    }

    /**
     * @return array
     */
    public function getForOrder(): array
    {
        $data = $this->getData(
            [
//                '>=PROPERTY_START_ORDER' => $curDate,
//                '<=PROPERTY_END_ORDER' => $curDate,
                'CODE' => 'general',
                'ACTIVE' => 'Y',
            ],
            ['ID', 'IBLOCK_ID']
        );

        $delivery = [
            $data['PROPERTIES']['START_DELIVERY']['VALUE'],
            $data['PROPERTIES']['END_DELIVERY']['VALUE'],
        ];
        $curDate = date('d.m.Y H:i:s');

        if ($data['PROPERTIES']['END_ORDER']['VALUE'] < $curDate) {
            $delivery = [
                $data['PROPERTIES']['START_NEXT_DELIVERY']['VALUE'],
                $data['PROPERTIES']['END_NEXT_DELIVERY']['VALUE'],
            ];
        }

        return [
            'DATE' => FormatDateFromDB($delivery[0], 'd F'),
            'TIME' => 'с ' . date('H:i', strtotime($delivery[0])) . ' по ' . date('H:i', strtotime($delivery[1]))
        ];
    }

    /**
     * @param array $filter
     * @return array
     */
    protected function prepareFilter(array $filter): array
    {
        return array_merge(
            $filter,
            ['IBLOCK_ID' => $this->arParams['IBLOCK_ID']]
        );
    }
}
