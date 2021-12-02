db.createUser({
	user: "mysuper",
	pwd: "mysuper",
	roles: [
		{
			role: "readWrite",
			db: "nancy",
		},
	],
});
