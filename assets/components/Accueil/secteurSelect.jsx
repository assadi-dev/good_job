import React, { Fragment, useState } from 'react';
import { useSelector,useDispatch } from 'react-redux';
import { secteurList } from './arrayList';
import {filterSecteur} from '../redux/filtres/actionFltres';

const SecteurSelect = () => {

    const [secteuValue, setSecteurValue] = useState("Tout");
    const dispatch = useDispatch();
    secteurList.sort();

    const secteurFiltre = e => {

        let value = e.target.value;
        setSecteurValue(value);
    }

  
    

    return (
        <Fragment >
        <div className="input-group my-3">
                <select name="secteur" id="" className="form-control" onChange={(e) => { secteurFiltre(e) }} >

                    <option value="Tout" defaultValue >Afficher Tout</option>
                    {
                        secteurList.map((v,index) => (
                            <option key={index} value={v} >{ v}</option>
                        ))
                    }
          
            </select>
            
        </div>
        <div className="input-group my-3">
            <button className="btn btn-primary" onClick={(e) => {dispatch(filterSecteur(secteuValue)) }} >Filtrer</button>
        </div>
    </Fragment>
    )
}

export default  SecteurSelect 