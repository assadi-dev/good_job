import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import InputSearch from './Accueil/inputSearch';
import { Provider } from 'react-redux';
import store from './store/store';




ReactDOM.render(
    <Router>
        <Provider store={store}>
        <InputSearch  />
        </Provider>
        
    </Router>,
    document.getElementById('searchPoste')
);