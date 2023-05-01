import {SET_INITIAL_STATE, TOGGLE_ISCHECKED} from "./actions";

export const firstState = {
    products: [],
}

function reducer(state = firstState, action) {
    switch (action.type) { 

        case SET_INITIAL_STATE:{
           const newState = action.payload.initialState
           return newState;
        }

        case TOGGLE_ISCHECKED:{
            const id = action.payload.id
            const toggledProduct = state.products.map((product) => {
                if(product.id === id){
                    product.isChecked = !product.isChecked
                }
                return product;
            });

            const newState = {
                ...state,
                products: toggledProduct,
               };
    
               return newState;
            }

        default:
            return state;
    }
}

export default reducer 