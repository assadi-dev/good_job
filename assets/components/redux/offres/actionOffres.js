import axios from 'axios';
import dayjs from 'dayjs';
import { LOADER_OFFRES, LOADER_OFFRES_ERROR, LOADER_OFFRES_SUCCESS } from './types';
import { host } from '../../Api';

const loadApiOffres = () => {

    return {
        type: LOADER_OFFRES
    }
}


const loadApiOffresSuccess = (offres) => {

    return {
        type: LOADER_OFFRES_SUCCESS, 
        payload:offres
    }
}


const loadApiOffresError = (error) => {

    return {
        type: LOADER_OFFRES_ERROR,
        payload:error
    }
}

export const apiCall = (dataFilter) => {
   
    const contratFilter = dataFilter.contrat;
    const secteurFilter = dataFilter.secteur;
    const posteFilter = dataFilter.poste;

    return dispatch => {
        dispatch(loadApiOffres())

        let url = host + "/api/offres";
        const urlFavori = host + "/api/favories/";
        

       axios.get(url)
            .then(result => {
                let cleanResult = result.data;

                cleanResult.map(offre => {
                    let newDate = dayjs(offre.create_at).format("DD-MM-YYYY");
                    
                        offre.create_at = newDate;
                        
                
                    return offre;
                    

                })

                axios.get(urlFavori).then(favories =>{
                    let dataFavorie = favories.data;
                
                    cleanResult.map(offre => {
                    
                     dataFavorie.forEach(element => {
        

                    
                    if (offre.id == element.offre.id)
                    {
                        Object.assign(offre, { isFavorie: true })
                        
                        
                    } 
        
                
                    })
                            
                        return offre
                
                
                    })

                    let secteur = secteurFilter

                    let poste = posteFilter;

                    let resultFiltreS = cleanResult.filter(v => v.poste == poste)
                    if (!poste) {
                        resultFiltreS =  cleanResult
                    }
                  

                    let resultFiltre = resultFiltreS.filter(v => v.secteur == secteur)
                    if (secteur == "Tout") {
                        resultFiltre = resultFiltreS 
                    }
                    
                    let resultFiltreC = resultFiltre.filter(v => v.contrat == contratFilter.CDD || v.contrat == contratFilter.CDI || v.contrat == contratFilter.Alternance || v.contrat == contratFilter.Stage   )
                    //console.log(resultFiltreC);

                
                    if (contratFilter.CDD == null && contratFilter.CDI == null && contratFilter.Alternance == null &&  contratFilter.Stage == null   ) {
                      
                        dispatch(loadApiOffresSuccess(resultFiltre))
                    } else {
                        dispatch(loadApiOffresSuccess(resultFiltreC ))
                       
                    }
                
    
                })
                
                





            })
            .catch(error => {
                dispatch(loadApiOffresError(error.message))
            })
        
        	
 
        
        
        
    }

}