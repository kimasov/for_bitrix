Для добавления своих правил работы с корзиной, вы можете добавить такой обработчик и прописать свои условия:

AddEventHandler("sale", "OnCondSaleControlBuildList", Array("ASaleCondCtrlBasketFields", "GetControlDescr"), 10000);

OnCondSaleActionsControlBuildList (для действий) и OnCondSaleControlBuildList (для условий).

И отправные файлы /modules/sale/general/sale_act.php и sale_cond.php 
