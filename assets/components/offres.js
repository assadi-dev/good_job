import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Filtres from './Accueil/Filtres';
import ListOffres from './Accueil/ListOffres';


ReactDOM.render(
    <Router>
        <Filtres />
        <ListOffres />
        
    </Router>,
    document.getElementById('offresRow')
);