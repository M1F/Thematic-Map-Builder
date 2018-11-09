var infoPanel = L.Control.extend({
    options: {
        position: 'bottomright'
    },

    onAdd: function (map) {
        var container = L.DomUtil.create('div', 'infoPanel');
		container.innerHTML = '<i>Выберите объект для получения информации...</i>';
        return container;
    },
	
	onUpdateKolonii: function (text, text2, text3, text4, text5, text6) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Начальник:</b><br>"+text5+"<br>"+"<b>Телефон начальника:</b><br>"+text6;
	},
	
	onUpdateAdministracii: function (text, text2, text3, text4, text5, text6) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Факс:</b><br>"+text5+"<br>"+"<b>Сайт:</b><br>"+text6;
	},
	
	onUpdateVoenkomati: function (text, text2, text3, text4, text5, text6) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Факс:</b><br>"+text5+"<br>"+"<b>Сайт:</b><br>"+text6;
	},
	
	onUpdateProkuraturi: function (text, text2, text3, text4, text5, text6) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Прокурор:</b><br>"+text4+"<br>"+"<b>Телефон:</b><br>"+text5+"<br>"+"<b>E-Mail:</b><br>"+text6;
	},
	
	onUpdateDomstarih: function (text, text2, text3, text4, text5, text6) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Факс:</b><br>"+text5+"<br>"+"<b>E-Mail:</b><br>"+text6;
	},
	onUpdateSizo: function (text, text2, text3, text4, text5) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Начальник:</b><br>"+text5;
	},
	
	onUpdatePolice: function (text, text2, text3, text4, text5, text6, text7) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Телефон приемной:</b><br>"+text5+"<br>"+"<b>Начальник:</b><br>"+text6+"<br>"+"<b>Сайт:</b><br>"+text7;
	},
	
	onUpdateDetdom: function (text, text2, text3, text4, text5) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4+"<br>"+"<b>Руководство:</b><br>"+text5;
	},
	
	onUpdateSudi: function (text, text2, text3, text4) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4;
	},
	
	onUpdateDomrebenka: function (text, text2, text3, text4) {
		this._container.innerHTML = "<b>Населенный пункт:</b><br>"+text+"<br>"+"<b>Полное наименование:</b><br>"+text2+"<br>"+"<b>Полный адрес:</b><br>"+text3+"<br>"+"<b>Телефон:</b><br>"+text4;
	}
	});