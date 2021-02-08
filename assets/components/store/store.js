import React from 'react';
import { createStore,combineReducers,applyMiddleware } from 'redux';
import filtreReducer from '../redux/filtres/reducer';
import offreReducer from '../redux/offres/reducer';
import thunk from 'redux-thunk';


const rootReducer = combineReducers({
    filtres: filtreReducer,
    offres : offreReducer
})

const store = createStore(rootReducer,applyMiddleware(thunk) );

export default store;

