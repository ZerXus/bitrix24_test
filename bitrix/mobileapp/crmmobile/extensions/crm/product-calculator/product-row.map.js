{"version":3,"sources":["product-row.js"],"names":["jn","define","require","exports","module","mergeImmutable","clone","get","DiscountType","defaultPrecision","initialFields","QUANTITY","PRICE","PRICE_EXCLUSIVE","PRICE_NETTO","PRICE_BRUTTO","CUSTOMIZED","DISCOUNT_TYPE_ID","UNDEFINED","DISCOUNT_RATE","DISCOUNT_SUM","DISCOUNT_ROW","TAX_INCLUDED","TAX_RATE","TAX_SUM","SUM","ProductRow","constructor","fields","calculator","this","getPricePrecision","getCommonPrecision","getQuantityPrecision","getFields","setField","name","value","validateValue","priceFields","PERCENTAGE","MONETARY","round","includes","static","precision","factor","Math","pow","getBasePrice","getPrice","getPriceExclusive","getPriceNetto","getPriceBrutto","getQuantity","getDiscountType","isDiscountUndefined","isDiscountPercentage","isDiscountMonetary","isDiscountHandmade","getDiscountRate","getDiscountSum","getDiscountRow","isEmptyDiscount","getTaxIncluded","isTaxIncluded","getTaxRate","getTaxSum","getSum"],"mappings":"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","file":"product-row.map.js"}