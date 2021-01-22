import React ,{Fragment, useEffect,useState,useRef} from 'react';
import axios from 'axios';
import {host} from '../Api';
import { Link, useLocation } from 'react-router-dom';
import { supprimer } from './actions';
import UploadModal from './UploadModal';

const Uploads = () => {

const [uploadData, setUploadData] = useState([]);
    const [statut, setStatut] = useState("inactif");
    const [linkFile,setlinkFile] = useState("")
   

    let location = useLocation();
    var currentFile = useRef();

    const deleteFiles = (id,e) => {
        e.preventDefault();
        let url = host + "/api/upload/"+id
        console.log(url)

        axios.delete(url)
        .then(res => {

            console.log(res);
    
            console.log(res.data);
    
            setStatut("supprimé")
    
           
    
          })
       
    
    }



useEffect(() => {
        
   

    const fetchData = async () => {
    
        //target.removeEventListener()
//obtenir le hostName du serveur en javaScript (window.location.host)
        
      
        
    let url = `${host}/api/upload`;
    console.log(url)
   

let result = await axios.get(url)
    let cleanResult = result.data;
    
  


//$urlFile retourn le chemin complet du fichier à partire du nom de domain du serveur
cleanResult.map(upload => {
let urlFile = host + "/uploads/" + upload.chemin;
upload.chemin = urlFile;
return upload;
});

setUploadData(cleanResult);
}

    fetchData();

    if (statut != "inactif") {
        setStatut("inactif")
    }
    
   

}, [statut])
    




return (
<Fragment>
    <h5 className="card-title">Mes fichiers</h5>

    <div className="my-2">

        <button className="btn btn-success btn-rounded"  data-mdb-toggle="modal" data-mdb-target="#uploadModal">
            Ajouter un document
        </button>

        <div className="card-text">
            <div className="row col">

                <table className="table text-center">
                    <thead>
                        <tr>
                            <th scope="col">nom</th>
                            <th scope="col">type</th>
                            <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                        {uploadData.map((upload, index) => (

                        <tr key={upload.id}>

                            <td>{upload.name}</td>
                            <td>{upload.type}</td>
                            <td className="p-3 d-flex justify-content-center">
  
                                    <Link className="text-primary me-3"
                                      
                                        to={{
                                           pathname:upload.chemin
                                        }}
                                        target="_blank"
                                       
                                    >
                                    afficher
                                    </Link>
                                    
                                    <a
                                        ref={currentFile}
                                        className="text-danger deleteFile"
                                        href={host + "/api/upload/" + upload.id}
                                        onClick = {(e)=> deleteFiles(upload.id,e)}
                                       
                                    >supprimer</a>

                                    

                            </td>
                        </tr>

                        ))}




                    </tbody>
                </table>

            </div>

        </div>

        </div>
        
</Fragment>

)
}

export default Uploads;