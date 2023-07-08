{"version":3,"file":"script.min.js","sources":["script.js"],"names":["BX","Tasks","componentIframe","objTemplate","html","createForm","lwPopup","responsibleInputId","oResponsibleSelector","oAccomplicesSelector","oGroupSelector","oLHEditor","oCrmUserField","oWebdavUserField","originalTaskData","editorInited","showCrmField","this","buttonsLocked","initialTaskData","fillEditForm","pTaskData","isPopupJustCreated","title","description","priority","deadline","accomplices","groupId","groupName","bGroupNameAbsent","crmFieldData","taskControl","allowTimeTracking","timeEstimate","timeEstimateHours","timeEstimateMinutes","message","TITLE","DESCRIPTION","PRIORITY","DEADLINE","ACCOMPLICES","GROUP_ID","UF_CRM_TASK","ALLOW_TIME_TRACKING","TASK_CONTROL","TIME_ESTIMATE","Math","floor","round","cleanNode","responsibleId","RESPONSIBLE_ID","responsibleName","value","join","loggedInUserId","checked","addClass","parentNode","disabled","removeClass","toString","setContent","setValue","_togglePriority","_setDeadline","setSelected","id","_onGroupSelect","CJSTask","getGroupsData","callback","selfObj","arGroups","length","bResponsibleNameAbsent","RESPONSIBLE_LAST_NAME","RESPONSIBLE_NAME","setSelectedUsers","name","arUsersInAnotherFormat","i","push","_onAccomplicesSelect","usersIds","apply","formatUsersNames","arUsers","slice","callbacks","onAfterPopupCreated","btnHintCreateMultiple","btnHintCreateOnce","hasOwnProperty","webdavFieldData","UF_TASK_WEBDAV_FILES","selectors","__initSelectors","requestedObject","selectedUsersIds","anchorId","bindClickTo","userInputId","multiple","callbackOnSelect","obj","_onResponsibleSelect","btnSelectText","btnCancelText","bindElement","params","attachTo","userFieldName","taskId","callbackOnRedraw","fieldLabel","containerId","__onCrmFieldRedraw","__onWebdavFieldRedraw","style","display","browser","IsMac","e","document","createElement","innerHTML","cmdSymbol","childNodes","nodeValue","onBeforePopupShow","JSON","parse","stringify","call","__checkWarnings","__cleanErrorsArea","IsSafari","getValue","onAfterPopupShow","IsChrome","IsIE11","IsIE","Focus","focus","bind","_processKeyDown","onPopupClose","unbind","handleMagicKeyCombos","window","event","shiftKey","keyCode","_submitAndCreateOnceMore","ctrlKey","_submitAndClosePopup","onAfterEditorInited","addCustomEvent","prepareTitleBar","content","create","bClose","taskData","gatherTaskDataFromForm","confirm","objPopup","close","bEnterPressed","metaKey","_runFullEditForm","ACCOMPLICES_IDS","RESPONSIBLE_SECOND_NAME","taskIFramePopup","add","prepareContent","props","className","arFiles","getElementsByName","filesIds","cnt","split","parseInt","isNaN","getContent","FILES","formField","type","isElementNode","DISK_ATTACHED_OBJECT_ALLOW_EDIT","TASKS_TASK_DISK_ATTACHED_OBJECT_ALLOW_EDIT","__lockButtons","__releaseButtons","columnsIds","tasksListNS","getColumnsOrder","_createTask","onceMore","callbackOnSuccess","objSelf","callbackOnFailure","data","__fillErrorsArea","errMessages","showCreateForm","prepareButtons","newPriority","_clearDeadline","dateSpan","newsubcont","appendChild","newValue","groups","_clearGroup","adjust","text","deleteIcon","findNextSibling","tag","events","click","input","inputWithGroupName","deselect","_showAccomplicesSelector","showUserSelector","empIDs","bindLink","arUsersCount","children","href","pathToUser","replace","target","substr","arUser","_onFilesUploaded","files","uniqueID","elem","fileID","firstChild","fileULR","unbindAll","lastChild","_deleteFile","hasClass","nextSibling","sessid","mode","url","ajax","post","remove","PreventDefault","_onFilesChange","filePath","fileTitle","fileName","random","list","items","filenameShort","li","iframeName","iframe","body","originalParent","form","method","action","enctype","encoding","submit","setTimeout","delegate","bShow","bHideTitle","__redrawUserField","targetNode","userFieldNode","nodeId","workFields","util","htmlspecialchars","attrs","cellspacing","width","errorMessages","errsCount","oSelf","checkWarningsId","clearTimeout","TASK","oAjaxReply","dataType","async","responseText"],"mappings":"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"}