import React from 'react'

const CarousselOffres = () => {
    return (
        <div className="carouselContain">
            <div className="main-carousel">
                <div className="carousel-cell">
                    <div className="card carousel-offre">

                        <div className="card-body">
                            <span>Entreprise</span>
                            <h5 className="card-title">Poste</h5>
                            <div className="d-flex justify-content-start">
                                <span className="cdi_icon">
                                    <i className="fas fa-clipboard-list"></i>CDI</span>
                                <span className="map_icon">
                                    <i className="fas fa-map-marker-alt"></i>Rennes</span>


                            </div>
                            <span>21/01/2021</span>
                            <div className="pt-3 d-flex justify-content-sm-evenly">

                                <a href="#" className="btn btn-primary btn-rounded my-auto">
                                    voir l'offre
                        </a>

                            </div>


                        </div>
                    </div>

                </div>


            </div>
        </div>

    )
};

export default CarousselOffres;