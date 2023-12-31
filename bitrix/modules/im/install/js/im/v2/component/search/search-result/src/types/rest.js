export type ImSearchProviderItem = {
	id: number,
	entityId: string,
	entityType: string,
	title: string,
	customData: {
		imChat?: Object,
		imUser?: Object,
		imBot?: Object,
		email?: string,
		lastName?: string,
		login?: string,
		name?: string,
		position?: string,
		secondName?: string,
	},
	avatar: string,
	badges?: Array<Object>,
	tabs?: Array<string>,
	contextSort?: number,
	customSort?: number,
};
