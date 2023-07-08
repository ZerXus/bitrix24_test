{"version":3,"sources":["column.js"],"names":["BX","namespace","Tasks","Kanban","Column","options","apply","this","arguments","sortButton","type","prototype","__proto__","constructor","getCustomTitleButtons","getGridData","showSortButton","create","props","className","events","click","handleSortButtonClick","bind","isRemovable","getGrid","isScrumGrid","isFinishType","isNewType","call","onDragDrop","itemNode","x","y","isMultiSelect","getSelectedItems","size","onDragDropMultiple","hideDragTarget","draggableItem","getItemByElement","event","DragEvent","setItem","setTargetColumn","onCustomEvent","isActionAllowed","taskCompletePromise","Promise","isSprintView","getColumn","top","loadExt","then","Scrum","Dod","fulfill","scrumDod","groupId","getData","taskId","getId","subscribe","reject","isNecessary","showList","success","moveItem","getType","menuItems","sortMenuItems","PopupMenu","show","setGrid","grid","addCustomEvent","isRealtimeMode","handleConfirmButtonClick","confirmDialog","getConfirmDialog","removeButton","getButton","getContainer","classList","contains","addClassName","promise","getEventPromise","result","isGroupingMode","removeColumnsByIdFromNeighborGrids","removeColumn","removeClassName","close","error","setContent","style","display","handleAddColumnButtonClick","gridData","rights","canAddColumn","newColumn","addColumn","id","util","getRandomString","canSort","canAddItem","droppable","targetId","getNextColumnSibling","animate","switchToEditMode","Intranet","accessNotify","handleAddItemButtonClick","addItemInSlider","SidePanel","Instance","open","pathToTaskCreate","replace","getTitleContainer","layout","title","attrs","isScrumGridHeader","getSubTitle","subTitle","document","createElement","renderTitle","getBody","body","items","getItemsContainer","getDefaultTitleLayout","titleBody","customButtons","isDomNode","isArray","children","color","getColor","info","name","getColumnTitle","getTotalItem","isEditable","getEditButton","concat","getEditForm","titleArrow","kanbanType","add","getAddColumnButton","addItem","item","beforeItem","isCountable","updateHeaderColumn","removeItem","itemToRemove","getNeighborGrids","forEach","neighborGrid","updateTotals","DraftColumn","applyEditMode","asyncEventStarted","trim","getTitleTextBox","value","length","getMessage","setName","disabled","Utils","isValidId","targetColumn"],"mappings":"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","file":"column.map.js"}