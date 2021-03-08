function isset() {
	var a = arguments,
		l = a.length,
		i = 0,
		undef;

	if (l === 0) {
		throw new Error('Empty isset');
	}

	while (i !== l) {
		if (a[i] === undef || a[i] === null) {
			return false;
		}
		i++;
	}
	return true;
}

function basename(path) {
	return path.replace(/\\/g,'/').replace( /.*\//, '' );
}

function eval_json($data) {
	var $res = eval('(' + $data + ')');
	return $res;
}

function lockComponent($component) {
	$('#comp-' + $component).attr('data-lock', 'Y');
}

function unlockComponent($component) {
	$('#comp-' + $component).removeAttr('data-lock');
}

function ReloadPage() {
	window.location.reload(true);
}