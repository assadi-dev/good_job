import React,{useState,useRef,useEffect} from 'react';
import { host } from '../Api';
import axios from 'axios';
import dayjs from 'dayjs';
import './styles_recruteur.css'



const DataRecruteur = () => {

    const [recruteur, setRecruteur] = useState([]);
    const password = useRef();
    const confirmPassword = useRef()

    useEffect(() => {
        

        const fetchData = async () => {
            
            const url = host + "/api/recruteur/profile";
            let result = await axios.get(url);

            let cleanArray = [result.data];

            cleanArray.map(data => {
                let newDate = dayjs(data.create_at).format("DD-MM-YYYY");
                data.create_at = newDate;
                return data;
            })


            setRecruteur(cleanArray[0]);

           
        }
        fetchData()


    }, [])


    const handleUpdateRecruteur = event =>
    {   
        const target = event.target;
        const name = target.name;
        const value = target.value;

        setRecruteur({
            
            ...recruteur,
            [name]: value,
        });


        
    }


    const handleSubmitRecruteur = async (e, data) => {
        e.preventDefault();
        const url = host + "/api/recruteur/profile/" + data.id;
        await axios.put(url, {
            nom: data.nom,
            prenom: data.prenom,
            birth: data.birth,
            email: data.email,
            phone: data.phone,
            entreprise:data.entreprise
            
        })
            .then(res => {
                console.log(res.data)
                document.querySelector(".messageUpdateRecruteur").classList.add("showMessage");
                setTimeout(() => {
                    document.querySelector(".messageUpdateRecruteur").classList.remove("showMessage");
                },3500)
        })


    }

    const handleSubmitPassword = async (e) => {
        e.preventDefault();
        
       

        const url = host + "/api/candidat/connection/" + recruteur.email;

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
        <div>
            <div className="my-3 py-3">
                <h2>Infos personnel</h2>
            </div>
            <div className="container">
                <form action="" onSubmit={(e)=>handleSubmitRecruteur(e,recruteur)}>
                    <div className="form-group row mb-3">
                        <label htmlFor="nom" className="col-md-1 col-form-label">Nom : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="text" name="nom" id="nom" className="form-control" placeholder="Nom"  value={recruteur.nom} onChange={(e)=>handleUpdateRecruteur(e)}   />
                        </div>
                    </div>
                    <div className="form-group row mb-3">
                        <label htmlFor="prenom" className="col-md-1 col-form-label">Prénom : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="text" name="prenom" id="prenom" className="form-control" placeholder="Prénom"  value={recruteur.prenom} onChange={(e)=>handleUpdateRecruteur(e)}   />
                        </div>
                    </div>


                    <div className="form-group row mb-3">
                        <label htmlFor="birth" className="col-md-1 col-form-label">Né(e) le : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="date" name="birth" id="birth" className="form-control" placeholder="Date de naissance"  value={recruteur.birth} onChange={(e)=>handleUpdateRecruteur(e)}  />
                        </div>
                    </div>

                    <div className="form-group row mb-3">
                        <label htmlFor="entreprise" className="col-md-1 col-form-label">société : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="text" name="entreprise" id="entreprise" className="form-control" placeholder="Entreprise"  value={recruteur.entreprise} onChange={(e)=>handleUpdateRecruteur(e)}  />
                        </div>
                    </div>

                    <div className="form-group row mb-3">
                        <label htmlFor="email" className="col-md-1 col-form-label">Email : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="email" name="email" id="email" className="form-control" placeholder="Email"  value={recruteur.email} onChange={(e)=>handleUpdateRecruteur(e)}  />
                        </div>
                    </div>

                    <div className="form-group row mb-3">
                        <label htmlFor="phone" className="col-md-1 col-form-label">Téléphone : </label>
                        <div className="col-sm-5 col-md-3">
                            
                            <input type="tel" name="phone" id="phone" className="form-control" placeholder="Téléphone"  value={recruteur.phone} onChange={(e)=>handleUpdateRecruteur(e)} />
                        </div>
                    </div>
                    
                    <div className=" my-4 overflow-hidden">
                        <div className="mb-3">
                            <p className="text-success messageUpdateRecruteur"> Votre profile a été mise à jour</p>
                        </div>
                        <button type="submit" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                    </div>

                </form>

                <hr className="dropdown-divider my-3" />

                <form action="" method="post" onSubmit={(e)=>handleSubmitPassword(e) }  >
                <div className="mb-3">
                    <h5 id="passwordChange">Mot de passe</h5>
                </div>

                <div className="my-3">
                    <div className="col-sm-5 mb-3">
                        <input type="password" name="password" id="password" className="form-control" placeholder="Nouveau mot de passse"  ref={password} />

                    </div>

                    <div className="col-sm-5">
                        <input type="password" name="confirmPassword" id="confirmPassword" className="form-control" placeholder="Confirmez votre nouveau mot de passe" ref={confirmPassword}   />
                    </div>
                    
                </div>
                <div className="form-helper text-muted">Pour un mot de passe sécurisé nous vous recomandons  d'utiliser des majuscules, des miniscule, des chiffres et des caractères spéciaux</div>
                <div className="my-3 overflow-hidden">
                    <div className="mb-3">
                         <p  className="messageUpdatePassword"> Votre mot de passe a été mise à jour</p>
                    </div>
                    <button type="submit" className="btn btn-primary btn-rounded">Enregistrer les mofifications</button>
                </div>
            </form>

                <div className="my-3">
                    <p>inscrit depuis le : { recruteur.create_at }</p>
                </div>

            </div>
           
            
        </div>
    )
}

export default DataRecruteur 