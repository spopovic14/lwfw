util = {

	makeAuthString: function makeAuthString(username, password) {
		return 'Basic ' + btoa(username + ':' + password);
	},

	ajax: function ajax(path, method, config) {
		var data = config.data;
		var username = config.username;
		var password = config.password;

		if(typeof data === 'undefined') {
			data = null;
		}

		var xhr = new XMLHttpRequest();
		xhr.open(method, path);
		if(typeof username !== 'undefined' && typeof password !== 'undefined') {
			encodedAuth = this.makeAuthString(username, password);
			xhr.setRequestHeader('Authorization', encodedAuth);
		}
		xhr.send(JSON.stringify(data));

		var ajaxObj = {

			successFunc: function() {},
			errorFunc: function() {},

			success: function(callback) {
				this.successFunc = callback;
				return this;
			},
			error: function(callback) {
				this.errorFunc = callback;
				return this;
			}

		};

		xhr.onreadystatechange = function() {
			var DONE = 4;
			var OK = 200;

			if(xhr.readyState === DONE) {
				if(xhr.status === OK) {
					ajaxObj.successFunc(xhr.responseText);
				}
				else {
					ajaxObj.errorFunc(xhr.status);
				}
			}
		}

		return ajaxObj;
	},

	setAttribute: function(node, name, value) {
		node.setAttribute(name, value);
	},

	createElement: function(type, attributes, children) {
		type = typeof name === 'undefined' ? 'div' : type;
		attributes = typeof attributes === 'undefined' ? [] : attributes;
		children = typeof children === 'undefined' ? [] : children;

		if(type === 'text') {
			return document.createTextNode(attributes);
		}

		var node = document.createElement(type);
		for(var key in attributes) {
			if(attributes.hasOwnProperty(key)) {
				var value = attributes[key];
				this.setAttribute(node, key, value);
			}
		}

		for(var i = 0; i < children.length; i++) {
			node.appendChild(children[i]);
		}

		return node;
	}

}
