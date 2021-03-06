import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Accueil from './Accueil/Accueil';
import { Provider } from 'react-redux';
import store from './store/store';


ReactDOM.render(
    <Router>
        <Provider store={store}>

        <Accueil />
        </Provider>
    </Router>,
    document.getElementById('offresRow')
);