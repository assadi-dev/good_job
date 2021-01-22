import React, { useState, useEffect,useRef } from 'react';
import axios from 'axios';
import dayjs from 'dayjs';
import { Link,useLocation } from 'react-router-dom';
import { host } from '../Api';
import "./styles_recruteur.css";
import './actionForm';
import { handleChangeContrat, handleChangeDisponible, handleChangeEntreprise, handleChangeNom, handleChangePoste, handleChangeSecteur, handleChangeVille } from './actionForm';
import ModalAjouter from './modalAjouter';

const Offres = () => {

    const [offres, setOffres] = useState([]);
    const url = host + "/api/recruteur/offres";
    const [show_offre, setShow_offre] = useState([]);
    const [isLoading, setIsloading] = useState([false]);
    const [statut, setStatut] = useState([false]);
    let location = useLocation();
    let getLoad = useRef();

    var formValue = {
        id:show_offre.id,
        name: show_offre.name,
        entreprise : show_offre.entreprise,
        poste : show_offre.poste,
        secteur : show_offre.secteur,
        disponible:show_offre.disponible,
        contrat:show_offre.contrat,
        ville:show_offre.ville

    }




    useEffect(() => {

        

        const fetchData = async () => {
            let result = await axios.get(url);
            let cleanResult = result.data;

            cleanResult.map(offre => {
                let newDate = dayjs(offre.create_at).format("DD-MM-YYYY");

                offre.create_at = newDate

                return offre;
            })

            setOffres(cleanResult);
            
            
        };

        fetchData();
        if (statut == true) {
            setStatut(false);
        }
            
        
    }, [statut])


    const info_offre = async (e,id) => 
    {
        e.preventDefault();
        setIsloading(true)

        let result = await axios.get(url + "/" + id);
        let cleanResult = result.data;

        setIsloading(false)
        setShow_offre(cleanResult)
        
    }


    const handleUpdate = async (e, id, data) => {
     
        const url = host + "/api/recruteur/offres/edit/" + id;

        let result = await axios.put(url, {
            name: data.name,
            entreprise : data.entreprise,
            poste : data.poste,
            secteur : data.secteur,
            disponible:data.disponible,
            contrat:data.contrat,
            ville:data.ville
        })

        setStatut(true);

        document.querySelector(".message").classList.add("update_Show");

        
    }
        

    


  


    return (
        <div className="container">
          <h2 className="card-title">Offres</h2>
            <div className="card p-2 mt-5">
                <div>
                <button className="btn btn-success btn-rounded"  data-mdb-toggle="modal" data-mdb-target="#staticBackdropAdd">
                    Ajouter une offres
                </button>
                </div>

                
                <div className="card-body">
                    
                    <table className="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">Id</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Poste</th>
                            <th scope="col">Contrat</th>
                            <th scope="col">Validité</th>
                            <th scope="col">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                            {
                                offres.map((offre, index) => (
                                    <tr key={index}>
                                        <td>{offre.id}</td>
                                        <td>{offre.name}</td>
                                        <td>{offre.poste}</td>
                                        <td>{offre.contrat}</td>
                                        <td>{offre.disponible}</td>
                                        <td className="p-3 d-flex justify-content-center">
                                            <Link
                                                className="text-primary me-3"
                                               
                                                to={{
                                                    pathname: "",
                                                    state:{id:offre.id}
                                                }}
                                                data-mdb-toggle="modal"
                                                data-mdb-target="#staticBackdropUpdate"
                                                onClick={(e) => {
                                                    info_offre(e,offre.id)
                                                }}
                                                
                                            >Modifier</Link>
                                            <a className="text-danger " target="_blank" href={url+"/api/recruteur/delete/"+offre.id}>Supprimer</a>
                                        </td>
                                    </tr>
                                ))
                            }
                           
                        </tbody>
                    </table>
            </div>
                
            </div>
            <div
                className="modal fade"
                id="staticBackdropUpdate"
                data-mdb-backdrop="static"
                data-mdb-keyboard="false"
                tabIndex="-1"
                aria-labelledby="staticBackdropLabel"
                aria-hidden="true"
                >
                <div className="modal-dialog modal-dialog-scrollable modal-lg">
                
                    <div className="modal-content">
                    <div className="modal-header">
                            <h5 className="modal-title" id="staticBackdropLabel">{ "ID: "+ show_offre.id}</h5>
                        <button
                        type="button"
                        className="btn-close"
                        data-mdb-dismiss="modal"
                                aria-label="Close"
                                onClick={(e)=>{document.querySelector(".message").classList.remove("update_Show"),setIsloading(false)}}
                        ></button>
                    </div>
                    <div className="modal-body">
                        <div ref={getLoad} className={ isLoading?"loader_show":"loader_off" }>
                            <div className="spinner-grow" id="grow_loader"  role="status">
                                <span className="visually-hidden">Loading...</span>
                            </div>
                            </div> 
                            <div className={isLoading == true? "d-none":""}>
                               

                                    <input type="text" className="form-control" value={formValue.name} onChange={(event)=>handleChangeNom(event,formValue,setShow_offre)} />
                                    
                                    <input type="text" className="form-control" value={  formValue.entreprise} onChange={(event)=>handleChangeEntreprise(event,formValue,setShow_offre)}  />
                                    
                                    <input type="text" className="form-control" value={ formValue.poste} onChange={(event)=>handleChangePoste(event,formValue,setShow_offre)} />
                                    
                                    <input type="text" className="form-control" value={ formValue.secteur}onChange={(event)=>handleChangeSecteur(event,formValue,setShow_offre)}/>
                                    
                                    <input type="date" className="form-control" value={ formValue.disponible} onChange={(event)=>handleChangeDisponible(event,formValue,setShow_offre)} />
                                    
                                    <input type="text" className="form-control" value={ formValue.contrat} onChange={(event)=>handleChangeContrat(event,formValue,setShow_offre)} />
                                    
                                    <input type="text" className="form-control" value={  formValue.ville} onChange={(event)=>handleChangeVille(event,formValue,setShow_offre)} />


                               
                            </div>    




                    </div>
                        <div className="modal-footer">
                            <div><p className="text-success p-2 message">Les modifications à bien été prise en compte</p></div>
                        <button type="button" className="btn btn-warning" data-mdb-dismiss="modal" onClick={(e)=>{ setIsloading(false),document.querySelector(".message").classList.remove("update_Show")}}>
                        Fermer
                        </button>
                                <button type="button" className="btn btn-primary" onClick={(e) => { handleUpdate(e,formValue.id,show_offre)}} >Enregistrer</button>
                    </div>
                    </div>
                   
                </div>
            </div>

            <ModalAjouter />
                    
        </div>
    )
}

export default Offres;