import initialState from '../../store/initialState';
import { CONTRAT,SECTEUR,POSTE } from './types';


const filtreReducer = (state = initialState, action) => {
    switch (action.type) {
        case CONTRAT: {

    
            return {
                ...state,
                contrat: action.payload
            }
        }
        case SECTEUR: {
            return {
                ...state,
                secteur: action.payload
            }
        }
            
        case POSTE: {
            return {
                ...state,
                poste: action.payload
            }
         }
            
        default:
            return state
    }
    
}

export default filtreReducer