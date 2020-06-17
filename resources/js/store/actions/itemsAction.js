import axios from 'axios'
export const INDEX_ITEMS = 'index:items';
export const ERROR_ITEMS = 'error:items';
export const PUSHER_ITEMS = 'pusher:items';
export const SEEN_ITEMS = 'seen:items';

const items_index = (items) => {

    return {
        type: INDEX_ITEMS,
        payload: {
            items
        }
    }
};

const error_items =  (error) => {
    return {
        type: ERROR_ITEMS,
        payload: {
            error
        }
    }
};

export const setSeen = (index) => {
    return (dispatch, getState) => {
        let copyItem = getState().itemsReducer.items;
        copyItem[index].newItem = false;
        console.log(copyItem);
        dispatch(() => (
            {
                type: SEEN_ITEMS,
                payload: {
                    copyItem
                }
            }
        ))
    }
};

export const api_setSellerBlacklist = (index) => {
    return (dispatch, getState) => {
        axios.delete('/api/seller/blacklist', {data: name})
            .then((res) =>
            {
                // setSellerExcludeTxt('Put seller to blacklist');
                // setSuccessSelleerBlacklist('btn-info');
                // setUndoSeller(name);
                // console.log(res)
                dispatch(setSellerBlacklist(index))
            })
            .catch((error => {
                // setSellerExcludeTxt('Put seller to blacklist');
                // setSuccessSelleerBlacklist('btn-info');
                // console.log(error)
                dispatch(error_items(error))
            }))
    }
};

const setSellerBlacklist = (index) => {
    return (dispatch, getState) => {
        let copyItem = getState().itemsReducer.items;
        copyItem[index].sellerBlacklist = false;
        dispatch(() => (
            {
                type: SEEN_ITEMS,
                payload: {
                    copyItem
                }
            }
        ))
    }
};


export const pusher_items = (items) => {
    return {
        type: PUSHER_ITEMS,
        payload: {
            items
        }
    }
};

export const api_items_index = () => {
    return (dispatch, getState) => {
        axios.get('/api/items')
            .then((res) => {
                let data = res.data;

                dispatch(items_index(data))
            })
            .catch((error) => {
                console.log(error)
                dispatch(error_items(error))
            })
    }
};
