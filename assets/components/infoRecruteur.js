import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import DataRecruteur  from './Recruteur/dataRecruteur';


ReactDOM.render(
    <Router>
       <DataRecruteur />
        
    </Router>,
    document.getElementById('reactDataRecruteur')
);