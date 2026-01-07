const container = document.querySelector('.counters');
const counters = document.querySelectorAll('.counter');

let activated = false;

window.addEventListener('scroll', ()=> {
    var scrollingCheck = container.offsetTop - container.offsetHeight - 200;
    if(pageYOffset > scrollingCheck && activated === false){
            counters.forEach(counter => {
                counter.innerText = 0;
                let count = 0;

                function updateCount(){
                    const target = parseInt(counter.dataset.count);
                    if(count<target){
                        count++;
                        counter.innerText = count;
                        setTimeout(updateCount,30);
                    }else{
                        counter.innerText = target;
                    }
                }

                updateCount();

                activated = true;
            });
    }else if(pageYOffset < container.offsetTop - container.offsetHeight - 500 || pageYOffset === 0 && activated === true){
        counters.forEach(counter=>{
            counter.innerText = 0;
        });

        activated = false;
    }
        
});