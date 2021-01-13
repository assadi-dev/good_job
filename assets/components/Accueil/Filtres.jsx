import React, { Fragment } from 'react'

const Filtres = () => {
    return (
       
    <Fragment>
        <div class="col-sm-4 pt-3">

            <div class="card">
                <div class="p-3">
                    <h5 class="card-title">Filtrer par :</h5>
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item dropFilter">Contrats
                        <i class="fas fa-chevron-down float-end"></i>
                    </li>
                    <li class="list-group-item dropFilter">Secteur d'activité
                        <i class="fas fa-chevron-down float-end"></i>
                    </li>

                </ul>

            </div>

        </div>
    </Fragment>   
        
    )
}

export default Filtres;