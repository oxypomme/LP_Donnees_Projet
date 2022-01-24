/**
 * Render an Leaflet icon from a FA icon
 *
 * @param {string} icon The FA classname
 * @param {string} color The css color
 * @param {string} size The class changing the size
 * @returns The Leaflet icon
 */
const fontAwesomeIcon = (icon, color = "black", size = "fa-2x") =>
	L.divIcon({
		html: `<i class="fa ${icon} ${size}" style="color: ${color}"></i>`,
		iconSize: [20, 20],
		className: "faIcon",
	});

// Generate map
const map = L.map("map", {
	center: [48.691, 6.184],
	zoom: 13,
});
(async () => {
	const layers = {};
	const overlays = {};
	// Adding OSM layer
	layers["OpenStreetMap"] = L.tileLayer(
		"http://{s}.tile.osm.org/{z}/{x}/{y}.png",
		{
			attribution:
				'&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors',
		}
	).addTo(map);
	try {
		// Adding GMaps layer
		layers["Google Maps"] = L.gridLayer.googleMutant({ type: "roadmap" });
	} catch (error) {
		console.warn(error);
	}

	// Regrouping data by category
	const pis = await (await fetch("api/pis")).json();
	pis.map((value) => {
		overlays[value.category.name] = [
			...(overlays[value.category.name] ?? []),
			value,
		];
	});

	const list = document.getElementById("list");
	for (const [groupName, group] of Object.entries(overlays)) {
		const markers = [];
		for (const {
			name,
			address,
			description,
			geometry,
			category,
			...data
		} of group) {
			let dataHTML = "";

			switch (category.name) {
				case "parking":
					dataHTML = `
					Places libres: ${data.places}<br/>
					Capacité: ${data.capacity}`;
					break;

				default:
					break;
			}

			markers.push(
				// Rendering marker
				L.marker([geometry.y, geometry.x], {
					icon: fontAwesomeIcon(category.icon, category.color),
				}).on("click", (e) => {
					// Showing list
					list.classList.add("showList");
					// Adding item
					list.innerHTML = `<div>
          <h4>${name}</h4>
          ${address}
          <hr />
          ${description}
          <hr />
					${dataHTML}</div>`;
				})
			);
		}
		// Regrouping markers
		overlays[groupName] = L.layerGroup(markers).addTo(map);
	}
	// Add filter
	L.control
		.layers(layers, overlays, {
			hideSingleBase: true,
		})
		.addTo(map);
})();

// Add current cursor
if ("geolocation" in navigator) {
	const current = L.marker([48.691, 6.184], {
		icon: fontAwesomeIcon("fa-circle", "dodgerblue", ""),
		opacity: 0,
	}).addTo(map);
	current.bindPopup(`<h4>Ma position</h4>`);

	// Watch for position
	navigator.geolocation.watchPosition(({ coords }) => {
		current.setLatLng([coords.latitude, coords.longitude]).setOpacity(1);
	});
}
