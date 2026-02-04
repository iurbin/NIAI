// 1. CONFIGURATION
    container = document.getElementById('globe-container');
    /* const width = window.innerWidth-700;
    const height = window.innerHeight-150;
     */

    const citiesData = [
        { name: "New York", country: "United States of America", coords: [-74.006, 40.7128] },
        { name: "Los Angeles", country: "United States of America", coords: [-118.2437, 34.0522] },
        { name: "Brasilia", country: "Brazil", coords: [-47.9292, -15.7801] },
        { name: "Rio de Janeiro", country: "Brazil", coords: [-43.1729, -22.9068] },
        { name: "Sydney", country: "Australia", coords: [151.2093, -33.8688] },
        { name: "Melbourne", country: "Australia", coords: [144.9631, -37.8136] }
    ];

        
    const width = container.offsetWidth;
    const height = container.offsetHeight;
    const sensitivity = 75; // Controls drag speed
    let rotationTimer;
    // 2. SETUP SVG
    const svg = d3.select("#globe-container")
        .append("svg")
        .attr("width", width)
        .attr("height", height);

    // 3. DEFINE PROJECTION (ORTHOGRAPHIC = SPHERE)
    const projection = d3.geoOrthographic()
        .scale(300) 
        .center([0, 0])
        .rotate([0, -30]) // Initial rotation
        .translate([width / 2, height / 2]);

    const initialScale = projection.scale();
    const path = d3.geoPath().projection(projection);

    

    // 5. LOAD DATA
    // We are fetching a public TopoJSON file of the world (110m resolution)
    

    d3.json(dataUrl).then(world => {
        // 4. ADD WATER (Circle background)
        const water =  svg.append("circle")
                .attr("cx", width / 2)
                .attr("cy", height / 2)
                .attr("r", initialScale)
                .attr("class", "water")
                .on("click", reiniciar); // Click water to reiniciar
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
        // Convert TopoJSON to GeoJSON
        const countries = topojson.feature(world, world.objects.countries).features;

        // Draw Graticule (Grid lines)
        const graticule = d3.geoGraticule();
        const grid = svg.append("path")
            .datum(graticule())
            .attr("class", "graticule")
            .attr("d", path);

        // Draw Countries
        const map = svg.append("g")
            .selectAll("path")
            .data(countries)
            .enter().append("path")
            .attr("class", "country")
            .attr("d", path)
            .attr("fill", 'url(#country)')
            .on("click", clicked);

        function redraw() {
            // Update Water
            water.attr("r", projection.scale());

            // Update Map Paths
            path.projection(projection);
            mapGroup.selectAll("path").attr("d", path);

            // Update City Markers (if any exist)
            // Logic: We calculate screen x/y from lat/long
            // If the city is on the back of the globe, we hide it.
            markerGroup.selectAll(".city-marker")
                .attr("cx", d => projection(d.coords)[0])
                .attr("cy", d => projection(d.coords)[1])
                .style("display", d => {
                    // d3.geoCircle logic to check visibility is complex.
                    // Simple hack: Check the distance from the center of the projection.
                    // If distance is > projection radius, it's behind the globe.
                    // However, standard d3 projection returns null if clipped? 
                    // Let's use the 'd' generator for points or simple coordinate check:
                    
                    const coordinate = d.coords;
                    const gdistance = d3.geoDistance(coordinate, projection.invert([width/2, height/2]));
                    return (gdistance > 1.57) ? 'none' : 'inline'; // 1.57 radians is approx 90 degrees
                });

            markerGroup.selectAll(".city-label")
                .attr("x", d => projection(d.coords)[0] + 8)
                .attr("y", d => projection(d.coords)[1] + 4)
                .style("display", d => {
                     const coordinate = d.coords;
                     const gdistance = d3.geoDistance(coordinate, projection.invert([width/2, height/2]));
                     return (gdistance > 1.57) ? 'none' : 'inline';
                });
        }
        
        // 6. ANIMATION LOOP
        // Rotate the globe automatically
        function startRotation() {
            rotationTimer = d3.timer(function(elapsed) {
                const rotate = projection.rotate();
                const k = sensitivity / projection.scale();
                // Rotate longitude by 0.2 degrees per frame
                projection.rotate([rotate[0] + 0.2 * k, rotate[1]]);
                
                // Redraw paths
                /* path.projection(projection);
                svg.selectAll("path").attr("d", path); */
                redraw();
                // Keep water circle centered (if we were dragging)
                // In simple rotation, water stays static, but good practice
            });
        }

        

        startRotation();

        // 7. CLICK INTERACTION (Zoom to Continent/Country)
        function clicked(event, d) {
            // Stop rotation
            var selectedCountryObject = d;
            var selectedCountry = d.properties;
            var selectedCountryID = d.id;
            var currentCountry = d3.select(this).style('fill','#0a0aa3').style('stroke','white').style('stroke-width','2');
            
            if (rotationTimer) rotationTimer.stop();

            // Calculate the centroid (center) of the clicked country
            const centroid = d3.geoCentroid(d);
            
            // D3 Transition
            const rotate = projection.rotate();
            const currentScale = projection.scale();
            
            // Create an interpolator to smoothly transition numbers
            const r = d3.interpolate(rotate, [-centroid[0], -centroid[1]]);
            const s = d3.interpolate(currentScale, 900); // Zoom in to scale 900

            d3.transition()
                .duration(1500)
                .tween("rotate", function() {
                    return function(t) {
                        // Update projection
                        projection.rotate(r(t));
                        projection.scale(s(t));
                        
                        // Redraw
                        path.projection(projection);
                        svg.selectAll("path").attr("d", path);
                        grid.attr("d", path);

                        // Update water size
                        svg.selectAll(".water")
                           .attr("r", projection.scale());
                    };
                });
        }

        // 8. reiniciar FUNCTION
        function reiniciar(){
            // Stop any existing transitions
            d3.select(window).interrupt(); // or svg.interrupt()

            const rotate = projection.rotate();
            const currentScale = projection.scale();
            
            // Interpolate back to original scale and spinning
            const s = d3.interpolate(currentScale, initialScale);

            d3.transition()
                .duration(500)
                .tween("reiniciar", function() {
                    return function(t) {
                        projection.scale(s(t));
                        path.projection(projection);
                        svg.selectAll("path").attr("d", path);
                        grid.attr("d", path);
                        svg.selectAll(".water").attr("r", projection.scale());
                        svg.selectAll('.country')
                        .style('fill','url(#country)').style('stroke','').style('stroke-width','');
                    };
                })
                .on("end", function() {
                    // Restart auto-rotation
                    startRotation(); 
                });
        }

        

        
    });