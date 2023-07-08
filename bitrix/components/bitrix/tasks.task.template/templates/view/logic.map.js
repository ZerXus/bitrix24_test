{"version":3,"sources":["logic.js"],"names":["BX","namespace","Tasks","Component","TasksTaskTemplate","extend","sys","code","methods","construct","this","callConstruct","initFileView","checkListChanged","showCloseConfirmation","analyticsData","bindEvents","Util","Dispatcher","bindEvent","id","onButtonClick","bind","option","edit","addCustomEvent","proxy","syncTags","bindControl","passCtx","onImportantButtonClick","onSaveButtonClick","onCancelButtonClick","createTemplateMenu","onSubTemplateAddClick","errors","alert","then","reload","onSliderClose","Event","EventEmitter","subscribe","eventData","action","data","allowedActions","util","in_array","toggleFooterWrap","event","CheckListInstance","checkListSlider","optionManager","slider","getSlider","denyAction","showChecklistCloseSliderPopup","checklistCloseSliderPopup","PopupWindow","titleBar","message","content","closeIcon","buttons","PopupWindowButton","text","className","events","click","close","show","node","priority","PRIORITY","newPriority","ajax","runComponentAction","mode","templateId","ID","response","status","isSaving","toggleClass","tags","length","tmpTags","each","tag","push","NAME","name","UI","Notification","Center","notify","window","location","controlAll","area","top","viewElementBind","type","isElementNode","getAttribute","activateLoading","saveCheckList","e","TASK_LIMIT_EXCEEDED","TEMPLATE_SUBTASK_LIMIT_EXCEEDED","preventDefault","InfoHelper","isLimit","limitAnalyticsLabels","module","source","self","treeStructure","getTreeStructure","items","getRequestData","params","Object","assign","checklistCount","getDescendantsCount","traversedItems","TRAVERSED_ITEMS","keys","forEach","nodeId","item","findChild","fields","getId","setId","saveStableTreeStructure","deactivateLoading","popup","rerender","onPopupClose","destroy","footer","saveButton","classWait","classActive","hasClass","addClass","removeClass","menuItemsList","delimiter","tabId","onclick","getMenuWindow","layout","setShowCompleted","getShowCompleted","handleTaskOptions","setShowOnlyMine","getShowOnlyMine","menu","PopupMenu","create","closeByEsc","offsetLeft","getBoundingClientRect","width","angle","popupWindow","call"],"mappings":"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","file":"logic.map.js"}