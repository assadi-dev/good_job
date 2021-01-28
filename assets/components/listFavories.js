import React  from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';
import ListFavories from './Espace/listFavories'



ReactDOM.render(
    <Router>
        
     <ListFavories />
      
        
    </Router>,
    document.getElementById('listFavories')
);