container = document.getElementById('globe-container');
// --- 1. CONFIG & DATA ---
    const width = container.offsetWidth;
    const height = container.offsetHeight;
    const sensitivity = 75;
    let rotationTimer;
    let activeCountry = null; // Track which country is focused

    // SAMPLE CITY DATA
    // In a real app, you might fetch this from a JSON file
    const citiesData = [
        { name: "New York", country: "United States of America", coords: [-74.006, 40.7128] },
        { name: "Las Vegas", country: "United States of America", coords: [-115.13639, 36.175] },
        { name: "Los Angeles", country: "United States of America", coords: [-118.2437, 34.0522] },
        { name: "Brasilia", country: "Brazil", coords: [-47.9292, -15.7801] },
        { name: "Rio de Janeiro", country: "Brazil", coords: [-43.1729, -22.9068] },
        { name: "Sydney", country: "Australia", coords: [151.2093, -33.8688] },
        { name: "Melbourne", country: "Australia", coords: [144.9631, -37.8136] }
    ];

    // --- 2. SETUP SVG ---
    const svg = d3.select("#globe-container")
        .append("svg")
        .attr("width", width)
        .attr("height", height);

    // --- 3. PROJECTION ---
    const projection = d3.geoOrthographic()
        .scale(300)
        .center([0, 0])
        .rotate([0, -30])
        .translate([width / 2, height / 2]);

    const initialScale = projection.scale();
    const path = d3.geoPath().projection(projection);
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
            const countryCities = citiesData.filter(c => c.country === clickedCountryName);

            // Setup Transition
            const centroid = d3.geoCentroid(d);
            const r = d3.interpolate(projection.rotate(), [-centroid[0], -centroid[1]]);
            const s = d3.interpolate(projection.scale(), 900);

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
                    addMarkers(countryCities);
                });
        }

        // --- 9. ADD MARKERS FUNCTION ---
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
                .on('click', function(event, d) {
                    alert('get news from ' + d.name);
                });

            // Add Text
            markerGroup.selectAll("text")
                .data(cities)
                .enter().append("text")
                .attr("class", "city-label")
                .text(d => d.name)
                .attr("x", d => projection(d.coords)[0] + 15)
                .attr("y", d => projection(d.coords)[1] + 4)
                .transition().duration(500)
                .style("opacity", 1); // Fade in
        }

        
    });