import React, { Fragment,useState } from 'react';
import { posteList } from './arrayList';
import { filterPoste } from '../redux/filtres/actionFltres';
import { useDispatch} from 'react-redux';

const InputSearch = () => {

	const [poste, setPoste] = useState("");
	const dispatch = useDispatch();

	const handlePoste = e => {
		let value = e.target.value;
		setPoste(value);
	}

	const searchPoste = () => {
		dispatch(filterPoste(poste)) 
	}
	
    return (
    <Fragment>
			<form className="input-group w-auto my-auto d-none d-sm-flex" >
				
				<input list="poste" autoComplete="off"  name="poste" type="search" className="form-control rounded" placeholder="Rechercher par poste" style={{minWidth: "125px"}} onChange={(e) => handlePoste(e)} />
				<span class="text-white input-group-text border-0 d-none d-lg-flex" onClick={searchPoste}>
					<i class="fas fa-search"></i>
				</span>
				<datalist id="poste"  >
					{
						posteList.map((data,index)=>(
							<option key={index} value={data}></option>
						))
					}
		
				</datalist>
			</form>

    </Fragment>
        
    )
};

export default InputSearch
