import { CONTRAT, SECTEUR ,POSTE} from './types';
import { LOADER_OFFRES, LOADER_OFFRES_ERROR, LOADER_OFFRES_SUCCESS } from '../offres/types';
import {apiCall} from '../offres/actionOffres'
import axios from 'axios';
import dayjs from 'dayjs';
import { host } from '../../Api';




export const filterContrat = (contrat) => {



    return {
        type: CONTRAT,
        payload:contrat
    }


}


export const filterSecteur = (secteur) => {



    return {
        type: SECTEUR,
        payload:secteur
    }


}

export const filterPoste = (poste) => {



    return {
        type: POSTE,
        payload:poste
    }


}




