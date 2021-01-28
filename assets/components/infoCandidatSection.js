import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import DataCandidat from './Espace/dataCandidat';


ReactDOM.render(
    <Router>
       <DataCandidat />
        
    </Router>,
    document.getElementById('reactDataCandidat')
);