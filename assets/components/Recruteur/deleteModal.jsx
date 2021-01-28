import React from 'react';
import { host } from "../Api";
import axios from 'axios';


const DeleteModal = ({ data }) => {
    
    const handleDelete = async (e, id) => {
        let url = host + "/api/recruteur/offres/delete/" + id;

        await axios.delete(url)
        .then(res => {

            console.log(res);
    
            console.log(res.data);
            setTimeout(() => {
                window.location = host + "/espace/recruteur/offres"
              }, 3000)
           
    
        })
        
       
    }

    return (
        <div
        class="modal fade"
        id="deleteModal"
        tabIndex="-1"
        aria-labelledby="exampleModalLabel"
        aria-hidden="true"
      >
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
        
              <button
                type="button"
                class="btn-close"
                data-mdb-dismiss="modal"
                aria-label="Close"
              ></button>
            </div>
            <div class="modal-body p-3">
                        <p>Voulez-vous supprimer { data.name}</p>  
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-mdb-dismiss="modal">
                Annuler
              </button>
              <button type="button" class="btn btn-primary"  onClick={(event)=>{handleDelete(event,data.id)}} >Confirmer</button>
            </div>
          </div>
        </div>
      </div>
    )
}

export default DeleteModal;