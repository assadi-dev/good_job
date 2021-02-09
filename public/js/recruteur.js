
const hamBtn = document.querySelector('#hamBtn');




function showBar() {
  
    let sidebar = document.querySelector('.sideBar');
    let sideOpen = sidebar.classList.contains("sideBarOpen");
    let iconBtn = document.querySelector('#hamBtn i');

   
    
    console.log(sideOpen);
    if (sideOpen == false)
    {
        iconBtn.classList.replace("fa-bars","fa-times");
        sidebar.classList.add("sideBarOpen");

    } else{
        sidebar.classList.remove("sideBarOpen");
        iconBtn.classList.replace("fa-times","fa-bars");
    }    
    

}



hamBtn.addEventListener("click", showBar);