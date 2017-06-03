router = {
	handleRoute: function() {
		var hash = window.location.hash.substr(1);

		for(var i = 0; i < router.routes.length; i++) {
			var route = router.routes[i].route;
			var handler = router.routes[i].handler;
			var res = route.exec(hash);

			if(res) {
				var args = [];
				var index = 1;

				while(res[index]) {
					args.push(res[index]);
					index = index + 1;
				}

				handler(args);
				return;
			}	
		}

		router.rootHandler([]);
	},

	create: function(root) {
		router.root = root;
		router.routes = [];
		window.addEventListener('hashchange', router.handleRoute);
	},

	add: function(route, handler) {
		if(route == router.root) {
			router.rootHandler = handler;
		}
		route = '^' + route.replace(/:id/g, '([0-9]+)') + '$';
		router.routes.push({ route: new RegExp(route), handler: handler});
	},

	goTo: function(route) {
		window.location.hash = '#' + route;
	}
};
