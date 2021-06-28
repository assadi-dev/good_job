import React, { useState, useEffect,useRef } from 'react';
import axios from 'axios';
import dayjs from 'dayjs';
import { Link } from 'react-router-dom';
import { host } from '../Api';
import { useSelector, useDispatch ,connect} from 'react-redux';
import { apiCall } from '../redux/offres/actionOffres';






const ListOffres = () => {

	
	const apiData = useSelector(state => state.offres.offres);
	const dataFiltres = useSelector(state => state.filtres);
	const dispatch = useDispatch();

	


	const [action, setAction] = useState(false);
	const favorie_btn = useRef()

	const url = host + "/api/offres";
	const urlFavori = host + "/api/favories/";
	

	const addFvorie = async (e, id, isFavorie) => {
		e.preventDefault();
		console.log(id);
		
		if (isFavorie == true) {
			await axios.post(urlFavori + "delete/", {
				offre_id: id,
				
			})
				.then(resp => {
					console.log(resp.data)
					setAction(true);
					setTimeout(() => {
						setAction(false);
					}, 2500)
				})
		
		} else {
			await axios.post(urlFavori, {
				offre_id: id,
				
			})
				.then(resp => {
					console.log(resp.data)
					setAction(true);
					setTimeout(() => {
						setAction(false);
					}, 2500)
				})
		};
		
	
	
	};

	useEffect(() => {


	
		dispatch(apiCall(dataFiltres))



	}, [dataFiltres, action]);

	return (
		<div className="col-sm">

			{
				apiData.map((item, index) => (

					<div key={index} className="card my-3 position-relative">
						<div className="d-flex">

							<a href="" className="linkAddFavori" onClick={(e) => addFvorie(e, item.id, item.isFavorie)}>
								<span className="favoris_btn">
					

									<i className={item.isFavorie == true ? "fas fa-heart addedFavorie" : "far fa-heart"}></i>
								</span>
							</a>

							<div className="pictureEntreprise col-3 col-sm-2 text-center p-3">
								<img src="https://mdbootstrap.com/img/logo/mdb192x192.jpg" className="img-fluid" alt="Logo Societé" />
							</div>
							<div className="col-sm-7 pt-3 ">
								<p className="mb-0"></p>
								<h5 className="offre_title">{item.name}</h5>
								<div className="d-flex justify-content-start offre_description">
									<span className="cdi_icon">
										<i className="fas fa-clipboard-list"></i>
										{item.contrat}</span>
									<span className="map_icon">
										<i className="fas fa-map-marker-alt"></i>
										{item.ville}</span>
								</div>
								<span className=" text-muted offre_description">{item.create_at}</span>

							</div>
							<div className="showOffre_btn_pos col-sm-3 pt-3 d-flex justify-content-sm-evenly">

								<button
									className="btn btn-primary btn-rounded my-auto"
					
									onClick={() => window.location.href = `${host}/offre/${item.id}`}
					
								>
									<span className="text_button" >voir l'offre</span>
								</button>

							</div>
						</div>

					</div>

				))
			}





		</div>

	)


};


export default ListOffres;