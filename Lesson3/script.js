function myScript () {
	console.log('script start');
	var images = document.getElementsByTagName('img');
	console.log (images);
	for (var i=1; i<images.length; i++) {
		images[i].onclick = showBigPicture;
		//images[i].onerror = showErr;
	}
}

function showBigPicture (ev) {
	var picField = document.getElementById('bigView'); // выбираем элемент в котором будет отображаться крупное изображение в галерее
	picField.innerHTML = '';  // помещаем в этот элемент пустую строку
	var e = ev.target;
	console.log ('target: '+ e);
	// var imageNum = e.id.split('_');
	var imageFileName = e.id;
	console.log ('filename: ' + imageFileName);
	var src = 'big/'+ imageFileName;
	var makeBigImg = document.createElement('img');
	makeBigImg.src = src;
	makeBigImg.width = '750';
	picField.appendChild(makeBigImg);
	makeBigImg.onerror = showErr;

	
	//var tag = '<img src=big/'+ imageNum[1] + '.jpg width="750px"/>';
	//console.log (tag);
	//picField.innerHTML = tag;
	//picField.onerror = showErr;


}

function showErr() {
	// console.log ('отобразить ошибку');
	// picField.innerHTML = '<p>Ошибка загрузки изображения</p>';
	alert ('File not found!');
}

window.onload = myScript;