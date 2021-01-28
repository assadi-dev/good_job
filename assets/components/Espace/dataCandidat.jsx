import React,{useState,useEffect} from 'react';
import { host } from '../Api';
import axios from 'axios';
import dayjs from 'dayjs';

const DataCandidat = () => {

    const [candidat, setCandidat] = useState([]);

    useEffect(() => {

      const fetchData = async () => {
        let url = host + "/api/candidat/profile";
          let result = await axios.get(url);

          let cleanResult = [result.data];

          //console.log(cleanResult)

          cleanResult.map(element => {
              let newDate = dayjs(element.created_at).format("YYYY-MM-DD");
              element.created_at = newDate

            return element;
             
          });


          
          setCandidat(cleanResult[0]);
          
        }
        fetchData() 
    }, [])

    return (
        <div className="my-3">
            <form action="">
                <div className="row">
                    <div className="col-sm-5"> 
                        <input type="text" name="name" id="nom" className="form-control" placeholder="Nom" value={candidat.nom} />
                    </div>

                    <div className="col-sm-5">
                        <input type="text" id="prenom" className="form-control" placeholder="Prénom" value={candidat.prenom} />
                    </div>
                </div>
                <div className="row my-3">
                    <div className="col-sm-5">
                        <input type="email" name="email" id="nom" className="form-control" placeholder="Adresse email" value={candidat.email} />
                    </div>

                    <div className="col-sm-5">
                        <input type="tel" name="phone" id="phone" className="form-control" placeholder="N° Téléphone" value={candidat.phone} />
                    </div>
                </div>

                <div className="row my-3">
                    <div className="col-sm-5">
                        <input type="date" name="birth" id="birth" className="form-control" placeholder="Date de naissance" value={candidat.birth} />
                    </div>
                </div>

                <div className="form-group row">
                <label htmlFor="ceated" className="col-sm-1 col-form-label">Créer le : </label>
                    <div className="col-sm-3">
                        
                        <input type="date" id="ceated" className="form-control" placeholder="Date de creation" readOnly value={candidat.created_at}  />
                    </div>
                </div>
                <div className="text-center my-3">
                <button type="button" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                </div>

            </form>

            <hr className="dropdown-divider my-3" />
            <form action="" method="post" >
                <div className="mb-3">
                    <h5 id="passwordChange">Mot de passe</h5>
                </div>

                <div className="my-3">
                    <div className="col-sm-5 mb-3">
                        <input type="password" name="password" id="password" className="form-control" placeholder="Nouveau mode de passse" />

                    </div>

                    <div className="col-sm-5">
                    <input type="password" name="password" id="password" className="form-control" placeholder="Confirmez votre nouveau mot de passe" />
                    </div>
                </div>
                <div className="form-helper">Pour un mot de passe sécurisé nous vous recomandons  d'utiliser des majuscules, des miniscule, des chiffres et des caractères spéciaux</div>
                <div className="text-center my-3">
                    <button type="button" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                </div>
            </form>
        </div>



       

        
        
    )
}

export default DataCandidat