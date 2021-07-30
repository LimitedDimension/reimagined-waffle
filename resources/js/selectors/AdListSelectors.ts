export const adListItemsSelector = state => state.adList.items;

export const adListItemByIdSelector = (state, id) => state.adList.items.find(item => item.id == id);

