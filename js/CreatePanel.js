var CreatePanel = L.Control.extend({
    options: {
        position: 'bottomright'
    },

    onAdd: function (map) {
        var container = L.DomUtil.create('div', 'CreatePanel');
		container.innerHTML = '<div id="create"></div>';
        return container;
    },
	
	update: function () {
			this._container.innerHTML = '<div id="create"></div>';
		},
	
	
	onUpdateDomrebenka: function (text, text2, text3, text4) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4;
	}
	
	});