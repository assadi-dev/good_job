import React, { useState, useEffect } from 'react';
import axios from 'axios';
import dayjs from 'dayjs';
import { Link } from 'react-router-dom';
import {host} from '../Api';


const ListFavories = () => {

const [isFavori, seIsFavori] = useState(false);

	const [offres, setOffres] = useState([]);
	
	const [action, setAction] = useState(false);

const url = host+"/api/favories/";

	const removeFvorie = async (e, id) =>
	{
		e.preventDefault();
		console.log(id);
		await axios.delete(url+id)
			.then(res => {
				setAction(true);
		})
		

		

		setTimeout(() => {
			setAction(false);
		}, 1500)
	}

useEffect(() => {

const fetchData = async () => {

let result = await axios.get(url)


let cleanResult = result.data;

cleanResult.map(offre => {
let newDate = dayjs(offre.offre.create_at).format("DD-MM-YYYY");

offre.offre.create_at = newDate

return offre;
})

setOffres(cleanResult);


}

fetchData();

}, [action==false])

return(
<div className="col-sm">

	{
	offres.map((item, index) => (

	<div key={index} className="card my-3 position-relative">
		<div className="d-flex">

			<span  className="linkAddFavori" onClick={(e)=> removeFvorie(e,item.id)}>
				<span className="favoris_btn">

					<i className={ "fas fa-heart addedFavorie"  }></i>
				</span>
			</span>

			<div className="pictureEntreprise col-3 col-sm-2 text-center p-3">
				<img src="https://mdbootstrap.com/img/logo/mdb192x192.jpg" className="img-fluid" alt="Logo Societé" />
			</div>
			<div className="col-sm-7 pt-3 ">
				<p className="mb-0"></p>
				<h5 className="offre_title" >{item.offre.name }</h5>
				<div className="offre_description d-flex justify-content-start">
					<span className="cdi_icon">
						<i className="fas fa-clipboard-list"></i>
						{ item.offre.contrat}</span>
					<span className="map_icon">
						<i className="fas fa-map-marker-alt"></i>
						{ item.offre.ville}</span>
				</div>
				<span className="text-muted offre_description" >{item.offre.create_at }</span>

			</div>
			<div className="showOffre_btn_pos col-sm-3 pt-3 d-flex justify-content-sm-evenly">

					<button
						className="btn btn-primary btn-rounded my-auto text_button"
					
						onClick={()=> window.location.href = `/offre/${item.offre.id}`}
					
					>
						<span>voir l'offre</span> 
				</button>

			</div>
		</div>

	</div>

	))
	}





</div>

)


}

export default ListFavories;