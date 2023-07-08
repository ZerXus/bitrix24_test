{"version":3,"sources":["multiselect_field.js"],"names":["BX","namespace","addClass","Landing","Utils","hasClass","removeClass","isArray","isFunction","create","random","escapeHtml","append","slice","encodeDataValue","remove","data","bind","style","clone","offsetLeft","offsetTop","findParent","decodeDataValue","BaseCollection","Collection","addPlaceholders","items","field","depth","forEach","item","checkbox","UI","Field","Checkbox","id","value","name","checked","selected","compact","onChange","onCheckboxChange","fields","add","layout","getPopup","contentContainer","addPlaceholder","MultiSelect","options","BaseField","apply","this","arguments","onChangeHandler","content","button","Button","BaseButton","text","Loc","getMessage","className","onClick","onButtonClick","grid","props","children","input","onInputClick","rootWindow","PageObject","getRootWindow","document","onDocumentClick","requestAnimationFrame","map","setValue","getValue","prototype","constructor","__proto__","placeholder","attrs","data-item","title","html","events","click","onPlaceholderRemoveClick","event","preventEvent","preventDefault","stopPropagation","getPlaceholderByItem","adjustPopupPosition","get","querySelector","onValueChangeHandler","length","find","element","popup","Main","Popup","selector","bindElement","autoHide","maxHeight","onPopupClose","parentElement","z-index","position","popupContainer","parent","body","showPopup","show","offsetParent","Type","isDomNode","inputTop","inputLeft","inputRect","getBoundingClientRect","offsetY","top","height","left","width","isShown","close","isChanged","sort","JSON","stringify","getItemByValue","result","findItem","innerHTML","itemValue"],"mappings":"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","file":"multiselect_field.map.js"}