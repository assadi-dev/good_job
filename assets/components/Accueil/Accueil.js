import React, { Fragment } from 'react';
import { connect } from 'react-redux';
import Filtres from './Filtres';
import ListOffres from './ListOffres';
import { CONTRAT } from '../store/action'




const Accueil = () => {
    
    console.log(CONTRAT);
   
    return (
  
        <Fragment>
    
            
            <Filtres />
            <ListOffres />
         

        </Fragment>
            
       
    );
}



export default Accueil;

