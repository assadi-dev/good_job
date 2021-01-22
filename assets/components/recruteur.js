import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Offres from './Recruteur/offres'




ReactDOM.render(
    <Router>
        <Offres />
    </Router>,
    document.getElementById('offres_recruteur')
);