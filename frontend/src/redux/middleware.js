import {ADD_PRODUCT,} from "./actions";
import { takeEvery, put, all } from "@redux-saga/core/effects";


function* addProduct(action){
       try {
           yield put(
            //code for asyn operations
            );
       } catch (error) {
            return error
       }
     }

// pass for now
function* middleware() {
    yield all([
        yield takeEvery(ADD_PRODUCT, addProduct),
    ]);
  }
  
  export default middleware;
