import React, { useState, useEffect,useReducer } from 'react';
import axios from 'axios';
import { handleChangeContrat, handleChangeDisponible, handleChangeEntreprise, handleChangeNom, handleChangePoste,
handleChangeSecteur, handleChangeVille } from './actionForm';
import { host } from '../Api';

const ModalAjouter = () => {

const [submitting, setSubmitting] = useState(false);
const [offresData, setOffresData] = useState({
name: "",
entreprise : "",
poste :"",
secteur :"" ,
disponible:"",
contrat:"",
ville:""
});


const handleChangeAdd = event => {

const target = event.target;
const value = target.value;
    const name = target.name;
    
setOffresData({
...offresData,
[name]: value,


});

}

const handleSubmit = async (event,data) => {
    event.preventDefault();
   
    const url = host + "/api/recruteur/offres/create/";

    let result = await axios.post(url, {
    name: data.name,
    entreprise : data.entreprise,
    poste : data.poste,
    secteur : data.secteur,
    disponible:data.disponible,
    contrat:data.contrat,
    ville:data.ville
    })
    
   console.log(result)
   document.querySelector(".message_add").classList.add("add_Show");

   
   setTimeout(() => {
    window.location = host + "/espace/recruteur/offres"
  }, 3000)
 }
    
    

useEffect(() => {
    setSubmitting(false);
}, [])


const handleAdd = async (e,data) => {

const url = host + "/api/recruteur/offres/create/";

let result = await axios.post(url, {
name: data.name,
entreprise : data.entreprise,
poste : data.poste,
secteur : data.secteur,
disponible:data.disponible,
contrat:data.contrat,
ville:data.ville
})





console.log(result)
document.querySelector(".message_add").classList.add("add_Show");

}


return (
<div className="modal fade" id="staticBackdropAdd" data-mdb-backdrop="static" data-mdb-keyboard="false" tabIndex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <form action="" onSubmit={(e)=>handleSubmit(e,offresData)} >
    <div className="modal-dialog modal-dialog-scrollable modal-lg">

        <div className="modal-content">
            <div className="modal-header">
                <h5 className="modal-title" id="staticBackdropLabel">Ajouter une offre</h5>
                <button type="button" className="btn-close" data-mdb-dismiss="modal" aria-label="Close"
                    onClick={(e)=>{document.querySelector(".message_add").classList.remove("add_Show")}}
                    ></button>
            </div>
            <div className="modal-body">

                <div>


                    <input type="text" className="form-control" name="name" onChange={(event)=>handleChangeAdd(event)} placeholder="Intitulé de l'offre"
                    />

                    <input type="text" className="form-control" name="entreprise"
                        onChange={(event)=>handleChangeAdd(event)} placeholder="Entreprise" />

                    <input type="text" className="form-control" name="poste" onChange={(event)=>handleChangeAdd(event)}
                    placeholder="Poste" />

                    <input type="text" className="form-control" name="secteur"
                        onChange={(event)=>handleChangeAdd(event)} placeholder="Secteur d'activité" />

                    <input type="date" className="form-control" name="disponible"
                        onChange={(event)=>handleChangeAdd(event)} placeholder="Date de disponibilité" />

                    <input type="text" className="form-control" name="contrat"
                        onChange={(event)=>handleChangeAdd(event)} placeholder="Type de contrat" />

                    <input type="text" className="form-control" name="ville" onChange={(event)=>handleChangeAdd(event)}
                   placeholder="Ville" />



                </div>




            </div>
            <div className="modal-footer">
                <div>
                    <p className="text-success p-2 message_add">L'annonce à bien été crée</p>
                </div>
                <button type="button" className="btn btn-warning" data-mdb-dismiss="modal" onClick={(e)=>{
                    document.querySelector(".message_add").classList.remove("add_Show")}}>
                    Fermer
                </button>
                <button type="submit" className="btn btn-primary" 
                    >Enregistrer</button>
            </div>
        </div>

    </div>
    </form>
</div>

)
}

export default ModalAjouter