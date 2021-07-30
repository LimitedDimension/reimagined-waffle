import { applyMiddleware, combineReducers, compose, createStore } from "redux";
import adListSlice from './slices/AdListSlice';
import thunk from "redux-thunk";

const rootReducer = combineReducers({
   adList: adListSlice
});

const composeEnhancers = ((window as any).__REDUX_DEVTOOLS_EXTENSION_COMPOSE__) || compose;

const store = createStore(rootReducer, composeEnhancers(applyMiddleware(thunk)));

export default store;

export type AppDispatch = typeof store.dispatch;
export type RootState = ReturnType<typeof store.getState>
