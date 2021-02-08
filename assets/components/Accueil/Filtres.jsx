import React, { Fragment, useState,useEffect } from 'react'
import { useSelector,useDispatch } from 'react-redux';
import ContratSelect from './contratSelect';
import SecteurSelect from './secteurSelect';


const Filtres = () => {


    return (
       
        <Fragment>


            <div className="col-sm-4 pt-3">

                <div className="card">
                    <div className="p-3">
                        <h5 className="card-title">Filtrer par :</h5>
                    </div>
                    <ul className="list-group list-group-flush">
                        <li className="list-group-item dropFilter">
                            <span
                                className="text-dark"
                                data-mdb-toggle="collapse"
                                href="#collapseContrat"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapseExample">
                                Contrats
                                <i className="fas fa-chevron-down float-end"></i>
                            </span>
                            
                            <div className="collapse mt-3 px-3 scroll-section" id="collapseContrat"  >
                                <ContratSelect />

                            </div>
                            

                       
                        </li>
                        <li className="list-group-item dropFilter">
                      
                            
                            <span
                                className="text-dark"
                                data-mdb-toggle="collapse"
                                href="#collapseSecteur"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapseExample">
                                Secteur d'activité
                                <i className="fas fa-chevron-down float-end"></i>
                            </span>
                            
                            <div className="collapse mt-3 px-3 scroll-section" id="collapseSecteur"  >
                                <SecteurSelect />

                                
                            </div>

                        </li>

                    </ul>

                </div>

            </div>
            
            

        </Fragment>
        
    )
};



export default Filtres;