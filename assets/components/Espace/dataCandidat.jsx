import React,{useState,useEffect,useRef} from 'react';
import { host } from '../Api';
import axios from 'axios';
import dayjs from 'dayjs';
import './espaceCandidat.css';

const DataCandidat = () => {

    const [candidat, setCandidat] = useState([]);
    const password = useRef();
    const confirmPassword= useRef()


    useEffect(() => {

      const fetchData = async () => {
        let url = host + "/api/candidat/profile";
          let result = await axios.get(url);

          let cleanResult = [result.data];


          cleanResult.map(element => {
              let newDate = dayjs(element.created_at).format("YYYY-MM-DD");
              element.created_at = newDate

            return element;
             
          });


          
          setCandidat(cleanResult[0]);
          
        }
        fetchData() 
    }, []);



    

    const handleUpdateCandidat = event =>
    {   
        const target = event.target;
        const name = target.name;
        const value = target.value;

        setCandidat({
            
            ...candidat,
            [name]: value,
        });


        
    }


    const handleSubmitCandidat = async (e,data) =>
    {
        e.preventDefault();
        const url = host + "/api/candidat/profile/" + data.id;
        await axios.put(url, {
            nom: data.nom,
            prenom: data.prenom,
            birth: data.birth,
            email: data.email,
            phone:data.phone
        })
            .then(res => {
                console.log(res.data)
                document.querySelector(".messageUpdateCandidat").classList.add("showMessage");
                setTimeout(() => {
                    document.querySelector(".messageUpdateCandidat").classList.remove("showMessage");
                },3500)
        })
    }



    const handleSubmitPassword = async (e) => {
        e.preventDefault();
        
       

        const url = host + "/api/candidat/connection/" + candidat.email;

        await axios.put(url, {
            password: password.current.value,
            confirmPassword: confirmPassword.current.value
        })
            .then(res => {
                console.log(res.data)
                document.querySelector(".messageUpdatePassword").textContent = "Votre mot de passe a été mise à jour"
                document.querySelector(".messageUpdatePassword").classList.add("text-success");
                document.querySelector(".messageUpdatePassword").classList.add("showMessage");
                password.current.value = ""
                confirmPassword.current.value =""
                setTimeout(() => {
                    document.querySelector(".messageUpdatePassword").classList.remove("text-success");
                    document.querySelector(".messageUpdatePassword").classList.remove("showMessage");
                },3500)
            })
            .catch((error) => {
                console.error(error);
                document.querySelector(".messageUpdatePassword").textContent = "Veuillez confirmez votre mot de passe "
                document.querySelector(".messageUpdatePassword").classList.add("text-danger");
                document.querySelector(".messageUpdatePassword").classList.add("showMessage");
                setTimeout(() => {
                    document.querySelector(".messageUpdatePassword").classList.remove("text-danger");
                    document.querySelector(".messageUpdatePassword").classList.remove("showMessage");
                },3500)

            })


    }



    return (
        <div className="my-3">
            <form action="" onSubmit={(e)=>handleSubmitCandidat(e,candidat)} >
                <div className="row">
                    <div className="col-sm-5"> 
                        <input type="text" name="nom" id="nom" className="form-control" placeholder="Nom" value={candidat.nom} onChange={(e)=>handleUpdateCandidat(e)} />
                    </div>

                    <div className="col-sm-5">
                        <input type="text" name="prenom"  id="prenom" className="form-control" placeholder="Prénom" value={candidat.prenom} onChange={(e)=>handleUpdateCandidat(e)} />
                    </div>
                </div>
                <div className="row my-3">
                    <div className="col-sm-5">
                        <input type="email" name="email" id="nom" className="form-control" placeholder="Adresse email" value={candidat.email} onChange={(e)=>handleUpdateCandidat(e)} required />
                    </div>

                    <div className="col-sm-5">
                        <input type="tel" name="phone" id="phone" className="form-control" placeholder="N° Téléphone" value={candidat.phone} onChange={(e)=>handleUpdateCandidat(e)} required /> 
                    </div>
                </div>

                <div className="row my-3">
                    <div className="col-sm-5">
                        <input type="date" name="birth" id="birth" className="form-control" placeholder="Date de naissance" value={candidat.birth} onChange={(e)=>handleUpdateCandidat(e)} />
                    </div>
                </div>

                <div className="form-group row">
                <label htmlFor="ceated" className="col-md-1 col-form-label">Créer le : </label>
                    <div className="col-sm-5 col-md-4">
                        
                        <input type="date" id="ceated" className="form-control" placeholder="Date de creation" readOnly value={candidat.created_at}  />
                    </div>
                </div>
                <div className="text-center my-4 overflow-hidden">
                    <div className="my-3 text-center">
                        <p className="text-success messageUpdateCandidat"> Votre profile a été mise à jour</p>
                    </div>
                <button type="submit" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                </div>

            </form>

            <hr className="dropdown-divider my-3" />
            <form action="" method="post" onSubmit={(e) =>handleSubmitPassword(e)} >
                <div className="mb-3">
                    <h5 id="passwordChange">Mot de passe</h5>
                </div>

                <div className="my-3">
                    <div className="col-sm-5 mb-3">
                        <input type="password" name="password" id="password" className="form-control" placeholder="Nouveau mot de passse" ref={password}  />

                    </div>

                    <div className="col-sm-5">
                        <input type="password" name="confirmPassword" id="confirmPassword" className="form-control" placeholder="Confirmez votre nouveau mot de passe" ref={confirmPassword}  />
                    </div>
                    
                </div>
                <div className="form-helper text-muted">Pour un mot de passe sécurisé nous vous recomandons  d'utiliser des majuscules, des miniscule, des chiffres et des caractères spéciaux</div>
                <div className="text-center my-3 overflow-hidden">
                    <div className="my-3">
                         <p  className="messageUpdatePassword"> Votre mot de passe a été mise à jour</p>
                    </div>
                    <button type="submit" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                </div>
            </form>
        </div>



       

        
        
    )
}

export default DataCandidat