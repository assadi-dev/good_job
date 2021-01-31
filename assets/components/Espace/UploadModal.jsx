import React, { useRef}from 'react';
import Dropzone from 'react-dropzone-uploader';
import 'react-dropzone-uploader/dist/styles.css';
import './dropZoneSryle.css';
import { host } from '../Api';
import axios from 'axios';



const UploadModal = () => {


    let dropZoneContent = useRef();

  

    const getUploadParams = ({ meta }) => { return { url:"https://httpbin.org/post" } }

    // called every time a file's `status` changes
    const handleChangeStatus = ({ meta, file }, status) => {}

    // receives array of files that are done uploading when submit button is clicked
    const handleSubmit = (files, allFiles) => {
        let data = [];
        files.map(f => {
            let extension = f.meta.name.split(".")
            data.push({nom:f.meta.name,type:f.meta.type,extension:extension[1]})
        })
        
        console.log(data)
        const url = host + "/api/upload/";
        axios.post(url, {
           data
        })
        .then(function (response) {
            console.log(response);
          })
          .catch(function (error) {
            console.log(error);
          });


    allFiles.forEach(f => f.remove())
    }




return (
<div className="modal fade" id="uploadFilesModal" data-mdb-backdrop="static" data-mdb-keyboard="false" tabindex="-1"
    aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div className="modal-dialog modal-dialog-centered">
        <div className="modal-content">
            <div className="modal-header">
                <h5 className="modal-title" id="exampleModalLabel">Ajouter Fichiers</h5>
                <button type="button" className="btn-close" data-mdb-dismiss="modal" aria-label="Close"></button>
            </div>
            <div className="modal-body">
                <form action="">
                        <Dropzone
                            
                            ref={dropZoneContent}
                            submitButtonContent="Envoyer"
                            inputWithFilesContent="Ajouter fichier "
                            inputContent = {<p className="text-center my-3"> <i className="fas fa-file-upload fa-2x"> </i> <br/> Glissez votre fichier ici <br/> ou cliquez pour ajouter un fichier</p> }
                            
                            onChangeStatus={handleChangeStatus}
                            onSubmit={handleSubmit}
                            accept="application/pdf,application/vnd.oasis.opendocument.text,application/vnd.oasis.opendocument.presentation,application/vnd.openxmlformats-officedocument.wordprocessingml.document,application/msword" />
                </form>
            </div>
        </div>
    </div>
</div>
)
}

export default UploadModal;