const container = document.querySelector('.counters');
const counters = document.querySelectorAll('.counter');

let activated = false;

window.addEventListener('scroll', ()=> {
    var scrollingCheck = container.offsetTop - container.offsetHeight - 200;
    if(pageYOffset > scrollingCheck && activated === false){
            counters.forEach(counter => {
                let count = parseInt(counter.dataset.start);
                counter.innerText = 0;

                function updateCount(){
                    const target = parseInt(counter.dataset.count);
                    if(count<target){
                        count++;
                        counter.innerText = formatNumber(count);
                        setTimeout(updateCount,1);
                    }else{
                        counter.innerText = formatNumber(target);
                    }
                }

                updateCount();

                activated = true;
            });
    }else if(pageYOffset < container.offsetTop - container.offsetHeight - 500 || pageYOffset === 0 && activated === true){
        counters.forEach(counter=>{
            counter.innerText = counter.dataset.start;
        });

        activated = false;
    }
        
});
function formatNumber(number)
{
    number = number.toFixed(0) + '';
    x = number.split('.');
    x1 = x[0];
    x2 = x.length > 1 ? '.' + x[1] : '';
    var rgx = /(\d+)(\d{3})/;
    while (rgx.test(x1)) {
        x1 = x1.replace(rgx, '$1' + ',' + '$2');
    }
    return x1 + x2;
}