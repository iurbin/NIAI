container = document.getElementById('globe-container');
// --- 1. CONFIG & DATA ---
    const width = container.offsetWidth;
    const height = container.offsetHeight;
    var sensitivity = 50;
    var ZommClickedScale = 400;
    let rotationTimer;
    let activeCountry = null; // Track which country is focused

    
    let token = document.querySelector("meta[name='csrf-token']").content;
    
    function getCities(){
        const payload = { _token: token };
        fetch('./getcities', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json', // Tell the server you're sending JSON
        },
        body: JSON.stringify(payload), // Convert your JS object to a JSON string
        })
        .then(response => response.json())
        .then(data => {
            citiesData = data;
        })
        .catch(error => console.error('Error:', error));
    }
    citiesData = getCities();


    // --- 2. SETUP SVG ---
    const svg = d3.select("#globe-container")
        .append("svg")
        .attr("width", width)
        .attr("height", height);

    // --- 3. PROJECTION ---
    var scale = 175; //for mobile
    var isMobile = true;
    if(window.innerWidth > 1024 ){ 
        scale = 300;
        sensitivity = 110;
        ZommClickedScale = 900;
        isMobile = false;
    }else if(window.innerWidth > 768){
        scale = 250;
        ZommClickedScale = 900;
        sensitivity = 110;
        isMobile = false;
    }
    const projection = d3.geoOrthographic()
        .scale(scale)
        .center([0, 0])
        .rotate([40, -15])
        .translate([width / 2, height / 2]);

    const initialScale = projection.scale();
    const path = d3.geoPath().projection(projection);

    


    function redraw() {
            // Update Water
            water.attr("r", projection.scale());

            // Update Map Paths
            path.projection(projection);
            mapGroup.selectAll("path").attr("d", path);

            markerGroup.selectAll(".city-marker")
                .attr("cx", d => projection(d.coords)[0])
                .attr("cy", d => projection(d.coords)[1])
                .style("display", d => {
                    const coordinate = d.coords;
                    const gdistance = d3.geoDistance(coordinate, projection.invert([width/2, height/2]));
                    return (gdistance > 1.57) ? 'none' : 'inline'; // 1.57 radians is approx 90 degrees
                });
            
            addMarkers(citiesData);
        }
    
        function addMarkers(cities) {
            if (cities.length === 0) return;

            // Add Circles
            markerGroup.selectAll("circle")
                .data(cities)
                .enter().append("circle")
                .attr("class", "city-marker")
                .attr("r", 10) // marker radius
                .attr("cx", d => projection(d.coords)[0])
                .attr("cy", d => projection(d.coords)[1])
                .style('fill','url(#markerpath)')
                .on('click', function(event, d) {
                    $.ajax({
                        url: './getbycity?city=' + d.name, // Use the route URL
                        type: 'GET',
                        dataType: 'json', // Expecting a JSON response
                        success: function(response) {
                            
                            var modal_city_news = new bootstrap.Modal(document.getElementById('city_news'));
                            $('.location-feed').html(d.name +', ' + d.country);
                            $('.map-news-container').html(response.html);
                            modal_city_news.show();
                        },
                        error: function(xhr, status, error) {
                            console.error("An error occurred: " + error);
                        }
                    });
                    
                });

            
        }
    // --- 4. LAYERS (Order matters!) ---
    function startRotation() {
            rotationTimer = d3.timer(function(elapsed) {
                const rotate = projection.rotate();
                const k = sensitivity / projection.scale();
                projection.rotate([rotate[0] + 0.2 * k, rotate[1]]);
                
                redraw();
                
            });
        }
    // --- 10. RESET FUNCTION ---
        function reset() {
            activeCountry = null;
            
            // Remove markers immediately
            markerGroup.selectAll("*").remove();

            const s = d3.interpolate(projection.scale(), initialScale);

            d3.transition()
                .duration(1000)
                .tween("reset", function() {
                    return function(t) {
                        projection.scale(s(t));
                        svg.selectAll('.country')
                        .style('fill','url(#country)').style('stroke','').style('stroke-width','');
                        redraw();
                        
                    };
                })
                .on("end", function() {
                    startRotation();
                });
        }
    // A. Water (Background)
    const water = svg.append("circle")
        .attr("cx", width / 2)
        .attr("cy", height / 2)
        .attr("r", initialScale)
        .attr("class", "water")
        .on("click", reset);

    // B. Map Group (Countries + Grid)
    const mapGroup = svg.append("g");
    
    // C. Markers Group (Cities) - On top of map
    const markerGroup = svg.append("g");

   //DRAGGABLE FUNCTION
    const zoom = d3.zoom()
            .scaleExtent([1, 8]) // Restrict zoom levels (1x to 8x)
            // Optional: Use .translateExtent([[0, 0], [width, height]]) to prevent dragging the map off-screen
            .on("zoom", (event) => {
                // Apply the calculated transform (drag/pan/zoom) to the <g> element
                mapGroup.attr("transform", event.transform);
                markerGroup.attr("transform", event.transform);
                water.attr("transform", event.transform);
            });
    svg.call(zoom);

    d3.json(dataUrl).then(world => {
        const countries = topojson.feature(world, world.objects.countries).features;

        var defs = svg.append('defs');
        var pattern = defs.append('pattern')
                .attr('id','country')
                .attr('patternUnits','userSpaceOnUse')
                .attr('width','5')
                .attr('height','5');
            pattern.append('image')
            .attr('x','0')
            .attr('y','0')
            .attr('width','5')
            .attr('height','5')
            .attr('href',patternBackground);

        defs.append('pattern')
                .attr('id','markerpath')
                .attr('width','15')
                .attr('height','15').append('image')
            .attr('x','1')
            .attr('y','1')
            .attr('width','15')
            .attr('height','15')
            .attr('href',markerpath);

        
            

        

        // Draw Graticule
        const graticule = d3.geoGraticule();
        mapGroup.append("path")
            .datum(graticule())
            .attr("class", "graticule")
            .attr("d", path);

        // Draw Countries
        mapGroup.selectAll(".country")
            .data(countries)
            .enter().append("path")
            .attr("class", "country")
            .attr("d", path)
            .attr("fill", 'url(#country)')
            .on("click", clicked);
        // --- 7. HELPER: REDRAW EVERYTHING ---
        // Updates paths and markers based on current projection
        
        // --- 6. ANIMATION LOOP ---
        

        
            startRotation();
        

        


        // --- 8. CLICK INTERACTION ---
        function clicked(event, d) {
            // Get country name from TopoJSON properties
            // Note: 110m file uses 'name', sometimes requires distinct ID mapping.
            // For this demo, we match loosely on country name if available in properties.
            // The unpkg file puts names in `properties.name`.

            const clickedCountryName = d.properties.name;

            d3.select(this).style('fill','#0a0aa3').style('stroke','white').style('stroke-width','2');

            if (activeCountry === clickedCountryName) return; // Already active
            activeCountry = clickedCountryName;

            // Stop rotation
            if (rotationTimer) rotationTimer.stop();

            // Find Markers for this country

            //const countryCities = citiesData.filter(c => c.country === clickedCountryName);

            // Setup Transition
            const centroid = d3.geoCentroid(d);
            const r = d3.interpolate(projection.rotate(), [-centroid[0], -centroid[1]]);
            const s = d3.interpolate(projection.scale(), ZommClickedScale);

            // Clear existing markers immediately so they don't float during zoom
            markerGroup.selectAll("*").remove();

            d3.transition()
                .duration(1500)
                .tween("rotate", function() {
                    return function(t) {
                        projection.rotate(r(t));
                        projection.scale(s(t));
                        redraw();
                    };
                })
                .on("end", function() {
                    // AFTER Zoom finishes: Add markers
                    
                });
        }

        // --- 9. ADD MARKERS FUNCTION ---
        

        
    });