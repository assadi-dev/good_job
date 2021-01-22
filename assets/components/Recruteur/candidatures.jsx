import React ,{useState,useEffect} from 'react';
import axios from 'axios';
import { host } from '../Api';


const Candidatures = () => {
    return (
        <div className="container">
          <h2 className="card-title">Candidatures</h2>
            <div className="card p-2 mt-5">
         

                
                <div className="card-body">
                    
                    <table className="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Id Offres</th>
                            <th scope="col">Id Candidat</th>
                            <th scope="col">Candidature</th>
                            <th scope="col">Reponse</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            <tr></tr>
                        </tbody>
                    </table>
            </div>
                
            </div>

        </div>
    )
}

export default Candidatures;