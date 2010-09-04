//Prototype introduces a conflict with JSON.stringify. Resolve here.
if(Array.prototype.toJSON) {
	delete Object.prototype.toJSON;
	delete Array.prototype.toJSON;
	delete Hash.prototype.toJSON;
	delete String.prototype.toJSON;
}
