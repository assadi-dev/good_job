import React ,{Fragment,useState} from 'react';
import { useSelector,useDispatch } from 'react-redux';
import { contratList } from './arrayList';
import {filterContrat} from '../redux/filtres/actionFltres';

const ContratSelect = () => {

    const [listContrat, setListContrat] = useState(
        {
            CDD: null,
            CDI: null,
            Alternance: null,
            Stage: null
        });
    
    const dispatch = useDispatch();

    const contratFiltre = (e) => {

        let isChecked = e.target.checked;
        let target = e.target;
        let value = target.value;
        let name = target.name;

        if (isChecked) {


            setListContrat({ ...listContrat, [value]: value });


        } else {

            setListContrat({ ...listContrat, [value]: null });



        };



    };


    return (
    
        <Fragment>
            {contratList.map((v,index) => (
                <div key={index} className="form-check my-3">
                    <input name="contrat" type="checkbox" id={v.toLowerCase()} className="form-check-input" value={v} onChange={(e) => contratFiltre(e)} />
                    <label className="form-check-label" htmlFor={v.toLowerCase() } >
                        {v}
                    </label>
                </div>
            ))}

            <div className="input-group py-3 ">
                <button className="btn btn-primary" onClick={(e) => { dispatch(filterContrat(listContrat)); }} >Filtrer</button>
            </div>


        </Fragment>

    )
};

export default ContratSelect;