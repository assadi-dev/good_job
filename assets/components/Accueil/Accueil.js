import React, { Fragment } from 'react';
import { connect } from 'react-redux';
import Filtres from './Filtres';
import ListOffres from './ListOffres';





const Accueil = () => {
    

   
    return (
  
        <Fragment>
    
            
            <Filtres />
            <ListOffres />
         

        </Fragment>
            
       
    );
}



export default Accueil;

