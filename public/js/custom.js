const backtoTop = document.querySelector('#backtoTop');

backtoTop.addEventListener('click',(e) => {
    e.preventDefault();
    window.scroll({top:0, left:0, behavior:'smooth'})
});

window.addEventListener('scroll',() => {
    if(window.scrollY >= 500){
         backtoTop.classList.remove('hidden')
    }
    else{
         backtoTop.classList.add('hidden')
    }
 });
