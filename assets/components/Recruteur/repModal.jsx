import axios from 'axios';
import React ,{useState,useEffect} from 'react';
import { host } from '../Api';





const ReponseModal = ({ data }) => {

const [reponse, setRepnse] = useState("Candidature en cours");


const handleGetReponse = (event)=> {
let rep = event.target.value;
setRepnse(rep);

}

const handleSendReponse = async (e, id,rep) => {
    let url = host + "/api/recruteur/candidatures/edit/" + id;

   await axios.put(url, {
        reponse:rep
    })
    .then(res => {
        console.log(res);
        document.querySelector(".message").classList.add("add_Show");

    setTimeout(() => {
        window.location = host + "/espace/recruteur/candidatures";
        }, 3000)
    })
    }

    const handleRemoveMessage = () =>
    {
        document.querySelector(".message_add").classList.remove("add_Show")
    }


    


return (

data.map((data,index) => (
<div key={index}>
    <div className="modal fade" id="repModal" tabIndex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div className="modal-dialog modal-dialog-centered modal-dialog-scrollable">
            <div className="modal-content">
                <div className="modal-header">
                    <h5 className="modal-title" id="exampleModalLabel">{ data.offre.name}</h5>
                    <button type="button" className="btn-close" data-mdb-dismiss="modal" aria-label="Close" onClick={handleRemoveMessage}></button>
                </div>
                <div className="modal-body">

                    <div>
                        <p><span className="font-weight-bold">Poste: </span> {data.offre.poste}</p>
                        <p><span className="font-weight-bold">Pour le: </span> {data.offre.disponible}</p>

                    </div>

                    <p> <span className="font-weight-bold">Candidat: </span> {data.candidat.prenom + " " +
                        data.candidat.nom}</p>
                    <div className="row">
                        <div className="col-sm-6">
                            <p><span className="font-weight-bold">Email: </span> {data.candidat.email}</p>
                        </div>
                        <div className="col-sm-5">
                            <p><span className="font-weight-bold">Tél: </span> {data.candidat.phone}</p>
                        </div>
                    </div>

                    <div>
                        <p><span className="font-weight-bold">Réponse: </span></p>
                        <select name="reponse" id="reponse" className="form-control font-weight-bold" onChange={(e)=>handleGetReponse(e)}
                            >
                            <option className="font-weight-bold text-warning" value="Candidature en cours">Candidature en cours</option>
                            <option className="font-weight-bold text-success"  value="Accépté">Accépter</option>
                            <option className="font-weight-bold text-danger" value="Refusé">Refuser</option>
                        </select>
                    </div>

                    <div className="my-2">
                        <p className="text-success message">Reponse envoyé</p>
                    </div>

                </div>
                <div className="modal-footer">
                    <button type="button" className="btn btn-danger" data-mdb-dismiss="modal" onClick={handleRemoveMessage}>
                        Fermer
                    </button>
                    <button type="button" className="btn btn-success" onClick={(e)=>handleSendReponse(e,data.id,reponse)
                        }>Envoyer</button>
                </div>
            </div>
        </div>
    </div>
</div>

))
)
}

export default ReponseModal;