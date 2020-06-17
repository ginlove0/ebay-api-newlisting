import {INDEX_ITEMS, ERROR_ITEMS, SEEN_ITEMS, PUSHER_ITEMS} from '../actions/itemsAction'
const initialState = {
    items: [],
    pusherItem: []
};

const reducer = (state = initialState, action) => {

    switch (action.type) {
        case INDEX_ITEMS:
            return {
                ...state,
                items: [...action.payload.items, ...state.items]
            };
        case PUSHER_ITEMS:
            var payloadItem = action.payload.items;
            return {
                ...state,
                items: [payloadItem, ...state.items]
            };
        case SEEN_ITEMS:

            return {
                ...state,
                items: action.payload.copyItem
            };
        default:
            return state;
    }
};

export default reducer
