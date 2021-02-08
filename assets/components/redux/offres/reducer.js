import { LOADER_OFFRES, LOADER_OFFRES_ERROR, LOADER_OFFRES_SUCCESS } from './types';

const initialState = {
    isLoading: false,
    offres: [],
    error: ''
}

const offreReducer = (state = initialState, action) => {
    switch (action.type) {
        case LOADER_OFFRES:
            return {
                ...state,
                isLoading:true
            }
        case LOADER_OFFRES_SUCCESS:
            return {
                ...state,
                isLoading: false,
                offres: action.payload,
                error: ''
            }
        case LOADER_OFFRES_ERROR:
            return {
                ...state,
                isLoading: false,
                offres: [],
                error: action.payload
            }
        default : return state
       }
    
}

export default  offreReducer