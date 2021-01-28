import React, { useState, useEffect } from 'react';
import axios from 'axios';
import dayjs from 'dayjs';
import { Link } from 'react-router-dom';
import {host} from '../Api';
import { element } from 'prop-types';


const ListOffres = () => {



	const [offres, setOffres] = useState([]);
	const [favories, setFavories] = useState([]);

	const url = host + "/api/offres";
	const urlFavori = host+"/api/favories";

	const addFvorie = (e, id) =>
	{
		e.preventDefault();
	
	}

useEffect(() => {

const fetchData = async () => {

	let result = await axios.get(url)
	
	let favories = await axios.get(urlFavori)


	let cleanResult = result.data;
	let dataFavorie = favories.data;
	setFavories(dataFavorie);

cleanResult.map(offre => {
let newDate = dayjs(offre.create_at).format("DD-MM-YYYY");

	offre.create_at = newDate;



return offre;
})

	

	cleanResult.map(offre => {
				
		dataFavorie.forEach(element => {

			//console.log(offre.id + "-"+ element.offre.id)
			
			if (offre.id == element.offre.id)
			{
				Object.assign(offre, { isFavorie: true })
				
				
			} 
			
			
		})
			
		return offre


	})

	
	setOffres(cleanResult);
	

	





}

fetchData();

}, [])

return(
<div className="col-sm">

	{
	offres.map((item, index) => (

	<div key={index} className="card my-3 position-relative">
		<div className="d-flex">

			<a href="" className="linkAddFavori" onClick={(e)=> addFvorie(e,item.id)}>
				<span className="favoris_btn">
					

					<i className={ item.isFavorie==true? "fas fa-heart addedFavorie" : "far fa-heart" }></i>
				</span>
			</a>

			<div className="pictureEntreprise col-sm-2 text-center p-3">
				<img src="https://mdbootstrap.com/img/logo/mdb192x192.jpg" className="img-fluid" alt="Logo Societé" />
			</div>
			<div className="col-sm-7 pt-3 ">
				<p className="mb-0"></p>
				<h5>{item.poste }</h5>
				<div className="d-flex justify-content-start">
					<span className="cdi_icon">
						<i className="fas fa-clipboard-list"></i>
						{ item.contrat}</span>
					<span className="map_icon">
						<i className="fas fa-map-marker-alt"></i>
						{ item.ville}</span>
				</div>
				<span>{item.create_at }</span>

			</div>
			<div className="col-sm-2 pt-3 d-flex justify-content-sm-evenly">

					<button
						className="btn btn-primary btn-rounded my-auto"
					
						onClick={()=> window.location.href = `/offre/${item.id}`}
					
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

export default ListOffres;