
// Select all elements with the 'counter' class
const counters = document.querySelectorAll('.counter');

// speed: Lower is faster, Higher is slower
const speed = 1000; 

const animateCounters = (entries, observer) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const counter = entry.target;
            
            const updateCount = () => {
                // Get the target number from data-target
                const target = +counter.getAttribute('data-target');
                // Get current number displayed
                const count = +counter.innerText;
                
                // Calculate increment step (dynamic based on target size)
                const inc = target / speed;

                // Check if current count is less than target
                if (count < target) {
                    // Add increment and format to 2 decimal places if needed, or integer
                    // Math.ceil for integers, or toFixed for decimals
                    let nextVal = count + inc;
                    
                    // Formatting logic: Detect if target has decimals
                    if (target % 1 !== 0) {
                        counter.innerText = nextVal.toFixed(2);
                    } else {
                        counter.innerText = Math.ceil(nextVal);
                    }
                    
                    // Run function again after 1ms
                    setTimeout(updateCount, 1);
                } else {
                    // Ensure it ends on the exact target value
                    counter.innerText = target;
                }
            };

            updateCount();
            
            // Stop observing once animation starts (so it runs only once)
            observer.unobserve(counter);
        }
    });
};

// Create the Observer
const counterObserver = new IntersectionObserver(animateCounters, {
    root: null,        // viewport
    threshold: 0.5     // Trigger when 90% of the element is visible
});

// Attach observer to each counter
counters.forEach(counter => {
    counterObserver.observe(counter);
});