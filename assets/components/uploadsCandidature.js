import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router, Route, Switch } from 'react-router-dom';
import CandidaturesSubmit from './Accueil/candidaturesSubmit';




ReactDOM.render(
    <Router>
        <CandidaturesSubmit />
    </Router>,
    document.getElementById('candidatureReact')
);