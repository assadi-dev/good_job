import React from 'react'



export const handleChangeNom = (event,formValue,setShow_offre) =>
{
    let nom = event.target.value
    formValue.name = nom
    setShow_offre(formValue)
    
}



export const handleChangeEntreprise = (event,formValue,setShow_offre) =>
{
    let entreprise = event.target.value
    formValue.entreprise = entreprise
    setShow_offre(formValue)
    
}

export const handleChangePoste = (event,formValue,setShow_offre) =>
{
    let poste = event.target.value
    formValue.poste = poste
    setShow_offre(formValue)
    
}

export const handleChangeSecteur = (event,formValue,setShow_offre) =>
{
    let secteur = event.target.value
    formValue.secteur = secteur
    setShow_offre(formValue)
    
}



export const handleChangeDisponible = (event,formValue,setShow_offre) =>
{
    let disponible= event.target.value
    formValue.disponible = disponible
    setShow_offre(formValue)
    
}

export const handleChangeContrat = (event,formValue,setShow_offre) =>
{
    let contrat = event.target.value
    formValue.contrat = contrat
    setShow_offre(formValue)
    
}


export const handleChangeVille = (event,formValue,setShow_offre) =>
{
    let ville = event.target.value
    formValue.ville = ville
    setShow_offre(formValue)
    
}
