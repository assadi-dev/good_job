import React ,{useState,useEffect} from 'react';
import axios from 'axios';
import { host } from '../Api';


const Candidatures = () => {


    
    const [candidatures, setCandidatures] = useState([]);

    useEffect(() => {
        let url = host + "/api/recruteur/candidatures";
        const fetchData = async () => {
            let result = await axios.get(url)
            
            let data = result.data
            setCandidatures(data);
        }
        
        fetchData();

    }, [])

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
                            {
                                candidatures.map((item, index) => (
                                    <tr>
                                        <td>{item.offre["id"]}</td>
                                        <td>{item.candidat["id"]}</td>
                                        <td>{item.name}</td>
                                        <td>{item.reponse}</td>
                                        <td><button className="btn btn-primary">Repondre</button></td>
                                    </tr>
                                ))
                                
                            }
                            
                        </tbody>
                    </table>
            </div>
                
            </div>

        </div>
    )
}

export default Candidatures;