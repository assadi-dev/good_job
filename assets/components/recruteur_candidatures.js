import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import Candidatures from './Recruteur/candidatures';




ReactDOM.render(
    <Router>
        <Candidatures />
    </Router>,
    document.getElementById('candidatures_recruteur')
);