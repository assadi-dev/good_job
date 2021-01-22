import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import Uploads from './Espace/Uploads';


ReactDOM.render(
    <Router>
        <Uploads />
        
    </Router>,
    document.getElementById('reactDocument')
);