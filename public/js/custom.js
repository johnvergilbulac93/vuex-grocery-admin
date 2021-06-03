const backtoTop = document.querySelector('#backtoTop');

backtoTop.addEventListener('click',(e) => {
    e.preventDefault();
    window.scroll({top:0, left:0, behavior:'smooth'})
});

window.addEventListener('scroll',(e) => {
    if(window.scrollY >= 400){
         backtoTop.classList.remove('hidden')
    }
    else{
         backtoTop.classList.add('hidden')
    }
 });
