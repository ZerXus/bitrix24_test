{"version":3,"file":"requisite-autocomplete.bundle.map.js","names":["this","BX","exports","main_core_events","main_core","crm_entityEditor_field_requisite_autocomplete","_templateObject","_templateObject2","EntityEditorRequisiteAutocomplete","_BX$UI$EntityEditorFi","babelHelpers","inherits","_this","classCallCheck","possibleConstructorReturn","getPrototypeOf","call","_autocomplete","_autocompleteData","createClass","key","value","doInitialize","params","_schemeElement","getData","enabled","prop","getBoolean","RequisiteAutocompleteField","create","getName","placeholderText","getString","featureRestrictionCallback","searchAction","feedbackFormParams","getObject","showFeedbackLink","clientResolverPlacementParams","subscribe","onSelectAutocompleteValue","bind","onClearAutocompleteValue","onInstallDefaultApp","EventEmitter","onInstallDefaultAppGlobal","createTitleMarker","_mode","UI","EntityEditorMode","view","restrictionCallback","get","prototype","lockIcon","Tag","render","taggedTemplateLiteral","setAttribute","layout","options","_hasLayout","_wrapper","ensureWrapperCreated","classNames","adjustWrapper","isNeedToDisplay","registerLayout","isDragEnabled","Dom","append","createDragButton","createTitleNode","getTitle","edit","autocompleteContainer","updateAutocompleteState","isContextMenuEnabled","appendChild","createContextMenuButton","initializeDragDropAbilities","autocompleteState","JSON","parse","getValue","e","setState","setContext","getAutocompleteContext","setUserFieldValue","fieldName","fieldValue","_editor","allowedFieldTypes","control","getControlByIdRecursive","fieldType","getFieldType","EntityEditorUserField","indexOf","fieldNode","valueControl","Type","isStringFilled","getFieldNode","isDomNode","querySelector","concat","numberValue","test","booleanValue","isNumber","parseInt","checked","datetimeValue","fireEvent","event","isPlainObject","fields","isString","length","substr","hasOwnProperty","markAsChanged","setCurrentItem","onGlobalCustomEvent","_this2","data","countryId","getInteger","ajax","runAction","then","setData","setPlaceholderText","setClientResolverPlacementParams","getAutocompleteData","typeId","presetId","getControlById","id","settings","self","initialize","onInitializeEditorControlFactory","methods","type","controlId","EntityEditorField","Crm","Event"],"sources":["requisite-autocomplete.bundle.js"],"mappings":"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"}