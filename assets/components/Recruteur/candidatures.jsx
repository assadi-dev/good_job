import React ,{useState,useEffect,useRef} from 'react';
import axios from 'axios';
import { host } from '../Api';
import ReponseModal from './repModal';
import "./styles_recruteur.css";


const Candidatures = () => {


    
    const [candidatures, setCandidatures] = useState([]);
    const [showCandidature, setShowCandidature] = useState([]);
    const reponseText = useRef();

    useEffect(() => {
        let url = host + "/api/recruteur/candidatures";
        const fetchData = async () => {
            let result = await axios.get(url)
            
            let data = result.data
            setCandidatures(data);

            document.querySelectorAll(".reponseText").forEach(element => {
                if (element.textContent == "Accépté") {
                    element.classList.add("text-success")
                }
                else if (element.textContent == "Candidature en cours") {
                    element.classList.add("text-warning")
                }
                else {
                    element.classList.add("text-danger")
                }
            });



        }
        
        fetchData();

    }, []);

    const getCandidature = async () => {
        
       // let url = host + "/api/recruteur/candidatures/" + id;
    }

    const getCandidatureById = (e,id) => {
        
       let data = candidatures.filter((v) => {
            
           return v.id == id;


           
        })

        setShowCandidature(data);
    }
    

 




    return (
        <div className="container">
          <h2 className="card-title">Candidatures</h2>
            <div className="card p-2 mt-5">
         

                
                <div className="card-body table-responsive">
                    
                    <table className="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Offres</th>
                            <th scope="col">Id Candidat</th>
                            <th scope="col">Candidature</th>
                            <th scope="col">Reponse</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            {
                                candidatures.map((item, index) => (
                                    <tr key={index}>
                                        <td>{item.offre["name"]}</td>
                                        <td>{item.candidat["id"]}</td>
                                        <td>{item.name}</td>
                                        <td  className="reponseText font-weight-bold" >{item.reponse}</td>
                                        <td>
                                            <button
                                                className="btn btn-primary"
                                                data-mdb-toggle="modal"
                                                data-mdb-target="#repModal" onClick={(e)=>getCandidatureById(e,item.id)} >Repondre</button>
                                        </td>
                                    </tr>
                                ))
                                
                            }
                            
                        </tbody>
                    </table>
            </div>
                
            </div>

            <ReponseModal data = {showCandidature} />

        </div>
    )
}

export default Candidatures;