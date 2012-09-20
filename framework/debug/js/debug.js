
var Debug = {
	_timeHashes: [],
	
    log: function() {
        if (typeof(window.console) === 'object' && typeof(window.console.log) === 'function') {
            console.log.apply(console, arguments);
        }
    },
    
    error: function() {
        if (typeof(window.console) === 'object' && typeof(window.console.error) === 'function') {    
            console.error.apply(console, arguments);
        }
    },
	
	time: function(hash) {
		if (typeof(window.console) === 'object' && typeof(window.console.time) === 'function' && typeof(Array.prototype.indexOf) === 'function') {
			var index = this._timeHashes.indexOf(hash);
			if (index >= 0) {
				this._timeHashes.splice(index, 1);
				console.timeEnd(hash);
			}
			else {
				this._timeHashes.push(hash);
				console.time(hash);
			}
		}
	}
};