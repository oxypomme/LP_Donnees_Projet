interface PI {
	_id: string;
	name: string;
	address: string;
	description: string;
	category: {
		name: string;
		icon: `fa-${string}`;
		color: `#${string}`;
	};
	geometry: {
		x: number;
		y: number;
	};
	comments: Comment[];
}

interface Parking extends PI {
	places: number;
	capacity: number;
}

interface Comment {
	_id: string;
	author: string;
	content: string;
}
