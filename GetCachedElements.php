<?php

class GetCachedElements
{
    function Get($sort=Array("NAME"=>"ASC"), $Filter, $arSelect=false){
        if(!CModule::IncludeModule("iblock")) return false;
        if(empty($Filter)) return false;
        $arResult = false;

        $obCache = new CPHPCache;
        $life_time = 1;
        $cache_params = $Filter;
        $cache_params['func']='CIBlockElement::GetList';
        $cache_params['arSelect']=$arSelect;
        $cache_params['sort']=$sort;
        //$cache_params['pageParams']=$pageParams;
        $cache_id = md5(serialize($cache_params));
        if($obCache->InitCache($life_time, $cache_id, "/")) :
            $arResult = $obCache->GetVars();
        else :
            $ElList = CIBlockElement::GetList($sort, $Filter, false, false, $arSelect);
            while($arElement = $ElList->GetNext())
            {
                $arResult[] = $arElement;
            }
        endif;

        if($obCache->StartDataCache()):
            $obCache->EndDataCache($arResult);
        endif;

        return $arResult;
    }
}

?>